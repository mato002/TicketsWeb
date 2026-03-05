<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use Illuminate\Http\Request;

class AccommodationController extends Controller
{
    /**
     * Display a listing of accommodations
     */
    public function index(Request $request)
    {
        $query = Accommodation::active();

        // Search by city
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Price range
        if ($request->filled('price_min')) {
            $query->where('price_per_night', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price_per_night', '<=', $request->price_max);
        }

        $accommodations = $query->orderBy('rating', 'desc')->paginate(12);

        return view('public.accommodations.index', compact('accommodations'));
    }

    /**
     * Display the specified accommodation
     */
    public function show(Accommodation $accommodation)
    {
        // Ensure the accommodation is active
        if ($accommodation->status !== 'active') {
            abort(404);
        }

        // Get nearby accommodations
        $nearbyAccommodations = Accommodation::active()
            ->where('city', $accommodation->city)
            ->where('id', '!=', $accommodation->id)
            ->orderBy('rating', 'desc')
            ->limit(3)
            ->get();

        return view('public.accommodations.show', compact('accommodation', 'nearbyAccommodations'));
    }
}

