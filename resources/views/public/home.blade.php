@extends('layouts.public')

@section('title', 'TwendeeTickets - Discover Amazing Events')
@section('description', 'Find and book the best events including sports, music festivals, comedy, car shows, travel, hiking, art, and gallery events. Discover upcoming events, secure your tickets, and book nearby accommodation all in one place with TwendeeTickets.')

@section('content')
<!-- Hero Section -->
<section class="hero-gradient text-white py-20 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Discover Your Next
                <span class="text-yellow-300">Unforgettable Experience</span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-blue-100 max-w-3xl mx-auto">
                From sports events to music festivals, comedy shows to art exhibitions, find and book amazing experiences with ease. 
                Your perfect event starts here.
            </p>
            
            <!-- Search Box -->
            <div class="max-w-4xl mx-auto">
                <form action="{{ route('public.events.index') }}" method="GET" class="bg-white rounded-2xl p-6 shadow-2xl">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Event Type</label>
                            <select name="type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">All Events</option>
                                <option value="music">Music & Concerts</option>
                                <option value="sports">Sports Events</option>
                                <option value="comedy">Comedy Shows</option>
                                <option value="car_show">Car Shows</option>
                                <option value="travel">Travel & Tours</option>
                                <option value="hiking">Hiking & Adventure</option>
                                <option value="art">Art Exhibitions</option>
                                <option value="gallery">Gallery Shows</option>
                                <option value="festival">Festivals</option>
                                <option value="theater">Theater & Drama</option>
                                <option value="conference">Conferences</option>
                                <option value="workshop">Workshops</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Venue</label>
                            <input type="text" name="venue" placeholder="Search by venue..." 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                            <input type="text" name="city" placeholder="Search by city..." 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                            <input type="date" name="date_from" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="w-full md:w-auto bg-purple-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-purple-700 transition-colors flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <span>Search Events</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

        <!-- Featured Events Section -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Featured Events</h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Don't miss these incredible upcoming events from sports to music, comedy to art. Limited tickets available!
                    </p>
                </div>

        @if($featuredEvents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredEvents as $event)
                    <div class="event-card bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="relative">
                            @if($event->image_url)
                                <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-r from-purple-500 to-blue-500 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.369 4.369 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="bg-{{ $event->event_type_color }}-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ $event->event_type_name }}
                                </span>
                            </div>
                            <div class="absolute top-4 right-4">
                                <span class="bg-red-500 text-white px-2 py-1 rounded text-xs font-semibold">
                                    {{ $event->available_tickets }} left
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $event->title }}</h3>
                            <p class="text-purple-600 font-semibold mb-2">{{ $event->organizer }}</p>
                            <div class="flex items-center text-gray-600 mb-3">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>{{ $event->venue }}, {{ $event->city }}</span>
                            </div>
                            <div class="flex items-center text-gray-600 mb-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>{{ $event->event_date->format('M j, Y') }} at {{ $event->event_time->format('g:i A') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-2xl font-bold text-purple-600">{{ $event->formatted_price }}</span>
                                <a href="{{ route('public.events.show', $event) }}" 
                                   class="bg-purple-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('public.events.index') }}" 
                   class="bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                    View All Events
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Featured Events Yet</h3>
                <p class="text-gray-600">Check back soon for amazing featured events from all categories!</p>
            </div>
        @endif
    </div>
</section>

<!-- Featured Accommodations Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Featured Accommodations</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Stay in comfort near your favorite venues. Book your perfect accommodation today!
            </p>
        </div>

        @if($featuredAccommodations->count() > 0)
            <div id="accommodations-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredAccommodations as $index => $accommodation)
                    <div class="concert-card bg-white rounded-2xl shadow-lg overflow-hidden {{ $index >= 3 ? 'hidden accommodation-extra' : '' }}">
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
                            <div class="absolute top-4 left-4">
                                <span class="featured-badge text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    Featured
                                </span>
                            </div>
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

            <div class="text-center mt-12">
                @if($featuredAccommodations->count() > 3)
                    <button id="toggle-accommodations-btn" onclick="toggleAccommodations()" 
                       class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors mr-4">
                        View All Accommodations
                    </button>
                @endif
                <a href="{{ route('public.accommodations.index') }}" 
                   class="bg-gray-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-700 transition-colors inline-block">
                    Browse More
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Featured Accommodations Yet</h3>
                <p class="text-gray-600">Check back soon for amazing accommodation options!</p>
            </div>
        @endif
    </div>
</section>

<!-- How It Works Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">How It Works</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Booking your perfect concert experience has never been easier
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">1. Discover</h3>
            <p class="text-gray-600">Browse through hundreds of upcoming events, shows, and performances to find your perfect experience</p>
            </div>

            <div class="text-center">
                <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">2. Book</h3>
                <p class="text-gray-600">Select your tickets, choose accommodation, and secure your booking in minutes</p>
            </div>

            <div class="text-center">
                <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">3. Enjoy</h3>
            <p class="text-gray-600">Show up and enjoy an unforgettable event experience with friends and family</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-purple-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            Ready for Your Next Unforgettable Experience?
        </h2>
        <p class="text-xl text-purple-100 mb-8 max-w-2xl mx-auto">
            Join thousands of event lovers who trust ConcertHub for their concert, show, and performance bookings
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('public.events.index') }}" 
               class="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                Browse All Events
            </a>
            @guest
                <a href="{{ route('register') }}" 
                   class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-purple-600 transition-colors">
                    Sign Up Free
                </a>
            @endguest
        </div>
    </div>
</section>

@push('scripts')
<script>
    let accommodationsExpanded = false;

    function toggleAccommodations() {
        const extraAccommodations = document.querySelectorAll('.accommodation-extra');
        const button = document.getElementById('toggle-accommodations-btn');
        
        accommodationsExpanded = !accommodationsExpanded;
        
        extraAccommodations.forEach(accommodation => {
            if (accommodationsExpanded) {
                accommodation.classList.remove('hidden');
            } else {
                accommodation.classList.add('hidden');
            }
        });
        
        button.textContent = accommodationsExpanded ? 'Show Less' : 'View All Accommodations';
    }
</script>
@endpush
@endsection
