<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransportSchedule;
use App\Models\Event;
use App\Models\Vehicle;
use App\Models\Route;
use App\Models\PickupPoint;
use Illuminate\Http\Request;

class TransportScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $schedules = TransportSchedule::with(['event', 'vehicle', 'route', 'pickupPoint', 'transportBookings'])
            ->when($request->event_id, function($query, $eventId) {
                return $query->forEvent($eventId);
            })
            ->when($request->vehicle_id, function($query, $vehicleId) {
                return $query->where('vehicle_id', $vehicleId);
            })
            ->when($request->date, function($query, $date) {
                return $query->whereDate('departure_time', $date);
            })
            ->when($request->status, function($query, $status) {
                if ($status === 'active') {
                    $query->active();
                } elseif ($status === 'inactive') {
                    $query->where('is_active', false);
                } elseif ($status === 'fully_booked') {
                    $query->whereRaw('booked_seats >= available_seats');
                }
            })
            ->latest('departure_time')
            ->paginate(15);

        $events = Event::select('id', 'title')->orderBy('title')->get();
        $vehicles = Vehicle::select('id', 'make', 'model', 'registration_number')->orderBy('make')->get();

        return view('admin.transport.schedules.index', compact('schedules', 'events', 'vehicles'));
    }

    public function create()
    {
        $events = Event::select('id', 'title', 'event_date')->where('event_date', '>', now())->orderBy('event_date')->get();
        $vehicles = Vehicle::available()->orderBy('make')->get();
        $routes = Route::active()->orderBy('name')->get();
        $pickupPoints = PickupPoint::active()->orderBy('city')->get();

        return view('admin.transport.schedules.create', compact('events', 'vehicles', 'routes', 'pickupPoints'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'route_id' => 'required|exists:routes,id',
            'pickup_point_id' => 'required|exists:pickup_points,id',
            'departure_time' => 'required|date|after:now',
            'arrival_time' => 'required|date|after:departure_time',
            'price' => 'required|numeric|min:0',
            'available_seats' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:1000',
            'is_active' => 'boolean'
        ]);

        $vehicle = Vehicle::findOrFail($validated['vehicle_id']);
        $route = Route::findOrFail($validated['route_id']);

        // Check if vehicle is available during the requested time
        if (!$vehicle->isAvailableForSchedule($validated['departure_time'], $validated['arrival_time'])) {
            return back()
                ->withInput()
                ->withErrors(['vehicle_id' => 'Vehicle is not available during the selected time period.']);
        }

        // Calculate price if not provided
        if (!$request->filled('price')) {
            $validated['price'] = $route->calculatePrice($vehicle->price_per_km);
        }

        $validated['is_active'] = $request->has('is_active');

        TransportSchedule::create($validated);

        return redirect()
            ->route('admin.transport.schedules.index')
            ->with('success', 'Transport schedule created successfully.');
    }

    public function show(TransportSchedule $schedule)
    {
        $schedule->load(['event', 'vehicle', 'route', 'pickupPoint', 'transportBookings' => function($query) {
            $query->with(['user', 'booking'])->latest();
        }]);

        return view('admin.transport.schedules.show', compact('schedule'));
    }

    public function edit(TransportSchedule $schedule)
    {
        $events = Event::select('id', 'title', 'event_date')->orderBy('title')->get();
        $vehicles = Vehicle::orderBy('make')->get();
        $routes = Route::orderBy('name')->get();
        $pickupPoints = PickupPoint::orderBy('city')->get();

        return view('admin.transport.schedules.edit', compact('schedule', 'events', 'vehicles', 'routes', 'pickupPoints'));
    }

    public function update(Request $request, TransportSchedule $schedule)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'route_id' => 'required|exists:routes,id',
            'pickup_point_id' => 'required|exists:pickup_points,id',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'price' => 'required|numeric|min:0',
            'available_seats' => 'required|integer|min:' . $schedule->booked_seats,
            'notes' => 'nullable|string|max:1000',
            'is_active' => 'boolean'
        ]);

        $vehicle = Vehicle::findOrFail($validated['vehicle_id']);
        $route = Route::findOrFail($validated['route_id']);

        // Check if vehicle is available during the requested time (excluding current schedule)
        $conflictingSchedules = $vehicle->transportSchedules()
            ->where('is_active', true)
            ->where('id', '!=', $schedule->id)
            ->where(function ($query) use ($validated) {
                $query->whereBetween('departure_time', [$validated['departure_time'], $validated['arrival_time']])
                      ->orWhereBetween('arrival_time', [$validated['departure_time'], $validated['arrival_time']])
                      ->orWhere(function ($q) use ($validated) {
                          $q->where('departure_time', '<=', $validated['departure_time'])
                            ->where('arrival_time', '>=', $validated['arrival_time']);
                      });
            })
            ->count();

        if ($conflictingSchedules > 0) {
            return back()
                ->withInput()
                ->withErrors(['vehicle_id' => 'Vehicle is not available during the selected time period.']);
        }

        $validated['is_active'] = $request->has('is_active');

        $schedule->update($validated);

        return redirect()
            ->route('admin.transport.schedules.index')
            ->with('success', 'Transport schedule updated successfully.');
    }

    public function destroy(TransportSchedule $schedule)
    {
        if ($schedule->transportBookings()->exists()) {
            return redirect()
                ->route('admin.transport.schedules.index')
                ->with('error', 'Cannot delete schedule with existing bookings.');
        }

        $schedule->delete();

        return redirect()
            ->route('admin.transport.schedules.index')
            ->with('success', 'Transport schedule deleted successfully.');
    }

    public function toggleStatus(TransportSchedule $schedule)
    {
        if ($schedule->is_fully_booked) {
            return redirect()
                ->route('admin.transport.schedules.index')
                ->with('error', 'Cannot activate fully booked schedule.');
        }

        $schedule->update(['is_active' => !$schedule->is_active]);

        return redirect()
            ->route('admin.transport.schedules.index')
            ->with('success', "Schedule status updated to " . ($schedule->is_active ? 'Active' : 'Inactive'));
    }

    public function duplicate(TransportSchedule $schedule)
    {
        $newSchedule = $schedule->replicate();
        $newSchedule->departure_time = $schedule->departure_time->addDay();
        $newSchedule->arrival_time = $schedule->arrival_time->addDay();
        $newSchedule->booked_seats = 0;
        $newSchedule->is_active = true;
        $newSchedule->save();

        return redirect()
            ->route('admin.transport.schedules.index')
            ->with('success', 'Transport schedule duplicated successfully.');
    }
}
