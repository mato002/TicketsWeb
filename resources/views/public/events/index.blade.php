@extends('layouts.public')

@section('title', 'Browse Events - TwendeeTickets')
@section('description', 'Browse through hundreds of upcoming events including sports, music festivals, comedy, car shows, travel, hiking, art, and gallery events. Find your perfect event by type, location, or date with TwendeeTickets.')

@section('content')
<!-- Include Popup Banner Components -->
@include('components.popup-banner')
@include('components.scroll-popup')
<div class="bg-gray-50 min-h-screen" x-data="{ mobileFiltersOpen: false }">
    <!-- Header Section -->
    <div class="bg-white shadow-sm" style="background-image: url('https://images.unsplash.com/photo-1470225620780-dba8ba36b745?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=60'); background-size: cover; background-position: center;">
        <div class="bg-white bg-opacity-95 backdrop-blur-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="text-center">
                    <h1 class="text-3xl md:text-4xl font-black text-gray-900 mb-4">
                        <i class="fas fa-calendar-alt text-purple-600"></i> Discover Amazing Events
                    </h1>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Browse through our curated collection of upcoming events including sports, music, comedy, art, and more to find your perfect experience
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Mobile Filter Toggle -->
        <div class="lg:hidden mb-6">
            <button @click="mobileFiltersOpen = ! mobileFiltersOpen" 
                    class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-left font-medium text-gray-700 hover:bg-gray-50 transition-colors flex items-center justify-between">
                <span>Filter Events</span>
                <svg class="w-5 h-5 transform transition-transform" :class="mobileFiltersOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:w-1/4">
                <div class="lg:sticky lg:top-24">
                    <div x-show="!mobileFiltersOpen" class="lg:hidden">
                        <!-- Mobile filters are hidden by default, shown when toggled -->
                    </div>
                    <div x-show="mobileFiltersOpen || !lg:hidden" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 transform translate-y-0"
                         x-transition:leave-end="opacity-0 transform -translate-y-2"
                         class="bg-white rounded-lg shadow-md p-6 lg:block"
                         :class="mobileFiltersOpen ? 'block' : 'hidden lg:block'">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter Events</h3>
                    
                    <form method="GET" action="{{ route('public.events.index') }}" class="space-y-6">
                        <!-- Search Bar -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search Events</label>
                            <div class="relative">
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Search by name, venue, or organizer..."
                                       class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <svg class="absolute left-3 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Event Type Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Event Type</label>
                            <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                                    style="color: #374151 !important; background-color: #ffffff !important;">
                                <option value="all" {{ request('type') == 'all' || !request('type') ? 'selected' : '' }} style="color: #374151 !important; background-color: #ffffff !important;">All Events</option>
                                @foreach($eventTypes as $key => $label)
                                    <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }} style="color: #374151 !important; background-color: #ffffff !important;">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Location Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                            <select name="location" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                                    style="color: #374151 !important; background-color: #ffffff !important;">
                                <option value="all" {{ request('location') == 'all' || !request('location') ? 'selected' : '' }} style="color: #374151 !important; background-color: #ffffff !important;">All Locations</option>
                                <option value="nairobi" {{ request('location') == 'nairobi' ? 'selected' : '' }} style="color: #374151 !important; background-color: #ffffff !important;">Nairobi</option>
                                <option value="mombasa" {{ request('location') == 'mombasa' ? 'selected' : '' }} style="color: #374151 !important; background-color: #ffffff !important;">Mombasa</option>
                                <option value="kisumu" {{ request('location') == 'kisumu' ? 'selected' : '' }} style="color: #374151 !important; background-color: #ffffff !important;">Kisumu</option>
                                <option value="nakuru" {{ request('location') == 'nakuru' ? 'selected' : '' }} style="color: #374151 !important; background-color: #ffffff !important;">Nakuru</option>
                                <option value="eldoret" {{ request('location') == 'eldoret' ? 'selected' : '' }} style="color: #374151 !important; background-color: #ffffff !important;">Eldoret</option>
                            </select>
                        </div>
                        
                        <!-- Date Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
                            <select name="date_range" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                                    style="color: #374151 !important; background-color: #ffffff !important;">
                                <option value="all" {{ request('date_range') == 'all' || !request('date_range') ? 'selected' : '' }} style="color: #374151 !important; background-color: #ffffff !important;">All Dates</option>
                                <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }} style="color: #374151 !important; background-color: #ffffff !important;">Today</option>
                                <option value="this_week" {{ request('date_range') == 'this_week' ? 'selected' : '' }} style="color: #374151 !important; background-color: #ffffff !important;">This Week</option>
                                <option value="this_month" {{ request('date_range') == 'this_month' ? 'selected' : '' }} style="color: #374151 !important; background-color: #ffffff !important;">This Month</option>
                                <option value="next_month" {{ request('date_range') == 'next_month' ? 'selected' : '' }} style="color: #374151 !important; background-color: #ffffff !important;">Next Month</option>
                            </select>
                        </div>

                        <!-- Sort -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                            <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                                    style="color: #374151 !important; background-color: #ffffff !important;">
                                <option value="date" {{ request('sort') == 'date' ? 'selected' : '' }} style="color: #374151 !important; background-color: #ffffff !important;">Date</option>
                                <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }} style="color: #374151 !important; background-color: #ffffff !important;">Price</option>
                                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }} style="color: #374151 !important; background-color: #ffffff !important;">Title</option>
                            </select>
                        </div>

                        <!-- Apply Filters Button -->
                        <div class="flex gap-3">
                            <button type="submit" 
                                    class="flex-1 bg-purple-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                                Apply Filters
                            </button>
                            <a href="{{ route('public.events.index') }}" 
                               class="flex-1 bg-gray-200 text-gray-700 py-3 px-4 rounded-lg font-semibold hover:bg-gray-300 transition-colors text-center">
                                Clear
                            </a>
                        </div>
                    </form>
                    </div>
                </div>
            </div>

            <!-- Events Grid -->
            <div class="lg:w-3/4">
                <!-- Results Header -->
                <div class="mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">
                                {{ $events->total() }} Events Found
                            </h2>
                            @if(request('type') && request('type') !== 'all')
                                <p class="text-gray-600 mt-1">
                                    Showing: {{ $eventTypes[request('type')] ?? 'All Events' }}
                                </p>
                            @endif
                        </div>
                        
                        <!-- Active Filters Display -->
                        @if(request()->hasAny(['type', 'search', 'sort', 'order']))
                            <div class="text-sm text-gray-500">
                                <a href="{{ route('public.events.index') }}" class="hover:text-purple-600">
                                    Clear all filters
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Events List -->
                @if($events->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                        @foreach($events as $event)
                            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group transform hover:-translate-y-1">
                                <!-- Event Image -->
                                <div class="relative h-64 bg-gradient-to-br from-purple-400 to-blue-500 overflow-hidden">
                                    @if($event->image_url)
                                        <img src="{{ $event->image_url }}" alt="{{ $event->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-20 h-20 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.369 4.369 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <!-- Event Type Badge -->
                                    <div class="absolute top-4 left-4">
                                        <span class="bg-{{ $event->event_type_color }}-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                            {{ $event->event_type_name }}
                                        </span>
                                    </div>
                                    
                                    <!-- Organizer Verification Badge -->
                                    @if($event->organizer_verified)
                                        <div class="absolute top-4 right-4">
                                            <div class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-semibold flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                Verified
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($event->featured)
                                        <div class="absolute top-12 right-4">
                                            <span class="bg-yellow-400 text-yellow-900 px-2 py-1 rounded-full text-xs font-semibold">
                                                Featured
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Event Details -->
                                <div class="p-8">
                                    <div class="mb-6">
                                        <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2">
                                            <a href="{{ route('public.events.show', $event) }}" class="hover:text-purple-600 transition-colors">
                                                {{ $event->title }}
                                            </a>
                                        </h3>
                                        <p class="text-gray-600 text-base mb-4 line-clamp-3">
                                            {{ $event->description }}
                                        </p>
                                        
                                        <div class="space-y-3">
                                            <!-- Organizer -->
                                            <div class="flex items-center text-base text-gray-600">
                                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                {{ $event->organizer }}
                                            </div>
                                            
                                            <!-- Venue -->
                                            <div class="flex items-center text-base text-gray-600">
                                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                {{ $event->venue }}, {{ $event->city }}
                                            </div>
                                            
                                            <!-- Date & Time -->
                                            <div class="flex items-center text-base text-gray-600">
                                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ $event->event_date->format('M j, Y') }} at {{ $event->event_time->format('g:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Countdown Timer -->
                                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-3 mb-6">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-orange-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                </svg>
                                                <span class="text-sm font-semibold text-orange-800">Sales end in:</span>
                                            </div>
                                            <div class="text-sm font-bold text-orange-900" id="countdown-{{ $event->id }}">
                                                Loading...
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Price & Tickets -->
                                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                                        <div>
                                            <span class="text-3xl font-bold text-purple-600">{{ $event->formatted_price }}</span>
                                            <p class="text-sm text-gray-500 mt-1">{{ $event->available_tickets }} tickets left</p>
                                        </div>
                                        <a href="{{ route('public.events.show', $event) }}" 
                                           class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-bold text-base transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $events->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">No events found</h3>
                        <p class="mt-1 text-gray-500">Try adjusting your filters or search terms.</p>
                        <div class="mt-6">
                            <a href="{{ route('public.events.index') }}" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition-colors">
                                Browse All Events
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
// Countdown Timer Function
function updateCountdowns() {
    @php
        $eventsData = [];
        foreach($events as $event) {
            $eventsData[$event->id] = [
                'date' => $event->event_date->format('Y-m-d'),
                'time' => $event->event_time->format('H:i:s')
            ];
        }
    @endphp
    
    const events = @json($eventsData);
    
    Object.keys(events).forEach(eventId => {
        const eventDate = new Date(events[eventId].date + 'T' + events[eventId].time);
        const now = new Date();
        const difference = eventDate - now;
        
        const element = document.getElementById('countdown-' + eventId);
        if (!element) return;
        
        if (difference > 0) {
            const days = Math.floor(difference / (1000 * 60 * 60 * 24));
            const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            
            let countdownText = '';
            if (days > 0) {
                countdownText = days + ' day' + (days !== 1 ? 's' : '');
            } else if (hours > 0) {
                countdownText = hours + ' hour' + (hours !== 1 ? 's' : '');
            } else {
                countdownText = minutes + ' min' + (minutes !== 1 ? 's' : '');
            }
            
            element.textContent = countdownText;
        } else {
            element.textContent = 'Sales ended';
            element.parentElement.parentElement.classList.add('bg-red-50', 'border-red-200');
            element.classList.remove('text-orange-900');
            element.classList.add('text-red-900');
        }
    });
}

// Update countdowns immediately and then every minute
updateCountdowns();
setInterval(updateCountdowns, 60000);
</script>
@endsection
