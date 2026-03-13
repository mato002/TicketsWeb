<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Accommodation;
use App\Models\TransportSchedule;
use App\Models\TransportBooking;
use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\User;
use App\Services\TicketService;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function show(Event $event)
    {
        if ($event->status !== 'published') {
            abort(404);
        }

        return view('public.booking.show', compact('event'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'ticket_quantity' => 'required|integer|min:1|max:10',
            'ticket_category' => 'required|string',
        ]);

        $event = Event::findOrFail($request->event_id);
        $cart = Session::get('cart', []);
        
        // Calculate ticket price based on category
        $ticketPrice = $this->calculateTicketPrice($event, $request->ticket_category);
        
        $cartItem = [
            'event_id' => $event->id,
            'ticket_quantity' => $request->ticket_quantity,
            'ticket_category' => $request->ticket_category,
            'ticket_price' => $ticketPrice,
            'total_price' => $ticketPrice * $request->ticket_quantity,
        ];

        $cart[] = $cartItem;
        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Tickets added to cart!');
    }

    public function cart()
    {
        try {
            $cart = Session::get('cart', []);
            $events = [];
            $total = 0;

            foreach ($cart as $item) {
                if (!isset($item['event_id'])) {
                    continue; // Skip invalid cart items
                }
                
                $event = Event::find($item['event_id']);
                if ($event) {
                    $events[] = [
                        'event' => $event,
                        'quantity' => $item['ticket_quantity'] ?? 1,
                        'category' => $item['ticket_category'] ?? 'general',
                        'price' => $item['ticket_price'] ?? $event->base_price,
                        'total' => $item['total_price'] ?? ($item['ticket_quantity'] ?? 1) * ($item['ticket_price'] ?? $event->base_price),
                    ];
                    $total += $item['total_price'] ?? (($item['ticket_quantity'] ?? 1) * ($item['ticket_price'] ?? $event->base_price));
                }
            }

            return view('public.booking.cart', compact('events', 'total'));
        } catch (\Exception $e) {
            \Log::error('Cart error: ' . $e->getMessage());
            \Log::error('Cart trace: ' . $e->getTraceAsString());
            
            // Return a simple error page instead of redirecting
            return response()->view('public.booking.cart-error', [
                'error' => $e->getMessage(),
                'cart' => Session::get('cart', [])
            ], 500);
        }
    }

    public function removeFromCart($index)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$index])) {
            unset($cart[$index]);
            $cart = array_values($cart); // Re-index array
            Session::put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
        }

        return redirect()->route('cart.index')->with('error', 'Item not found in cart!');
    }

    public function clearCart()
    {
        Session::forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared!');
    }

    public function accommodation()
    {
        try {
            $cart = Session::get('cart', []);
            
            // For testing purposes, let's show accommodations even if cart is empty
            // if (empty($cart)) {
            //     return redirect()->route('public.events.index')->with('error', 'Your cart is empty!');
            // }

            // Get cities from cart items
            $eventIds = collect($cart)->pluck('event_id');
            $cities = Event::whereIn('id', $eventIds)->distinct()->pluck('city');

            // Try to get active accommodations first
            $accommodations = Accommodation::active()->orderBy('rating', 'desc');
            
            // If no active accommodations found, get all accommodations
            if ($accommodations->count() == 0) {
                $accommodations = Accommodation::orderBy('rating', 'desc');
            }
            
            // Filter by cities if available
            if (!$cities->isEmpty()) {
                $accommodations = $accommodations->whereIn('city', $cities);
            }
            
            $accommodations = $accommodations->paginate(12);

            // Debug logging
            \Log::info('Accommodations found: ' . $accommodations->count());
            \Log::info('Cart: ' . json_encode($cart));
            \Log::info('Cities: ' . json_encode($cities->toArray()));

            return view('public.booking.accommodation', compact('accommodations'));
        } catch (\Exception $e) {
            \Log::error('Accommodation page error: ' . $e->getMessage());
            return redirect()->route('public.events.index')->with('error', 'Unable to load accommodation options. Please try again.');
        }
    }

    public function addAccommodation(Request $request, Accommodation $accommodation)
    {
        $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1|max:10',
        ]);

        $nights = \Carbon\Carbon::parse($request->check_in)->diffInDays($request->check_out);
        $totalPrice = $accommodation->price_per_night * $nights;

        $accommodationBooking = [
            'accommodation_id' => $accommodation->id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'guests' => $request->guests,
            'nights' => $nights,
            'price_per_night' => $accommodation->price_per_night,
            'total_price' => $totalPrice,
        ];

        Session::put('accommodation_booking', $accommodationBooking);

        return redirect()->route('public.booking.checkout')->with('success', 'Accommodation added to booking!');
    }

    public function transport()
    {
        try {
            $cart = Session::get('cart', []);
            
            if (empty($cart)) {
                return redirect()->route('public.events.index')->with('error', 'Your cart is empty!');
            }

            // Get event IDs from cart
            $eventIds = collect($cart)->pluck('event_id');
            
            // Get transport schedules for these events
            $schedules = TransportSchedule::with(['event', 'vehicle', 'route', 'pickupPoint'])
                ->whereIn('event_id', $eventIds)
                ->active()
                ->available()
                ->where('departure_time', '>', now())
                ->orderBy('departure_time')
                ->get()
                ->groupBy('event_id');

            return view('public.booking.transport', compact('schedules'));
        } catch (\Exception $e) {
            \Log::error('Transport page error: ' . $e->getMessage());
            return redirect()->route('public.events.index')->with('error', 'Unable to load transport options. Please try again.');
        }
    }

    public function addTransport(Request $request, TransportSchedule $schedule)
    {
        $request->validate([
            'passengers_count' => 'required|integer|min:1|max:' . $schedule->remaining_seats,
            'special_requests' => 'nullable|string|max:1000'
        ]);

        $totalPrice = $schedule->price * $request->passengers_count;

        $transportBooking = [
            'schedule_id' => $schedule->id,
            'passengers_count' => $request->passengers_count,
            'special_requests' => $request->special_requests,
            'pickup_point_name' => $schedule->pickupPoint->name,
            'dropoff_point_name' => $schedule->route->end_location,
            'departure_time' => $schedule->departure_time->format('Y-m-d H:i:s'),
            'arrival_time' => $schedule->arrival_time->format('Y-m-d H:i:s'),
            'price_per_person' => $schedule->price,
            'total_price' => $totalPrice,
        ];

        Session::put('transport_booking', $transportBooking);

        return redirect()->route('public.booking.checkout')->with('success', 'Transport added to booking!');
    }

    public function checkout()
    {
        $cart = Session::get('cart', []);
        $accommodationBooking = Session::get('accommodation_booking');
        $transportBooking = Session::get('transport_booking');

        if (empty($cart)) {
            return redirect()->route('public.events.index')->with('error', 'Your cart is empty!');
        }

        $events = [];
        $total = 0;

        foreach ($cart as $item) {
            $event = Event::find($item['event_id']);
            if ($event) {
                $events[] = [
                    'event' => $event,
                    'quantity' => $item['ticket_quantity'],
                    'category' => $item['ticket_category'],
                    'price' => $item['ticket_price'],
                    'total' => $item['total_price'],
                ];
                $total += $item['total_price'];
            }
        }

        $accommodation = null;
        if ($accommodationBooking) {
            $accommodation = Accommodation::find($accommodationBooking['accommodation_id']);
            $total += $accommodationBooking['total_price'];
        }

        $transportSchedule = null;
        if ($transportBooking) {
            $transportSchedule = TransportSchedule::find($transportBooking['schedule_id']);
            $total += $transportBooking['total_price'];
        }

        // Check if user is authenticated, otherwise show guest checkout
        $user = Auth::user();
        $isGuest = !$user;

        return view('public.booking.checkout', compact('events', 'accommodation', 'accommodationBooking', 'transportSchedule', 'transportBooking', 'total', 'user', 'isGuest'));
    }

    public function processBooking(Request $request)
    {
        // Validate based on whether user is guest or authenticated
        if (Auth::check()) {
            $request->validate([
                'customer_phone' => 'required|string|max:20',
                'payment_method' => 'required|string|in:mpesa,credit_card,paypal,bank_transfer',
                'special_requests' => 'nullable|string|max:500',
            ]);
        } else {
            $request->validate([
                'customer_name' => 'required|string|max:255',
                'customer_email' => 'required|email|max:255',
                'customer_phone' => 'required|string|max:20',
                'payment_method' => 'required|string|in:mpesa,credit_card,paypal,bank_transfer',
                'create_account' => 'nullable|boolean',
                'password' => 'required_if:create_account,1|string|min:8|confirmed',
                'special_requests' => 'nullable|string|max:500',
            ]);
        }

        // Validate payment method specific fields
        if ($request->payment_method === 'mpesa') {
            $request->validate([
                'mpesa_phone' => 'required|string|min:10|max:15',
                'mpesa_phone_confirm' => 'required|string|same:mpesa_phone',
            ]);
        } elseif ($request->payment_method === 'credit_card') {
            $request->validate([
                'card_number' => 'required|string',
                'expiry_date' => 'required|string',
                'cvv' => 'required|string',
                'cardholder_name' => 'required|string',
            ]);
        }

        $cart = Session::get('cart', []);
        $accommodationBooking = Session::get('accommodation_booking');
        $transportBooking = Session::get('transport_booking');

        if (empty($cart)) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty!'
            ], 400);
        }

        DB::beginTransaction();
        
        try {
            $user = Auth::user();
            
            // Handle guest checkout or create account
            if (!$user) {
                // Check if user wants to create account
                if ($request->create_account) {
                    // Create new user account
                    $user = User::create([
                        'name' => $request->customer_name,
                        'email' => $request->customer_email,
                        'password' => bcrypt($request->password),
                        'email_verified_at' => now(), // Auto-verify for checkout
                    ]);
                    
                    // Log in the new user
                    Auth::login($user);
                } else {
                    // Create a temporary guest user record
                    $user = User::create([
                        'name' => $request->customer_name,
                        'email' => $request->customer_email,
                        'password' => bcrypt(Str::random(32)), // Random password for guest
                        'is_guest' => true,
                        'email_verified_at' => now(),
                    ]);
                    
                    // Don't log in guest users, but use their ID for booking
                }
            }

            // Calculate total amount
            $totalAmount = 0;
            foreach ($cart as $item) {
                $totalAmount += $item['total_price'];
            }
            if ($accommodationBooking) {
                $totalAmount += $accommodationBooking['total_price'];
            }
            if ($transportBooking) {
                $totalAmount += $transportBooking['total_price'];
            }

            // Create booking record
            $booking = Booking::create([
                'user_id' => $user->id,
                'booking_reference' => Booking::generateBookingReference(),
                'total_amount' => $totalAmount,
                'customer_name' => $request->customer_name ?? $user->name,
                'customer_email' => $request->customer_email ?? $user->email,
                'customer_phone' => $request->customer_phone,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'booking_date' => now(),
                'special_requests' => $request->special_requests,
                'is_guest_booking' => !Auth::check(),
            ]);

            // Store M-Pesa phone number if provided
            if ($request->payment_method === 'mpesa') {
                $booking->mpesa_phone = $request->mpesa_phone;
                $booking->save();
            }

            // Process event tickets
            foreach ($cart as $item) {
                $event = Event::find($item['event_id']);
                if ($event) {
                    // Check if enough tickets available
                    if ($event->available_tickets < $item['ticket_quantity']) {
                        throw new \Exception('Not enough tickets available for ' . $event->title);
                    }

                    // Create booking item
                    BookingItem::create([
                        'booking_id' => $booking->id,
                        'bookable_type' => Event::class,
                        'bookable_id' => $event->id,
                        'quantity' => $item['ticket_quantity'],
                        'unit_price' => $item['ticket_price'],
                        'total_price' => $item['total_price'],
                        'details' => ['ticket_category' => $item['ticket_category']]
                    ]);

                    // Update available tickets
                    $event->decrement('available_tickets', $item['ticket_quantity']);
                }
            }

            // Process accommodation if selected
            if ($accommodationBooking) {
                $accommodation = Accommodation::find($accommodationBooking['accommodation_id']);
                if ($accommodation) {
                    BookingItem::create([
                        'booking_id' => $booking->id,
                        'bookable_type' => Accommodation::class,
                        'bookable_id' => $accommodation->id,
                        'quantity' => $accommodationBooking['nights'],
                        'unit_price' => $accommodationBooking['price_per_night'],
                        'total_price' => $accommodationBooking['total_price'],
                        'details' => [
                            'check_in' => $accommodationBooking['check_in'],
                            'check_out' => $accommodationBooking['check_out'],
                            'guests' => $accommodationBooking['guests']
                        ]
                    ]);
                }
            }

            // Process transport if selected
            if ($transportBooking) {
                $transportSchedule = TransportSchedule::find($transportBooking['schedule_id']);
                if ($transportSchedule) {
                    // Create transport booking
                    $transportBookingRecord = TransportBooking::create([
                        'booking_id' => $booking->id,
                        'transport_schedule_id' => $transportSchedule->id,
                        'user_id' => $user->id,
                        'pickup_point_name' => $transportBooking['pickup_point_name'],
                        'dropoff_point_name' => $transportBooking['dropoff_point_name'],
                        'passengers_count' => $transportBooking['passengers_count'],
                        'total_price' => $transportBooking['total_price'],
                        'status' => 'confirmed',
                        'special_requests' => $transportBooking['special_requests'] ?? null,
                        'confirmed_at' => now()
                    ]);

                    // Update schedule seats
                    $transportSchedule->bookSeats($transportBooking['passengers_count']);

                    // Create booking item for transport
                    BookingItem::create([
                        'booking_id' => $booking->id,
                        'bookable_type' => TransportSchedule::class,
                        'bookable_id' => $transportSchedule->id,
                        'quantity' => $transportBooking['passengers_count'],
                        'unit_price' => $transportBooking['price_per_person'],
                        'total_price' => $transportBooking['total_price'],
                        'details' => [
                            'pickup_point' => $transportBooking['pickup_point_name'],
                            'dropoff_point' => $transportBooking['dropoff_point_name'],
                            'departure_time' => $transportBooking['departure_time'],
                            'arrival_time' => $transportBooking['arrival_time'],
                            'transport_booking_id' => $transportBookingRecord->id
                        ]
                    ]);
                }
            }

            DB::commit();

            // Clear cart
            Session::forget('cart');
            Session::forget('accommodation_booking');
            Session::forget('transport_booking');

            // Process payment based on method
            if ($request->payment_method === 'mpesa') {
                // Initiate M-Pesa payment
                $mpesaService = app(\App\Services\MpesaService::class);
                $mpesaResult = $mpesaService->initiatePayment($booking, $request->mpesa_phone);
                
                if ($mpesaResult['success']) {
                    $booking->update([
                        'transaction_id' => $mpesaResult['transaction_id'],
                        'payment_details' => json_encode($mpesaResult)
                    ]);
                    
                    return response()->json([
                        'success' => true,
                        'message' => 'M-Pesa payment initiated! Please check your phone for the PIN prompt.',
                        'redirect_url' => route('payment.show', $booking)
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'M-Pesa payment failed: ' . $mpesaResult['message']
                    ], 400);
                }
            } else {
                // For other payment methods, redirect to payment page
                return response()->json([
                    'success' => true,
                    'message' => 'Booking created successfully! Please complete your payment.',
                    'redirect_url' => route('payment.show', $booking)
                ]);
            }

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Booking failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function confirmation(Booking $booking)
    {
        if ($booking->status !== 'confirmed') {
            return redirect()->route('public.home')
                ->with('error', 'This booking is not confirmed yet.');
        }

        $booking->load(['user', 'items.bookable']);
        
        return view('public.booking.confirmation', compact('booking'));
    }

    public function confirmationFromSession()
    {
        $bookingId = Session::get('booking_id');
        
        if (!$bookingId) {
            return redirect()->route('public.home')->with('error', 'No booking found.');
        }

        $booking = Booking::with(['user', 'items.bookable'])->find($bookingId);
        
        if (!$booking) {
            return redirect()->route('public.home')->with('error', 'Booking not found.');
        }

        // Clear booking ID from session
        Session::forget('booking_id');

        return view('public.booking.confirmation', compact('booking'));
    }

    private function calculateTicketPrice(Event $event, $category)
    {
        $ticketCategories = $event->ticket_categories ?? [];
        
        if (isset($ticketCategories[$category])) {
            return $ticketCategories[$category]['price'] ?? $event->base_price;
        }

        return $event->base_price;
    }
}

