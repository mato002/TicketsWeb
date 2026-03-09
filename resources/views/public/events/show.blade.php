@extends('layouts.public')

@section('title', $event->title . ' - TwendeeTickets')
@section('description', $event->description ? Str::limit($event->description, 160) : 'Join us for an amazing event experience with ' . $event->organizer . ' at ' . $event->venue . ' on ' . $event->event_date->format('M j, Y') . '.')

@section('content')
<div class="min-h-screen">
    <!-- Hero Section with Background Image -->
    <div class="relative h-96 lg:h-[500px] hero-section">
        @if($event->image_url)
            <div class="absolute inset-0 z-0">
                <img src="{{ $event->image_url ?: '/images/hero/event-default-hero-bg.svg' }}" alt="{{ $event->title }}" 
                     class="w-full h-full object-cover">
            </div>
            <div class="absolute inset-0 bg-black bg-opacity-40 z-10"></div>
        @else
            <div class="absolute inset-0 z-0">
                <img src="https://images.pexels.com/photos/1105666/pexels-photo-1105666.jpeg?auto=compress&cs=tinysrgb&w=1920&h=1080&fit=crop" alt="Event Background"
            </div>
            <div class="absolute inset-0 bg-gradient-to-br from-purple-600 via-blue-600 to-purple-800 bg-opacity-90 z-10"></div>
        @endif
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
            <div class="text-white max-w-3xl">
                <!-- Event Type Badge -->
                <div class="mb-4">
                    <span class="bg-{{ $event->event_type_color ?? 'purple' }}-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                        {{ $event->event_type_name ?? 'Event' }}
                    </span>
                    @if($event->featured)
                        <span class="ml-2 bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                            Featured Event
                        </span>
                    @endif
                </div>
                
                <h1 class="text-4xl md:text-6xl font-bold mb-4 leading-tight">{{ $event->title }}</h1>
                <p class="text-xl md:text-2xl mb-6 text-purple-100 font-semibold">{{ $event->organizer }}</p>
                
                <div class="flex flex-wrap gap-4 mb-8">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $event->venue }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $event->event_date->format('M j, Y') }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $event->event_time->format('g:i A') }}</span>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4 relative z-20">
                    @if($event->available_tickets > 0)
                        <a href="{{ route('public.booking.show', $event) }}" 
                           class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all transform hover:scale-105 shadow-xl pointer-events-auto">
                            Book Now - {{ $event->formatted_price }}
                        </a>
                    @else
                        <button disabled class="bg-gray-400 text-white px-8 py-4 rounded-lg font-semibold text-lg cursor-not-allowed shadow-xl pointer-events-auto">
                            Sold Out
                        </button>
                    @endif
                    <div class="relative" x-data="{ shareOpen: false }">
                        <button @click="shareOpen = !shareOpen" @click.outside="shareOpen = false" 
                                class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all border border-white/30 flex items-center pointer-events-auto">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                            </svg>
                            Share Event
                        </button>
                        
                        <!-- Share Dropdown -->
                        <div x-show="shareOpen" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute top-full left-0 mt-2 w-64 bg-white rounded-lg shadow-xl border border-gray-200 z-50">
                            <div class="p-4">
                                <h4 class="text-sm font-semibold text-gray-900 mb-3">Share this event</h4>
                                
                                <!-- Copy Link -->
                                <div class="mb-3">
                                    <button onclick="navigator.clipboard.writeText(window.location.href); this.textContent = 'Copied!'; setTimeout(() => this.textContent = 'Copy Link', 2000)" 
                                            class="w-full flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                                        <svg class="w-5 h-5 text-gray-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                        </svg>
                                        <span class="text-sm text-gray-700">Copy Link</span>
                                    </button>
                                </div>
                                
                                <!-- Social Media Links -->
                                <div class="space-y-2">
                                    <a :href="`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(window.location.href)}`" 
                                       target="_blank" 
                                       class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                                        <svg class="w-5 h-5 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                        <span class="text-sm text-gray-700">Facebook</span>
                                    </a>
                                    
                                    <a :href="`https://twitter.com/intent/tweet?url=${encodeURIComponent(window.location.href)}&text=${encodeURIComponent('Check out this event: {{ $event->title }}')}`" 
                                       target="_blank" 
                                       class="flex items-center p-3 bg-sky-50 hover:bg-sky-100 rounded-lg transition-colors">
                                        <svg class="w-5 h-5 text-sky-600 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 00-2.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-7.607-4.627 4.902 4.902 0 00-2.227.616 13.99 13.99 0 01-10.147-5.144 4.92 4.92 0 001.523 6.574 4.9 4.9 0 002.227-.616 4.918 4.918 0 003.127-1.184 4.9 4.9 0 002.163-2.723 10 10 0 01-2.825.775z"/>
                                        </svg>
                                        <span class="text-sm text-gray-700">Twitter</span>
                                    </a>
                                    
                                    <a :href="`https://wa.me/?text=${encodeURIComponent('Check out this event: {{ $event->title }} - ' + window.location.href)}`" 
                                       target="_blank" 
                                       class="flex items-center p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                                        <svg class="w-5 h-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2zm.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.48 0-2.93-.39-4.19-1.15l-.3-.18-.31.08-1.26.33.33-1.22.09-.34-.2-.32a8.188 8.188 0 01-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.87.86-.87 2.07 0 1.22.89 2.39 1 2.56.12.17 1.76 2.67 4.25 3.73.59.27 1.05.42 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.16-.48-.27-.25-.14-1.47-.74-1.69-.82-.23-.08-.37-.12-.56.12-.16.25-.64.81-.78.97-.15.17-.29.19-.53.07-.26-.13-1.06-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.12-.24-.01-.39.11-.5.11-.11.27-.29.37-.44.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.11-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43-.14 0-.3-.01-.47-.01z"/>
                                        </svg>
                                        <span class="text-sm text-gray-700">WhatsApp</span>
                                    </a>
                                </div>
                            </div>
                        </div>
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
                                <a href="{{ route('public.events.show', $relatedEvent) }}" 
                                   class="flex space-x-3 p-2 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-purple-300 transition-colors">
                                    <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-blue-500 rounded-lg flex-shrink-0"></div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 text-sm hover:text-purple-600">{{ $relatedEvent->title }}</h4>
                                        <p class="text-xs text-gray-600">{{ $relatedEvent->event_date->format('M j, Y') }}</p>
                                        <p class="text-sm font-medium text-purple-600">{{ $relatedEvent->formatted_price }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
