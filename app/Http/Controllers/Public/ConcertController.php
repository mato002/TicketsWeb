<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Concert;
use App\Models\Accommodation;
use Illuminate\Http\Request;

class ConcertController extends Controller
{
    public function index(Request $request)
    {
        $query = Concert::published()->upcoming();

        // Apply filters
        if ($request->filled('artist')) {
            $query->where('artist', 'like', '%' . $request->artist . '%');
        }

        if ($request->filled('venue')) {
            $query->where('venue', 'like', '%' . $request->venue . '%');
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('date_from')) {
            $query->where('event_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('event_date', '<=', $request->date_to);
        }

        if ($request->filled('price_min')) {
            $query->where('base_price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('base_price', '<=', $request->price_max);
        }

        // Sorting
        $sort = $request->get('sort', 'date');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('base_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('base_price', 'desc');
                break;
            case 'artist':
                $query->orderBy('artist', 'asc');
                break;
            default:
                $query->orderBy('event_date', 'asc');
        }

        $concerts = $query->paginate(12);

        return view('public.concerts.index', compact('concerts'));
    }

    public function show(Concert $concert)
    {
        // Ensure the concert is published
        if ($concert->status !== 'published') {
            abort(404);
        }

        // Get nearby accommodations
        $nearbyAccommodations = Accommodation::active()
            ->where('city', $concert->city)
            ->where('id', '!=', $concert->id)
            ->orderBy('rating', 'desc')
            ->limit(6)
            ->get();

        // Get similar concerts (same artist or venue)
        $similarConcerts = Concert::published()
            ->upcoming()
            ->where('id', '!=', $concert->id)
            ->where(function($q) use ($concert) {
                $q->where('artist', $concert->artist)
                  ->orWhere('venue', $concert->venue);
            })
            ->limit(4)
            ->get();

        return view('public.concerts.show', compact('concert', 'nearbyAccommodations', 'similarConcerts'));
    }
}
