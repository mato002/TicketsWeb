<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $vehicles = Vehicle::with(['transportSchedules' => function($query) {
                $query->active()->with('event');
            }])
            ->when($request->type, function($query, $type) {
                return $query->byType($type);
            })
            ->when($request->search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('registration_number', 'like', "%{$search}%")
                      ->orWhere('make', 'like', "%{$search}%")
                      ->orWhere('model', 'like', "%{$search}%")
                      ->orWhere('driver_name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15);

        $vehicleTypes = Vehicle::select('type')->distinct()->pluck('type');

        return view('admin.transport.vehicles.index', compact('vehicles', 'vehicleTypes'));
    }

    public function create()
    {
        $vehicleTypes = ['bus', 'minibus', 'van', 'sedan', 'suv'];
        $features = [
            'WiFi', 'Air Conditioning', 'Music System', 'USB Charging',
            'Reclining Seats', 'TV Screens', 'Refreshments', 'Luggage Space'
        ];

        return view('admin.transport.vehicles.create', compact('vehicleTypes', 'features'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration_number' => 'required|string|max:20|unique:vehicles',
            'make' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'type' => 'required|in:bus,minibus,van,sedan,suv',
            'capacity' => 'required|integer|min:1|max:100',
            'price_per_km' => 'required|numeric|min:0',
            'driver_name' => 'required|string|max:100',
            'driver_phone' => 'required|string|max:20',
            'driver_license' => 'nullable|string|max:50',
            'features' => 'nullable|array',
            'description' => 'nullable|string|max:1000',
            'is_available' => 'boolean'
        ]);

        $validated['features'] = $request->features ?? [];
        $validated['is_available'] = $request->has('is_available');

        Vehicle::create($validated);

        return redirect()
            ->route('admin.transport.vehicles.index')
            ->with('success', 'Vehicle created successfully.');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['transportSchedules' => function($query) {
            $query->with(['event', 'route', 'pickupPoint'])->latest();
        }]);

        return view('admin.transport.vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $vehicleTypes = ['bus', 'minibus', 'van', 'sedan', 'suv'];
        $features = [
            'WiFi', 'Air Conditioning', 'Music System', 'USB Charging',
            'Reclining Seats', 'TV Screens', 'Refreshments', 'Luggage Space'
        ];

        return view('admin.transport.vehicles.edit', compact('vehicle', 'vehicleTypes', 'features'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'registration_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('vehicles')->ignore($vehicle->id)
            ],
            'make' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'type' => 'required|in:bus,minibus,van,sedan,suv',
            'capacity' => 'required|integer|min:1|max:100',
            'price_per_km' => 'required|numeric|min:0',
            'driver_name' => 'required|string|max:100',
            'driver_phone' => 'required|string|max:20',
            'driver_license' => 'nullable|string|max:50',
            'features' => 'nullable|array',
            'description' => 'nullable|string|max:1000',
            'is_available' => 'boolean'
        ]);

        $validated['features'] = $request->features ?? [];
        $validated['is_available'] = $request->has('is_available');

        $vehicle->update($validated);

        return redirect()
            ->route('admin.transport.vehicles.index')
            ->with('success', 'Vehicle updated successfully.');
    }

    public function destroy(Vehicle $vehicle)
    {
        if ($vehicle->transportSchedules()->exists()) {
            return redirect()
                ->route('admin.transport.vehicles.index')
                ->with('error', 'Cannot delete vehicle with existing schedules.');
        }

        $vehicle->delete();

        return redirect()
            ->route('admin.transport.vehicles.index')
            ->with('success', 'Vehicle deleted successfully.');
    }

    public function toggleAvailability(Vehicle $vehicle)
    {
        $vehicle->update(['is_available' => !$vehicle->is_available]);

        return redirect()
            ->route('admin.transport.vehicles.index')
            ->with('success', "Vehicle availability updated to " . ($vehicle->is_available ? 'Available' : 'Unavailable'));
    }
}
