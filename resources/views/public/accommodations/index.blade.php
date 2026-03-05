@extends('layouts.public')

@section('title', 'Browse Accommodations - ConcertHub')
@section('description', 'Find and book the perfect accommodation near your event. Browse through hotels, apartments, and more.')

@section('content')
<div class="bg-gradient-to-r from-green-600 to-blue-600 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-4">Find Your Perfect Stay</h1>
        <p class="text-xl text-green-100">Book comfortable accommodations near your favorite venues</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Search/Filter Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form action="{{ route('public.accommodations.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                <input type="text" name="city" value="{{ request('city') }}" placeholder="Search by city..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="">All Types</option>
                    <option value="hotel" {{ request('type') == 'hotel' ? 'selected' : '' }}>Hotel</option>
                    <option value="apartment" {{ request('type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                    <option value="hostel" {{ request('type') == 'hostel' ? 'selected' : '' }}>Hostel</option>
                    <option value="resort" {{ request('type') == 'resort' ? 'selected' : '' }}>Resort</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Min Price</label>
                <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="Min price" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Max Price</label>
                <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Max price" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div class="md:col-span-4">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                    Search Accommodations
                </button>
            </div>
        </form>
    </div>

    <!-- Results -->
    @if($accommodations->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
            @foreach($accommodations as $accommodation)
                <div class="concert-card bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="relative">
                        @if($accommodation->images && count($accommodation->images) > 0)
                            <img src="{{ $accommodation->images[0] }}" alt="{{ $accommodation->name }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-r from-green-500 to-blue-500 flex items-center justify-center">
                                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        @endif
                        @if($accommodation->is_featured)
                            <div class="absolute top-4 left-4">
                                <span class="featured-badge text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    Featured
                                </span>
                            </div>
                        @endif
                        @if($accommodation->rating)
                            <div class="absolute top-4 right-4 bg-white bg-opacity-90 px-2 py-1 rounded">
                                <span class="text-sm font-semibold text-gray-900">⭐ {{ $accommodation->formatted_rating }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $accommodation->name }}</h3>
                        <p class="text-gray-600 mb-2">{{ ucfirst($accommodation->type) }}</p>
                        <div class="flex items-center text-gray-600 mb-3">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>{{ $accommodation->city }}, {{ $accommodation->state }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-2xl font-bold text-green-600">{{ $accommodation->formatted_price }}</span>
                                <span class="text-gray-600">/ night</span>
                            </div>
                            <a href="{{ route('public.accommodations.show', $accommodation) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $accommodations->links() }}
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-lg">
            <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Accommodations Found</h3>
            <p class="text-gray-600 mb-4">Try adjusting your search filters to find what you're looking for.</p>
            <a href="{{ route('public.accommodations.index') }}" class="text-green-600 hover:text-green-700 font-semibold">
                Clear Filters
            </a>
        </div>
    @endif
</div>
@endsection

