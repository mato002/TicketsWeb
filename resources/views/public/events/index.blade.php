@extends('layouts.public')

@section('title', 'Browse Events - EventHub')
@section('description', 'Browse through hundreds of upcoming events including sports, music festivals, comedy, car shows, travel, hiking, art, and gallery events. Find your perfect event by type, location, or date.')

@section('content')
<div class="bg-gray-50 min-h-screen" x-data="{ mobileFiltersOpen: false }">
    <!-- Header Section -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Discover Amazing Events</h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Browse through our curated collection of upcoming events including sports, music, comedy, art, and more to find your perfect experience
                </p>
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
                        <!-- Event Type Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Event Type</label>
                            <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="all" {{ request('type') == 'all' || !request('type') ? 'selected' : '' }}>All Events</option>
                                @foreach($eventTypes as $key => $label)
                                    <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search events..." 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>

                        <!-- Sort -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                            <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="date" {{ request('sort') == 'date' ? 'selected' : '' }}>Date</option>
                                <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Price</option>
                                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title</option>
                            </select>
                        </div>

                        <!-- Sort Order -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Order</label>
                            <select name="order" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Descending</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-purple-600 text-white py-2 px-4 rounded-md hover:bg-purple-700 transition-colors">
                            Apply Filters
                        </button>
                        
                        <a href="{{ route('public.events.index') }}" class="block w-full text-center bg-gray-200 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-300 transition-colors">
                            Clear Filters
                        </a>
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
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($events as $event)
                            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden group">
                                <!-- Event Image -->
                                <div class="relative h-48 bg-gradient-to-br from-purple-400 to-blue-500 overflow-hidden">
                                    @if($event->image_url)
                                        <img src="{{ $event->image_url }}" alt="{{ $event->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-16 h-16 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
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
                                    
                                    @if($event->featured)
                                        <div class="absolute top-4 right-4">
                                            <span class="bg-yellow-400 text-yellow-900 px-2 py-1 rounded-full text-xs font-semibold">
                                                Featured
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Event Details -->
                                <div class="p-6">
                                    <div class="mb-4">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                            <a href="{{ route('public.events.show', $event) }}" class="hover:text-purple-600 transition-colors">
                                                {{ $event->title }}
                                            </a>
                                        </h3>
                                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                            {{ $event->description }}
                                        </p>
                                        
                                        <div class="space-y-2">
                                            <!-- Organizer -->
                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                {{ $event->organizer }}
                                            </div>
                                            
                                            <!-- Venue -->
                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                {{ $event->venue }}, {{ $event->city }}
                                            </div>
                                            
                                            <!-- Date & Time -->
                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ $event->event_date->format('M j, Y') }} at {{ $event->event_time->format('g:i A') }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Price & Tickets -->
                                    <div class="flex items-center justify-between pt-4 border-t">
                                        <div>
                                            <span class="text-2xl font-bold text-purple-600">{{ $event->formatted_price }}</span>
                                            <p class="text-xs text-gray-500">{{ $event->available_tickets }} tickets left</p>
                                        </div>
                                        <a href="{{ route('public.events.show', $event) }}" 
                                           class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition-colors text-sm font-medium">
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
@endsection
