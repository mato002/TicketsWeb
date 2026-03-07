@extends('layouts.public')

@section('title', 'Browse Events - ConcertHub')
@section('description', 'Browse through hundreds of upcoming concerts, shows, and performances. Find your perfect event by artist, venue, city, or date.')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Discover Amazing Events</h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Browse through our curated collection of upcoming concerts, shows, and performances to find your perfect experience
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter Events</h3>
                    
                    <form method="GET" action="{{ route('public.events.index') }}" class="space-y-6">
                        <!-- Search by Artist -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Artist</label>
                            <input type="text" name="artist" value="{{ request('artist') }}" 
                                   placeholder="Search by artist..." 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>

                        <!-- Search by Venue -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Venue</label>
                            <input type="text" name="venue" value="{{ request('venue') }}" 
                                   placeholder="Search by venue..." 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>

                        <!-- Search by City -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                            <input type="text" name="city" value="{{ request('city') }}" 
                                   placeholder="Search by city..." 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>

                        <!-- Date Range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
                            <div class="space-y-2">
                                <input type="date" name="date_from" value="{{ request('date_from') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <input type="date" name="date_to" value="{{ request('date_to') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                            <div class="space-y-2">
                                <input type="number" name="price_min" value="{{ request('price_min') }}" 
                                       placeholder="Min price" min="0" step="0.01"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <input type="number" name="price_max" value="{{ request('price_max') }}" 
                                       placeholder="Max price" min="0" step="0.01"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                        </div>

                        <!-- Sort -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                            <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="date" {{ request('sort') == 'date' ? 'selected' : '' }}>Date (Earliest First)</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
                                <option value="artist" {{ request('sort') == 'artist' ? 'selected' : '' }}>Artist (A to Z)</option>
                            </select>
                        </div>

                        <!-- Filter Buttons -->
                        <div class="flex space-x-2">
                            <button type="submit" class="flex-1 bg-purple-600 text-white py-2 px-4 rounded-md font-medium hover:bg-purple-700 transition-colors">
                                Apply Filters
                            </button>
                            <a href="{{ route('public.events.index') }}" class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-md font-medium hover:bg-gray-400 transition-colors text-center">
                                Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Concert Listings -->
            <div class="lg:w-3/4">
                <!-- Results Header -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">
                            {{ $concerts->total() }} Event{{ $concerts->total() != 1 ? 's' : '' }} Found
                        </h2>
                        @if(request()->hasAny(['artist', 'venue', 'city', 'date_from', 'date_to', 'price_min', 'price_max']))
                            <p class="text-gray-600 text-sm">Filtered results</p>
                        @endif
                    </div>
                </div>

                @if($concerts->count() > 0)
                    <!-- Concert Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        @foreach($concerts as $concert)
                            <div class="concert-card bg-white rounded-lg shadow-md overflow-hidden">
                                <div class="relative">
                                    @if($concert->image_url)
                                        <img src="{{ $concert->image_url }}" alt="{{ $concert->title }}" class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gradient-to-r from-purple-500 to-blue-500 flex items-center justify-center">
                                            <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.369 4.369 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    @if($concert->featured)
                                        <div class="absolute top-4 left-4">
                                            <span class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                                Featured
                                            </span>
                                        </div>
                                    @endif
                                    <div class="absolute top-4 right-4">
                                        @if($concert->available_tickets < 50)
                                            <span class="bg-red-500 text-white px-2 py-1 rounded text-xs font-semibold">
                                                {{ $concert->available_tickets }} left
                                            </span>
                                        @elseif($concert->available_tickets < 100)
                                            <span class="bg-yellow-500 text-white px-2 py-1 rounded text-xs font-semibold">
                                                {{ $concert->available_tickets }} left
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">{{ $concert->title }}</h3>
                                    <p class="text-purple-600 font-semibold mb-3">{{ $concert->artist }}</p>
                                    
                                    <div class="space-y-2 mb-4">
                                        <div class="flex items-center text-gray-600">
                                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span class="truncate">{{ $concert->venue }}, {{ $concert->city }}</span>
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>{{ $concert->event_date->format('M j, Y') }} at {{ $concert->event_time->format('g:i A') }}</span>
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>{{ $concert->duration_minutes }} minutes</span>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="text-2xl font-bold text-purple-600">{{ $concert->formatted_price }}</span>
                                            <span class="text-gray-600 text-sm">from</span>
                                        </div>
                                        <a href="{{ route('public.events.show', $concert) }}" 
                                           class="bg-purple-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center">
                        {{ $concerts->appends(request()->query())->links() }}
                    </div>
                @else
                    <!-- No Results -->
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Events Found</h3>
                <p class="text-gray-600 mb-6">Try adjusting your search criteria or browse all events.</p>
                <a href="{{ route('public.events.index') }}" 
                   class="bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                    View All Events
                </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-submit form when filters change
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input, select');
        
        inputs.forEach(input => {
            input.addEventListener('change', function() {
                // Small delay to prevent too many requests
                setTimeout(() => {
                    form.submit();
                }, 300);
            });
        });
    });
</script>
@endpush
@endsection
