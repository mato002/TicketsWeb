<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Route;
use App\Models\PickupPoint;
use App\Models\TransportSchedule;
use App\Models\TransportBooking;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function dashboard()
    {
        $stats = [
            'total_vehicles' => Vehicle::count(),
            'available_vehicles' => Vehicle::available()->count(),
            'total_routes' => Route::count(),
            'active_routes' => Route::active()->count(),
            'total_pickup_points' => PickupPoint::count(),
            'active_pickup_points' => PickupPoint::active()->count(),
            'total_schedules' => TransportSchedule::count(),
            'active_schedules' => TransportSchedule::active()->count(),
            'total_bookings' => TransportBooking::count(),
            'confirmed_bookings' => TransportBooking::confirmed()->count(),
        ];

        // Recent bookings
        $recentBookings = TransportBooking::with(['user', 'transportSchedule.event'])
            ->latest()
            ->take(5)
            ->get();

        // Upcoming schedules
        $upcomingSchedules = TransportSchedule::with(['event', 'vehicle', 'route'])
            ->active()
            ->where('departure_time', '>', now())
            ->orderBy('departure_time')
            ->take(10)
            ->get();

        // Vehicle utilization
        $vehicleUtilization = Vehicle::with(['transportSchedules' => function($query) {
                $query->whereMonth('departure_time', now()->month);
            }])
            ->get()
            ->map(function($vehicle) {
                $totalSeats = $vehicle->transportSchedules->sum('available_seats');
                $bookedSeats = $vehicle->transportSchedules->sum('booked_seats');
                $utilization = $totalSeats > 0 ? ($bookedSeats / $totalSeats) * 100 : 0;
                
                return [
                    'vehicle' => $vehicle,
                    'total_seats' => $totalSeats,
                    'booked_seats' => $bookedSeats,
                    'utilization' => round($utilization, 1)
                ];
            });

        // Popular routes
        $popularRoutes = Route::with(['transportSchedules' => function($query) {
                $query->withCount('transportBookings')
                      ->whereMonth('departure_time', now()->month);
            }])
            ->get()
            ->map(function($route) {
                return [
                    'route' => $route,
                    'total_bookings' => $route->transportSchedules->sum('transport_bookings_count')
                ];
            })
            ->sortByDesc('total_bookings')
            ->take(5)
            ->values();

        // Monthly revenue
        $monthlyRevenue = TransportBooking::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->confirmed()
            ->sum('total_price');

        return view('admin.transport.dashboard', compact(
            'stats',
            'recentBookings',
            'upcomingSchedules',
            'vehicleUtilization',
            'popularRoutes',
            'monthlyRevenue'
        ));
    }

    public function bookings(Request $request)
    {
        $bookings = TransportBooking::with(['user', 'booking', 'transportSchedule.event', 'transportSchedule.vehicle'])
            ->when($request->status, function($query, $status) {
                if ($status === 'confirmed') {
                    $query->confirmed();
                } elseif ($status === 'cancelled') {
                    $query->cancelled();
                } elseif ($status === 'completed') {
                    $query->completed();
                }
            })
            ->when($request->date_from, function($query, $dateFrom) {
                $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($request->date_to, function($query, $dateTo) {
                $query->whereDate('created_at', '<=', $dateTo);
            })
            ->when($request->search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('pickup_point_name', 'like', "%{$search}%")
                      ->orWhere('dropoff_point_name', 'like', "%{$search}%")
                      ->orWhereHas('user', function($userQuery) use ($search) {
                          $userQuery->where('name', 'like', "%{$search}%")
                                   ->orWhere('email', 'like', "%{$search}%");
                      })
                      ->orWhereHas('booking', function($bookingQuery) use ($search) {
                          $bookingQuery->where('booking_reference', 'like', "%{$search}%");
                      });
                });
            })
            ->latest()
            ->paginate(20);

        return view('admin.transport.bookings.index', compact('bookings'));
    }

    public function showBooking(TransportBooking $booking)
    {
        $booking->load(['user', 'booking', 'transportSchedule.event', 'transportSchedule.vehicle', 'transportSchedule.route', 'transportSchedule.pickupPoint']);

        return view('admin.transport.bookings.show', compact('booking'));
    }

    public function cancelBooking(TransportBooking $booking)
    {
        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Booking is already cancelled.');
        }

        $booking->cancel();

        return back()->with('success', 'Transport booking cancelled successfully.');
    }

    public function confirmBooking(TransportBooking $booking)
    {
        if ($booking->status !== 'confirmed') {
            $booking->confirm();
        }

        return back()->with('success', 'Transport booking confirmed successfully.');
    }

    public function completeBooking(TransportBooking $booking)
    {
        if ($booking->status === 'completed') {
            return back()->with('error', 'Booking is already completed.');
        }

        $booking->complete();

        return back()->with('success', 'Transport booking marked as completed.');
    }
}
