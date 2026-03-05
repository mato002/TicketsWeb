<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Accommodation;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured events
        $featuredEvents = Event::published()
            ->featured()
            ->upcoming()
            ->orderBy('event_date', 'asc')
            ->limit(6)
            ->get();

        // Get featured accommodations
        $featuredAccommodations = Accommodation::active()
            ->featured()
            ->orderBy('rating', 'desc')
            ->limit(6)
            ->get();

        // Get upcoming events for the search section
        $upcomingEvents = Event::published()
            ->upcoming()
            ->orderBy('event_date', 'asc')
            ->limit(12)
            ->get();

        return view('public.home', compact('featuredEvents', 'featuredAccommodations', 'upcomingEvents'));
    }

    public function search(Request $request)
    {
        $query = Event::published()->upcoming();

        // Search by organizer
        if ($request->filled('organizer')) {
            $query->where('organizer', 'like', '%' . $request->organizer . '%');
        }

        // Search by venue
        if ($request->filled('venue')) {
            $query->where('venue', 'like', '%' . $request->venue . '%');
        }

        // Search by city
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        // Search by date range
        if ($request->filled('date_from')) {
            $query->where('event_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('event_date', '<=', $request->date_to);
        }

        // Price range
        if ($request->filled('price_min')) {
            $query->where('base_price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('base_price', '<=', $request->price_max);
        }

        $events = $query->orderBy('event_date', 'asc')->paginate(12);

        return view('public.events.index', compact('events'));
    }
}
