<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Concert;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ConcertController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of concerts.
     */
    public function index(): View
    {
        $concerts = Concert::orderBy('event_date', 'desc')
            ->orderBy('event_time', 'desc')
            ->paginate(15);

        return view('admin.concerts.index', compact('concerts'));
    }

    /**
     * Show the form for creating a new concert.
     */
    public function create(): View
    {
        return view('admin.concerts.create');
    }

    /**
     * Store a newly created concert.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'artist' => 'required|string|max:255',
            'venue' => 'required|string|max:255',
            'venue_address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'event_date' => 'required|date|after:today',
            'event_time' => 'required',
            'duration_minutes' => 'required|integer|min:30|max:480',
            'base_price' => 'required|numeric|min:0',
            'total_tickets' => 'required|integer|min:1',
            'available_tickets' => 'required|integer|min:0|lte:total_tickets',
            'image_url' => 'nullable|url',
            'status' => 'required|in:draft,published,cancelled,completed',
            'featured' => 'boolean',
            'ticket_categories' => 'nullable|array'
        ]);

        // Handle ticket categories
        if ($request->has('ticket_categories')) {
            $categories = [];
            foreach ($request->ticket_categories as $category) {
                if (!empty($category['name']) && !empty($category['price'])) {
                    $categories[] = [
                        'name' => $category['name'],
                        'price' => (float) $category['price'],
                        'quantity' => (int) ($category['quantity'] ?? 0)
                    ];
                }
            }
            $validated['ticket_categories'] = $categories;
        }

        $validated['featured'] = $request->has('featured');

        Concert::create($validated);

        return redirect()->route('admin.concerts.index')
            ->with('success', 'Concert created successfully.');
    }

    /**
     * Display the specified concert.
     */
    public function show(Concert $concert): View
    {
        return view('admin.concerts.show', compact('concert'));
    }

    /**
     * Show the form for editing the specified concert.
     */
    public function edit(Concert $concert): View
    {
        return view('admin.concerts.edit', compact('concert'));
    }

    /**
     * Update the specified concert.
     */
    public function update(Request $request, Concert $concert): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'artist' => 'required|string|max:255',
            'venue' => 'required|string|max:255',
            'venue_address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'duration_minutes' => 'required|integer|min:30|max:480',
            'base_price' => 'required|numeric|min:0',
            'total_tickets' => 'required|integer|min:1',
            'available_tickets' => 'required|integer|min:0|lte:total_tickets',
            'image_url' => 'nullable|url',
            'status' => 'required|in:draft,published,cancelled,completed',
            'featured' => 'boolean',
            'ticket_categories' => 'nullable|array'
        ]);

        // Handle ticket categories
        if ($request->has('ticket_categories')) {
            $categories = [];
            foreach ($request->ticket_categories as $category) {
                if (!empty($category['name']) && !empty($category['price'])) {
                    $categories[] = [
                        'name' => $category['name'],
                        'price' => (float) $category['price'],
                        'quantity' => (int) ($category['quantity'] ?? 0)
                    ];
                }
            }
            $validated['ticket_categories'] = $categories;
        }

        $validated['featured'] = $request->has('featured');

        $concert->update($validated);

        return redirect()->route('admin.concerts.index')
            ->with('success', 'Concert updated successfully.');
    }

    /**
     * Remove the specified concert.
     */
    public function destroy(Concert $concert): RedirectResponse
    {
        $concert->delete();

        return redirect()->route('admin.concerts.index')
            ->with('success', 'Concert deleted successfully.');
    }

    /**
     * Toggle featured status of a concert.
     */
    public function toggleFeatured(Concert $concert): RedirectResponse
    {
        $concert->update(['featured' => !$concert->featured]);

        $status = $concert->featured ? 'featured' : 'unfeatured';
        
        return redirect()->back()
            ->with('success', "Concert {$status} successfully.");
    }

    /**
     * Update concert status.
     */
    public function updateStatus(Request $request, Concert $concert): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,published,cancelled,completed'
        ]);

        $concert->update($validated);

        return redirect()->back()
            ->with('success', 'Concert status updated successfully.');
    }

    /**
     * Export concerts to CSV.
     */
    public function export(Request $request)
    {
        $query = Concert::query();

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('event_type')) {
            $query->where('event_type', $request->event_type);
        }
        if ($request->filled('featured')) {
            $query->where('featured', $request->featured == '1');
        }
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('venue', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $concerts = $query->orderBy('event_date', 'desc')->get();

        $filename = 'concerts_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($concerts) {
            $file = fopen('php://output', 'w');
            
            // CSV header
            fputcsv($file, [
                'ID', 'Title', 'Event Type', 'Event Date', 'Event Time', 'Venue', 
                'Base Price', 'Available Tickets', 'Status', 'Featured', 'Created At'
            ]);
            
            // CSV data
            foreach ($concerts as $concert) {
                fputcsv($file, [
                    $concert->id,
                    $concert->title,
                    $concert->event_type ?? 'N/A',
                    $concert->event_date?->format('Y-m-d') ?? 'N/A',
                    $concert->event_time?->format('H:i:s') ?? 'N/A',
                    $concert->venue ?? 'N/A',
                    $concert->base_price,
                    $concert->available_tickets,
                    $concert->status,
                    $concert->featured ? 'Yes' : 'No',
                    $concert->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
