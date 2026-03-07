<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Accommodation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user's bookings with related data
        $bookings = $user->bookings()
            ->with(['event'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get upcoming events for recommendations
        $upcomingEvents = Event::where('status', 'published')
            ->whereNotNull('event_date')
            ->where('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->limit(3)
            ->get();

        // Get booking statistics
        $bookingStats = [
            'total_bookings' => $user->bookings()->count(),
            'confirmed_bookings' => $user->bookings()->confirmed()->count(),
            'pending_bookings' => $user->bookings()->pending()->count(),
            'cancelled_bookings' => $user->bookings()->cancelled()->count(),
        ];

        return view('public.dashboard.index', compact('bookings', 'upcomingEvents', 'bookingStats'));
    }

    public function bookings()
    {
        $user = Auth::user();
        
        $bookings = $user->bookings()
            ->with(['event'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('public.dashboard.bookings', compact('bookings'));
    }

    public function bookingDetails(Booking $booking)
    {
        // Ensure the booking belongs to the authenticated user
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to booking details.');
        }

        $booking->load(['concert', 'user']);

        return view('public.dashboard.booking-details', compact('booking'));
    }

    public function downloadTicket(Booking $booking)
    {
        // Ensure the booking belongs to the authenticated user
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to ticket.');
        }

        // Only allow download for confirmed bookings
        if ($booking->status !== 'confirmed') {
            return redirect()->back()->with('error', 'Ticket is not available for download yet.');
        }

        // Generate QR code data
        $qrData = [
            'booking_reference' => $booking->booking_reference,
            'concert_name' => $booking->concert->name,
            'date' => $booking->concert->date,
            'venue' => $booking->concert->venue,
            'ticket_quantity' => $booking->ticket_quantity,
            'customer_name' => $booking->customer_name,
        ];

        return view('public.dashboard.ticket', compact('booking', 'qrData'));
    }

    public function cancelBooking(Request $request, Booking $booking)
    {
        // Ensure the booking belongs to the authenticated user
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to booking.');
        }

        // Only allow cancellation of pending or confirmed bookings
        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return redirect()->back()->with('error', 'This booking cannot be cancelled.');
        }

        $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        $booking->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'special_requests' => $booking->special_requests . "\n\nCancellation Reason: " . $request->cancellation_reason,
        ]);

        return redirect()->route('public.dashboard.bookings')->with('success', 'Booking cancelled successfully.');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('public.dashboard.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
        ]);

        $user->update($request->only([
            'name', 'email', 'phone', 'address', 'city', 'state', 'zip_code', 'country'
        ]));

        return redirect()->route('public.dashboard.profile')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('public.dashboard.profile')->with('success', 'Password updated successfully.');
    }

    public function support()
    {
        $user = Auth::user();
        
        // Get recent bookings for support context
        $recentBookings = $user->bookings()
            ->with(['event'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('public.dashboard.support', compact('recentBookings'));
    }

    public function submitSupport(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'category' => 'required|string|in:booking_issue,accommodation_issue,payment_issue,technical_issue,other',
            'priority' => 'required|string|in:low,medium,high,urgent',
            'description' => 'required|string|max:2000',
            'booking_reference' => 'nullable|string|exists:bookings,booking_reference',
        ]);

        // Here you would typically save the support ticket to a database
        // For now, we'll just redirect with a success message
        // You can implement a SupportTicket model and save the data

        return redirect()->route('public.dashboard.support')->with('success', 'Support ticket submitted successfully. We will get back to you within 24 hours.');
    }

    public function notifications()
    {
        $user = Auth::user();
        
        // Get user's notifications (you can implement a notification system)
        $notifications = collect([
            // Sample notifications - replace with actual notification system
            [
                'id' => 1,
                'title' => 'Booking Confirmed',
                'message' => 'Your booking for "Summer Music Festival" has been confirmed.',
                'type' => 'success',
                'created_at' => now()->subHours(2),
                'read' => false,
            ],
            [
                'id' => 2,
                'title' => 'Payment Received',
                'message' => 'Payment for booking #BK123456 has been processed successfully.',
                'type' => 'info',
                'created_at' => now()->subDays(1),
                'read' => true,
            ],
        ]);

        return view('public.dashboard.notifications', compact('notifications'));
    }

    public function payments(Request $request)
    {
        $user = Auth::user();
        
        // Build query for user's payments through bookings
        $paymentsQuery = $user->bookings()
            ->with(['event'])
            ->whereNotNull('payment_details')
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->filled('status')) {
            $paymentsQuery->where('status', $request->status);
        }

        if ($request->filled('payment_method')) {
            $paymentsQuery->where('payment_method', $request->payment_method);
        }

        if ($request->filled('date_from')) {
            $paymentsQuery->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $paymentsQuery->whereDate('created_at', '<=', $request->date_to);
        }

        $payments = $paymentsQuery->paginate(15);

        // Calculate statistics
        $allBookings = $user->bookings()->whereNotNull('payment_details')->get();
        $successfulPayments = $allBookings->where('status', 'confirmed')->count();
        $pendingPayments = $allBookings->where('status', 'pending')->count();
        $totalSpent = $allBookings->where('status', 'confirmed')->sum('total_amount');

        // Transform bookings to payment-like objects for the view
        $paymentCollection = $payments->getCollection()->map(function ($booking) {
            $paymentDetails = json_decode($booking->payment_details ?? '{}', true);
            
            return (object) [
                'id' => $booking->id,
                'transaction_id' => $booking->transaction_id ?? $booking->mpesa_receipt ?? 'N/A',
                'booking' => $booking,
                'amount' => $booking->total_amount,
                'payment_method' => $booking->payment_method ?? 'credit_card',
                'status' => $booking->status,
                'created_at' => $booking->created_at,
                'payment_details' => $paymentDetails,
            ];
        });

        $payments->setCollection($paymentCollection);

        return view('public.dashboard.payments', compact(
            'payments', 
            'successfulPayments', 
            'pendingPayments', 
            'totalSpent'
        ));
    }

    public function paymentReceipt($paymentId)
    {
        $user = Auth::user();
        $booking = $user->bookings()->findOrFail($paymentId);
        
        $paymentDetails = json_decode($booking->payment_details ?? '{}', true);
        
        return view('public.dashboard.receipt', compact('booking', 'paymentDetails'));
    }

    public function paymentInvoice($paymentId)
    {
        $user = Auth::user();
        $booking = $user->bookings()->findOrFail($paymentId);
        
        // Generate PDF invoice (you can use a PDF library like dompdf)
        // For now, return a simple HTML view
        return view('public.dashboard.invoice', compact('booking'));
    }
}


