<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PickupPoint;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PickupPointController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $pickupPoints = PickupPoint::with(['transportSchedules' => function($query) {
                $query->active()->with('event');
            }])
            ->when($request->search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('address', 'like', "%{$search}%")
                      ->orWhere('city', 'like', "%{$search}%");
                });
            })
            ->when($request->city, function($query, $city) {
                return $query->byCity($city);
            })
            ->when($request->status, function($query, $status) {
                if ($status === 'active') {
                    $query->active();
                } elseif ($status === 'inactive') {
                    $query->where('is_active', false);
                }
            })
            ->latest()
            ->paginate(15);

        $cities = PickupPoint::select('city')->distinct()->pluck('city');

        return view('admin.transport.pickup-points.index', compact('pickupPoints', 'cities'));
    }

    public function create()
    {
        $cities = ['Nairobi', 'Mombasa', 'Kisumu', 'Nakuru', 'Eldoret', 'Thika', 'Kitale', 'Kakamega'];
        return view('admin.transport.pickup-points.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'required|string|max:200',
            'city' => 'required|string|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        PickupPoint::create($validated);

        return redirect()
            ->route('admin.transport.pickup-points.index')
            ->with('success', 'Pickup point created successfully.');
    }

    public function show(PickupPoint $pickupPoint)
    {
        $pickupPoint->load(['transportSchedules' => function($query) {
            $query->with(['event', 'vehicle', 'route'])->latest();
        }]);

        return view('admin.transport.pickup-points.show', compact('pickupPoint'));
    }

    public function edit(PickupPoint $pickupPoint)
    {
        $cities = ['Nairobi', 'Mombasa', 'Kisumu', 'Nakuru', 'Eldoret', 'Thika', 'Kitale', 'Kakamega'];
        return view('admin.transport.pickup-points.edit', compact('pickupPoint', 'cities'));
    }

    public function update(Request $request, PickupPoint $pickupPoint)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'required|string|max:200',
            'city' => 'required|string|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $pickupPoint->update($validated);

        return redirect()
            ->route('admin.transport.pickup-points.index')
            ->with('success', 'Pickup point updated successfully.');
    }

    public function destroy(PickupPoint $pickupPoint)
    {
        if ($pickupPoint->transportSchedules()->exists()) {
            return redirect()
                ->route('admin.transport.pickup-points.index')
                ->with('error', 'Cannot delete pickup point with existing schedules.');
        }

        $pickupPoint->delete();

        return redirect()
            ->route('admin.transport.pickup-points.index')
            ->with('success', 'Pickup point deleted successfully.');
    }

    public function toggleStatus(PickupPoint $pickupPoint)
    {
        $pickupPoint->update(['is_active' => !$pickupPoint->is_active]);

        return redirect()
            ->route('admin.transport.pickup-points.index')
            ->with('success', "Pickup point status updated to " . ($pickupPoint->is_active ? 'Active' : 'Inactive'));
    }
}
