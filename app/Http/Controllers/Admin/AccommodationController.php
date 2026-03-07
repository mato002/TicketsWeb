<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AccommodationController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of accommodations.
     */
    public function index(): View
    {
        $accommodations = Accommodation::orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.accommodations.index', compact('accommodations'));
    }

    /**
     * Show the form for creating a new accommodation.
     */
    public function create(): View
    {
        return view('admin.accommodations.create');
    }

    /**
     * Store a newly created accommodation.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'price_per_night' => 'required|numeric|min:0',
            'max_guests' => 'required|integer|min:1',
            'amenities' => 'nullable|array',
            'images' => 'nullable|array',
            'status' => 'required|in:active,inactive,maintenance',
            'featured' => 'boolean',
            'rating' => 'nullable|numeric|min:0|max:5',
            'review_count' => 'nullable|integer|min:0'
        ]);

        $validated['featured'] = $request->has('featured');

        Accommodation::create($validated);

        return redirect()->route('admin.accommodations.index')
            ->with('success', 'Accommodation created successfully.');
    }

    /**
     * Display the specified accommodation.
     */
    public function show(Accommodation $accommodation): View
    {
        return view('admin.accommodations.show', compact('accommodation'));
    }

    /**
     * Show the form for editing the specified accommodation.
     */
    public function edit(Accommodation $accommodation): View
    {
        return view('admin.accommodations.edit', compact('accommodation'));
    }

    /**
     * Update the specified accommodation.
     */
    public function update(Request $request, Accommodation $accommodation): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'price_per_night' => 'required|numeric|min:0',
            'max_guests' => 'required|integer|min:1',
            'amenities' => 'nullable|array',
            'images' => 'nullable|array',
            'status' => 'required|in:active,inactive,maintenance',
            'featured' => 'boolean',
            'rating' => 'nullable|numeric|min:0|max:5',
            'review_count' => 'nullable|integer|min:0'
        ]);

        $validated['featured'] = $request->has('featured');

        $accommodation->update($validated);

        return redirect()->route('admin.accommodations.index')
            ->with('success', 'Accommodation updated successfully.');
    }

    /**
     * Remove the specified accommodation.
     */
    public function destroy(Accommodation $accommodation): RedirectResponse
    {
        $accommodation->delete();

        return redirect()->route('admin.accommodations.index')
            ->with('success', 'Accommodation deleted successfully.');
    }

    /**
     * Toggle featured status of an accommodation.
     */
    public function toggleFeatured(Accommodation $accommodation): RedirectResponse
    {
        $accommodation->update(['featured' => !$accommodation->featured]);

        $status = $accommodation->featured ? 'featured' : 'unfeatured';
        
        return redirect()->back()
            ->with('success', "Accommodation {$status} successfully.");
    }

    /**
     * Update accommodation status.
     */
    public function updateStatus(Request $request, Accommodation $accommodation): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:active,inactive,maintenance'
        ]);

        $accommodation->update($validated);

        return redirect()->back()
            ->with('success', 'Accommodation status updated successfully.');
    }
}


