@extends('layouts.public')

@section('title', $event->title . ' - TwendeeTickets')
@section('description', $event->description ? Str::limit($event->description, 160) : 'Join us for an amazing event experience with ' . $event->organizer . ' at ' . $event->venue . ' on ' . $event->event_date->format('M j, Y') . '.')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Event Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Event Image -->
                <div class="lg:w-1/2">
                    <div class="relative">
                        @if($event->image_url)
                            <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full h-96 object-cover rounded-lg shadow-lg">
                        @else
                            <div class="w-full h-96 bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg shadow-lg flex items-center justify-center">
                                <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.369 4.369 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Event Type Badge -->
                        <div class="absolute top-4 left-4">
                            <span class="bg-{{ $event->event_type_color }}-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                                {{ $event->event_type_name }}
                            </span>
                        </div>
                        
                        @if($event->featured)
                            <div class="absolute top-4 right-4">
                                <span class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                                    Featured Event
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Event Info -->
                <div class="lg:w-1/2">
                    <div class="mb-4">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">{{ $event->title }}</h1>
                        <p class="text-2xl text-purple-600 font-semibold">{{ $event->organizer }}</p>
                    </div>

                    <div class="space-y-4 mb-6">
                        <!-- Venue -->
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $event->venue }}</p>
                                <p class="text-gray-600">{{ $event->venue_address }}, {{ $event->city }}, {{ $event->state }}</p>
                            </div>
                        </div>

                        <!-- Date & Time -->
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $event->event_date->format('l, F j, Y') }}</p>
                                <p class="text-gray-600">{{ $event->event_time->format('g:i A') }} ({{ $event->duration_minutes }} minutes)</p>
                            </div>
                        </div>

                        <!-- Tickets -->
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $event->available_tickets }} tickets available</p>
                                <p class="text-gray-600">of {{ $event->total_tickets }} total</p>
                            </div>
                        </div>
                    </div>

                    <!-- Price and Booking -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Starting from</p>
                                <p class="text-4xl font-bold text-purple-600">{{ $event->formatted_price }}</p>
                            </div>
                            @if($event->available_tickets > 0)
                                <a href="{{ route('public.booking.show', $event) }}" 
                                   class="bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                                    Book Now
                                </a>
                            @else
                                <button disabled class="bg-gray-400 text-white px-8 py-3 rounded-lg font-semibold cursor-not-allowed">
                                    Sold Out
                                </button>
                            @endif
                        </div>
                        
                        @if($event->ticket_categories && count($event->ticket_categories) > 0)
                            <div class="border-t pt-4">
                                <p class="text-sm font-semibold text-gray-700 mb-2">Ticket Categories:</p>
                                <div class="space-y-1">
                                    @foreach($event->ticket_categories as $category)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">{{ $category['name'] ?? 'Standard' }}</span>
                                            <span class="font-medium">KSH {{ number_format($category['price'] ?? $event->base_price, 2) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Share -->
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">Share this event:</span>
                        <button class="text-gray-400 hover:text-purple-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </button>
                        <button class="text-gray-400 hover:text-purple-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </button>
                        <button class="text-gray-400 hover:text-purple-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Details -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Description -->
                @if($event->description)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">About This Event</h2>
                        <div class="prose prose-lg max-w-none">
                            <p class="text-gray-700 leading-relaxed">{{ $event->description }}</p>
                        </div>
                    </div>
                @endif

                <!-- Venue Details -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Venue Information</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">{{ $event->venue }}</h3>
                            <p class="text-gray-600">{{ $event->venue_address }}</p>
                            <p class="text-gray-600">{{ $event->city }}, {{ $event->state }}, {{ $event->country }}</p>
                        </div>
                        
                        @if($event->latitude && $event->longitude)
                            <div class="bg-gray-100 rounded-lg h-64 flex items-center justify-center">
                                <p class="text-gray-500">Map will be displayed here</p>
                                <!-- You can integrate Google Maps or other map service here -->
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Additional Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Event Type</h3>
                            <p class="text-gray-600">{{ $event->event_type_name }}</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Duration</h3>
                            <p class="text-gray-600">{{ $event->duration_minutes }} minutes</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Status</h3>
                            <p class="text-gray-600">{{ ucfirst($event->status) }}</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Organizer</h3>
                            <p class="text-gray-600">{{ $event->organizer }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Booking -->
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Booking</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-600">Price starts at</p>
                            <p class="text-2xl font-bold text-purple-600">{{ $event->formatted_price }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">{{ $event->available_tickets }} tickets left</p>
                        </div>
                        @if($event->available_tickets > 0)
                            <a href="{{ route('public.booking.show', $event) }}" 
                               class="w-full bg-purple-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-purple-700 transition-colors text-center block">
                                Book Tickets
                            </a>
                        @else
                            <button disabled class="w-full bg-gray-400 text-white py-3 px-4 rounded-lg font-semibold cursor-not-allowed">
                                Sold Out
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Related Events -->
                @if($relatedEvents->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Similar Events</h3>
                        <div class="space-y-4">
                            @foreach($relatedEvents as $relatedEvent)
                                <div class="flex space-x-3">
                                    <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-blue-500 rounded-lg flex-shrink-0"></div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 text-sm">{{ $relatedEvent->title }}</h4>
                                        <p class="text-xs text-gray-600">{{ $relatedEvent->event_date->format('M j, Y') }}</p>
                                        <p class="text-sm font-medium text-purple-600">{{ $relatedEvent->formatted_price }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
