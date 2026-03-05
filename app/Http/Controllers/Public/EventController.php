<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::published()->upcoming();

        // Filter by event type
        if ($request->has('type') && $request->type !== 'all') {
            $query->byType($request->type);
        }

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('organizer', 'like', "%{$search}%")
                  ->orWhere('venue', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        // Sort by date or price
        $sortBy = $request->get('sort', 'date');
        $sortOrder = $request->get('order', 'asc');
        
        if ($sortBy === 'date') {
            $query->orderBy('event_date', $sortOrder);
        } elseif ($sortBy === 'price') {
            $query->orderBy('base_price', $sortOrder);
        } elseif ($sortBy === 'title') {
            $query->orderBy('title', $sortOrder);
        }

        $events = $query->paginate(12);

        // Get event types for filtering
        $eventTypes = [
            'music' => 'Music & Concerts',
            'sports' => 'Sports Events',
            'comedy' => 'Comedy Shows',
            'car_show' => 'Car Shows',
            'travel' => 'Travel & Tours',
            'hiking' => 'Hiking & Adventure',
            'art' => 'Art Exhibitions',
            'gallery' => 'Gallery Shows',
            'festival' => 'Festivals',
            'theater' => 'Theater & Drama',
            'conference' => 'Conferences',
            'workshop' => 'Workshops',
            'other' => 'Other Events'
        ];

        return view('public.events.index', compact('events', 'eventTypes'));
    }

    public function show(Event $event)
    {
        // Only show published events
        if ($event->status !== 'published') {
            abort(404);
        }

        // Get related events of the same type
        $relatedEvents = Event::published()
            ->where('event_type', $event->event_type)
            ->where('id', '!=', $event->id)
            ->upcoming()
            ->take(3)
            ->get();

        return view('public.events.show', compact('event', 'relatedEvents'));
    }
}
