<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Concert;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'items.bookable']);

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Search by booking reference or customer name
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('booking_reference', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(15);
        $concerts = Concert::published()->get();
        
        return view('admin.bookings.index', compact('bookings', 'concerts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $concerts = Concert::published()->upcoming()->get();
        $users = User::all();
        
        return view('admin.bookings.create', compact('concerts', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'concert_id' => 'required|exists:concerts,id',
            'ticket_quantity' => 'required|integer|min:1|max:10',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'special_requests' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        $concert = Concert::findOrFail($request->concert_id);

        // Check if enough tickets are available
        if ($concert->available_tickets < $request->ticket_quantity) {
            return back()->withErrors(['ticket_quantity' => 'Not enough tickets available. Only ' . $concert->available_tickets . ' tickets remaining.']);
        }

        DB::beginTransaction();
        
        try {
            // Create booking
            $booking = Booking::create([
                'user_id' => $request->user_id,
                'booking_reference' => Booking::generateBookingReference(),
                'total_amount' => $concert->base_price * $request->ticket_quantity,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'status' => $request->status,
                'payment_method' => 'admin_created',
                'special_requests' => $request->special_requests,
                'booking_date' => now()
            ]);

            // Create booking item for the concert
            $booking->items()->create([
                'bookable_type' => Concert::class,
                'bookable_id' => $concert->id,
                'quantity' => $request->ticket_quantity,
                'unit_price' => $concert->base_price,
                'total_price' => $concert->base_price * $request->ticket_quantity,
                'details' => ['ticket_category' => 'general']
            ]);

            // Update available tickets
            $concert->decrement('available_tickets', $request->ticket_quantity);

            // Set confirmed_at if status is confirmed
            if ($request->status === 'confirmed') {
                $booking->update(['confirmed_at' => now()]);
            }

            DB::commit();

            return redirect()->route('admin.bookings.show', $booking)
                ->with('success', 'Booking created successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'An error occurred while creating the booking. Please try again.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $booking->load(['user', 'items.bookable']);
        
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        $booking->load(['user', 'items.bookable']);
        $concerts = Concert::published()->get();
        $users = User::all();
        
        return view('admin.bookings.edit', compact('booking', 'concerts', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'special_requests' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        DB::beginTransaction();
        
        try {
            // Update booking
            $updateData = [
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'status' => $request->status,
                'special_requests' => $request->special_requests,
            ];

            // Handle status changes
            if ($request->status === 'confirmed' && $booking->status !== 'confirmed') {
                $updateData['confirmed_at'] = now();
            } elseif ($request->status === 'cancelled' && $booking->status !== 'cancelled') {
                $updateData['cancelled_at'] = now();
            }

            $booking->update($updateData);

            DB::commit();

            return redirect()->route('admin.bookings.show', $booking)
                ->with('success', 'Booking updated successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'An error occurred while updating the booking. Please try again.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        DB::beginTransaction();
        
        try {
            // Return tickets to available pool for each booking item
            foreach ($booking->items as $item) {
                if ($item->bookable_type === Concert::class) {
                    $concert = $item->bookable;
                    $concert->increment('available_tickets', $item->quantity);
                }
            }
            
            // Delete the booking (items will be deleted via cascade)
            $booking->delete();

            DB::commit();

            return redirect()->route('admin.bookings.index')
                ->with('success', 'Booking deleted successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'An error occurred while deleting the booking. Please try again.']);
        }
    }

    /**
     * Confirm a booking
     */
    public function confirm(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be confirmed.');
        }

        $booking->confirm();

        return back()->with('success', 'Booking confirmed successfully!');
    }

    /**
     * Cancel a booking
     */
    public function cancel(Booking $booking)
    {
        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'This booking cannot be cancelled.');
        }

        DB::beginTransaction();
        
        try {
            // Return tickets to available pool for each booking item
            foreach ($booking->items as $item) {
                if ($item->bookable_type === Concert::class) {
                    $concert = $item->bookable;
                    $concert->increment('available_tickets', $item->quantity);
                }
            }
            
            // Cancel the booking
            $booking->cancel();

            DB::commit();

            return back()->with('success', 'Booking cancelled successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'An error occurred while cancelling the booking. Please try again.']);
        }
    }
}
