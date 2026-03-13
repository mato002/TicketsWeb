<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RouteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $routes = Route::with(['transportSchedules' => function($query) {
                $query->active()->with('event');
            }])
            ->when($request->search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('start_location', 'like', "%{$search}%")
                      ->orWhere('end_location', 'like', "%{$search}%");
                });
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

        return view('admin.transport.routes.index', compact('routes'));
    }

    public function create()
    {
        return view('admin.transport.routes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:routes',
            'start_location' => 'required|string|max:200',
            'end_location' => 'required|string|max:200',
            'distance_km' => 'required|numeric|min:0.1|max:1000',
            'base_price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        Route::create($validated);

        return redirect()
            ->route('admin.transport.routes.index')
            ->with('success', 'Route created successfully.');
    }

    public function show(Route $route)
    {
        $route->load(['transportSchedules' => function($query) {
            $query->with(['event', 'vehicle', 'pickupPoint'])->latest();
        }]);

        return view('admin.transport.routes.show', compact('route'));
    }

    public function edit(Route $route)
    {
        return view('admin.transport.routes.edit', compact('route'));
    }

    public function update(Request $request, Route $route)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('routes')->ignore($route->id)
            ],
            'start_location' => 'required|string|max:200',
            'end_location' => 'required|string|max:200',
            'distance_km' => 'required|numeric|min:0.1|max:1000',
            'base_price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $route->update($validated);

        return redirect()
            ->route('admin.transport.routes.index')
            ->with('success', 'Route updated successfully.');
    }

    public function destroy(Route $route)
    {
        if ($route->transportSchedules()->exists()) {
            return redirect()
                ->route('admin.transport.routes.index')
                ->with('error', 'Cannot delete route with existing schedules.');
        }

        $route->delete();

        return redirect()
            ->route('admin.transport.routes.index')
            ->with('success', 'Route deleted successfully.');
    }

    public function toggleStatus(Route $route)
    {
        $route->update(['is_active' => !$route->is_active]);

        return redirect()
            ->route('admin.transport.routes.index')
            ->with('success', "Route status updated to " . ($route->is_active ? 'Active' : 'Inactive'));
    }
}
