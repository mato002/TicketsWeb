<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\TransportSchedule;
use App\Models\TransportBooking;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransportController extends Controller
{
    public function index(Request $request)
    {
        $schedules = TransportSchedule::with(['event', 'vehicle', 'route', 'pickupPoint'])
            ->active()
            ->available()
            ->where('departure_time', '>', now())
            ->when($request->event_id, function($query, $eventId) {
                return $query->forEvent($eventId);
            })
            ->when($request->pickup_city, function($query, $city) {
                return $query->whereHas('pickupPoint', function($q) use ($city) {
                    $q->where('city', $city);
                });
            })
            ->when($request->pickup_location, function($query, $location) {
                return $query->whereHas('pickupPoint', function($q) use ($location) {
                    $q->where(function($query) use ($location) {
                        $query->where('name', 'LIKE', "%{$location}%")
                              ->orWhere('address', 'LIKE', "%{$location}%")
                              ->orWhere('city', 'LIKE', "%{$location}%");
                    });
                });
            })
            ->when($request->date, function($query, $date) {
                return $query->whereDate('departure_time', $date);
            })
            ->when($request->date_from, function($query, $dateFrom) {
                return $query->whereDate('departure_time', '>=', $dateFrom);
            })
            ->when($request->date_to, function($query, $dateTo) {
                return $query->whereDate('departure_time', '<=', $dateTo);
            })
            ->when($request->min_price, function($query, $minPrice) {
                return $query->where('price', '>=', $minPrice);
            })
            ->when($request->max_price, function($query, $maxPrice) {
                return $query->where('price', '<=', $maxPrice);
            })
            ->orderBy('departure_time')
            ->paginate(12);

        $events = Event::select('id', 'title')->where('event_date', '>', now())->orderBy('title')->get();
        $cities = \App\Models\PickupPoint::select('city')->distinct()->pluck('city');

        return view('public.transport.index', compact('schedules', 'events', 'cities'));
    }

    public function show(TransportSchedule $schedule)
    {
        if (!$schedule->is_active || $schedule->departure_time <= now()) {
            abort(404);
        }

        $schedule->load(['event', 'vehicle', 'route', 'pickupPoint']);

        // Related schedules for the same event
        $relatedSchedules = TransportSchedule::with(['vehicle', 'route', 'pickupPoint'])
            ->where('event_id', $schedule->event_id)
            ->where('id', '!=', $schedule->id)
            ->active()
            ->available()
            ->where('departure_time', '>', now())
            ->take(3)
            ->get();

        return view('public.transport.show', compact('schedule', 'relatedSchedules'));
    }

    public function book(TransportSchedule $schedule, Request $request)
    {
        if (!$schedule->is_active || $schedule->departure_time <= now()) {
            return back()->with('error', 'This transport schedule is not available for booking.');
        }

        $request->validate([
            'passengers_count' => 'required|integer|min:1|max:' . $schedule->remaining_seats,
            'special_requests' => 'nullable|string|max:1000'
        ]);

        $user = Auth::user();
        $totalPrice = $schedule->price * $request->passengers_count;

        try {
            DB::beginTransaction();

            // Create a main booking record
            $booking = Booking::create([
                'user_id' => $user?->id,
                'booking_reference' => Booking::generateBookingReference(),
                'total_amount' => $totalPrice,
                'customer_name' => $user?->name ?? $request->customer_name,
                'customer_email' => $user?->email ?? $request->customer_email,
                'customer_phone' => $user?->phone ?? $request->customer_phone,
                'status' => 'pending',
                'booking_date' => now(),
                'is_guest_booking' => !$user,
            ]);

            // Create transport booking
            $transportBooking = TransportBooking::create([
                'booking_id' => $booking->id,
                'transport_schedule_id' => $schedule->id,
                'user_id' => $user?->id,
                'pickup_point_name' => $schedule->pickupPoint->name,
                'dropoff_point_name' => $schedule->route->end_location,
                'passengers_count' => $request->passengers_count,
                'total_price' => $totalPrice,
                'status' => 'confirmed',
                'special_requests' => $request->special_requests,
                'confirmed_at' => now()
            ]);

            // Update schedule seats
            $schedule->bookSeats($request->passengers_count);

            DB::commit();

            return redirect()->route('public.bookings.payment', $booking->id)
                ->with('success', 'Transport booking created successfully. Please complete payment.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Transport booking failed', [
                'schedule_id' => $schedule->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to create transport booking. Please try again.');
        }
    }

    public function eventTransport(Event $event)
    {
        $schedules = TransportSchedule::with(['vehicle', 'route', 'pickupPoint'])
            ->forEvent($event->id)
            ->active()
            ->available()
            ->where('departure_time', '>', now())
            ->orderBy('departure_time')
            ->get();

        return view('public.transport.event', compact('event', 'schedules'));
    }

    public function myBookings()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to view your transport bookings.');
        }

        $transportBookings = TransportBooking::with(['transportSchedule.event', 'transportSchedule.vehicle', 'transportSchedule.route', 'booking'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('public.transport.my-bookings', compact('transportBookings'));
    }

    public function cancelBooking(TransportBooking $transportBooking)
    {
        $user = Auth::user();
        
        if (!$user || $transportBooking->user_id !== $user->id) {
            abort(403);
        }

        if ($transportBooking->status === 'cancelled') {
            return back()->with('error', 'Booking is already cancelled.');
        }

        $schedule = $transportBooking->transportSchedule;
        
        // Check if cancellation is allowed (e.g., at least 2 hours before departure)
        if ($schedule->departure_time->diffInHours(now()) < 2) {
            return back()->with('error', 'Cannot cancel booking less than 2 hours before departure.');
        }

        try {
            DB::beginTransaction();

            $transportBooking->cancel();
            
            // Update main booking status if this was the only item
            $booking = $transportBooking->booking;
            if ($booking && $booking->items()->count() === 0) {
                $booking->update(['status' => 'cancelled']);
            }

            DB::commit();

            return back()->with('success', 'Transport booking cancelled successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Transport booking cancellation failed', [
                'transport_booking_id' => $transportBooking->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to cancel booking. Please try again.');
        }
    }

    public function search(Request $request)
    {
        $request->validate([
            'pickup_location' => 'required|string|max:200',
            'event_date' => 'required|date|after:today',
            'passengers' => 'required|integer|min:1|max:50'
        ]);

        $schedules = TransportSchedule::with(['event', 'vehicle', 'route', 'pickupPoint'])
            ->active()
            ->available()
            ->where('departure_time', '>', now())
            ->whereDate('departure_time', $request->event_date)
            ->where('available_seats', '>=', $request->passengers)
            ->where(function($query) use ($request) {
                $query->whereHas('pickupPoint', function($q) use ($request) {
                    $q->where('name', 'like', "%{$request->pickup_location}%")
                      ->orWhere('city', 'like', "%{$request->pickup_location}%")
                      ->orWhere('address', 'like', "%{$request->pickup_location}%");
                });
            })
            ->orderBy('departure_time')
            ->get();

        return view('public.transport.search-results', compact('schedules', 'request'));
    }
}
