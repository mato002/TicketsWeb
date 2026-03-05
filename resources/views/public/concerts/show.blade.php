@extends('layouts.public')

@section('title', $concert->title . ' - ConcertHub')
@section('description', $concert->description ? Str::limit($concert->description, 160) : 'Join us for an amazing concert experience with ' . $concert->artist . ' at ' . $concert->venue . ' on ' . $concert->event_date->format('M j, Y') . '.')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Concert Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Concert Image -->
                <div class="lg:w-1/2">
                    <div class="relative">
                        @if($concert->image_url)
                            <img src="{{ $concert->image_url }}" alt="{{ $concert->title }}" class="w-full h-96 object-cover rounded-lg shadow-lg">
                        @else
                            <div class="w-full h-96 bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg shadow-lg flex items-center justify-center">
                                <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.369 4.369 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                                </svg>
                            </div>
                        @endif
                        @if($concert->featured)
                            <div class="absolute top-4 left-4">
                                <span class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                                    Featured Event
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Concert Info -->
                <div class="lg:w-1/2">
                    <div class="mb-4">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">{{ $concert->title }}</h1>
                        <p class="text-2xl text-purple-600 font-semibold">{{ $concert->artist }}</p>
                    </div>

                    <div class="space-y-4 mb-6">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $concert->venue }}</p>
                                <p class="text-gray-600">{{ $concert->venue_address }}, {{ $concert->city }}, {{ $concert->state }}</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $concert->event_date->format('l, F j, Y') }}</p>
                                <p class="text-gray-600">{{ $concert->event_time->format('g:i A') }} ({{ $concert->duration_minutes }} minutes)</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">Starting from {{ $concert->formatted_price }}</p>
                                <p class="text-gray-600">{{ $concert->available_tickets }} tickets remaining</p>
                            </div>
                        </div>
                    </div>

                    @if($concert->description)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">About This Event</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $concert->description }}</p>
                        </div>
                    @endif

                    <!-- Quick Actions -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('public.booking.show', $concert) }}" 
                           class="flex-1 bg-purple-600 text-white px-6 py-4 rounded-lg font-semibold hover:bg-purple-700 transition-colors text-center">
                            Book Tickets Now
                        </a>
                        <button onclick="shareConcert()" 
                                class="flex-1 bg-gray-200 text-gray-800 px-6 py-4 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                            Share Event
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Ticket Categories -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Ticket Categories</h2>
                    
                    @if($concert->ticket_categories && count($concert->ticket_categories) > 0)
                        <div class="space-y-4">
                            @foreach($concert->ticket_categories as $category => $details)
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-300 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ $details['name'] ?? ucfirst($category) }}</h3>
                                            @if(isset($details['description']))
                                                <p class="text-gray-600 text-sm">{{ $details['description'] }}</p>
                                            @endif
                                            @if(isset($details['benefits']) && is_array($details['benefits']))
                                                <ul class="text-sm text-gray-600 mt-2">
                                                    @foreach($details['benefits'] as $benefit)
                                                        <li class="flex items-center">
                                                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            {{ $benefit }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <p class="text-2xl font-bold text-purple-600">${{ number_format($details['price'] ?? $concert->base_price, 2) }}</p>
                                            <p class="text-sm text-gray-600">per ticket</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-semibold text-gray-900">General Admission</h3>
                                    <p class="text-gray-600 text-sm">Standard ticket for the event</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-purple-600">{{ $concert->formatted_price }}</p>
                                    <p class="text-sm text-gray-600">per ticket</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Venue Map (Mock) -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Venue Map</h2>
                    <div class="bg-gray-100 rounded-lg h-64 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                            <p class="text-gray-600">Interactive venue map will be available soon</p>
                            <p class="text-sm text-gray-500">{{ $concert->venue }} seating layout</p>
                        </div>
                    </div>
                </div>

                <!-- Event Details -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Event Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Doors Open</h3>
                            <p class="text-gray-600">{{ $concert->event_time->subMinutes(30)->format('g:i A') }}</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Show Starts</h3>
                            <p class="text-gray-600">{{ $concert->event_time->format('g:i A') }}</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Duration</h3>
                            <p class="text-gray-600">{{ $concert->duration_minutes }} minutes</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Age Restrictions</h3>
                            <p class="text-gray-600">All ages welcome</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Booking Card -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-8 sticky top-24">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Ready to Book?</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Starting from</span>
                            <span class="text-2xl font-bold text-purple-600">{{ $concert->formatted_price }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Tickets Available</span>
                            <span class="font-semibold text-gray-900">{{ $concert->available_tickets }}</span>
                        </div>
                        <div class="pt-4 border-t">
                            <a href="{{ route('public.booking.show', $concert) }}" 
                               class="w-full bg-purple-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-purple-700 transition-colors text-center block">
                                Get Tickets
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Nearby Accommodations -->
                @if($nearbyAccommodations->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Nearby Accommodations</h3>
                        <div class="space-y-4">
                            @foreach($nearbyAccommodations->take(3) as $accommodation)
                                <div class="border border-gray-200 rounded-lg p-3">
                                    <h4 class="font-semibold text-gray-900 text-sm">{{ $accommodation->name }}</h4>
                                    <p class="text-gray-600 text-xs">{{ $accommodation->type }}</p>
                                    <div class="flex items-center justify-between mt-2">
                                        <span class="text-purple-600 font-semibold text-sm">{{ $accommodation->formatted_price }}/night</span>
                                        @if($accommodation->rating)
                                            <span class="text-yellow-500 text-xs">⭐ {{ $accommodation->formatted_rating }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            <a href="{{ route('public.booking.accommodation') }}" class="text-purple-600 text-sm font-medium hover:underline">
                                View all accommodations →
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Similar Concerts -->
                @if($similarConcerts->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Similar Concerts</h3>
                        <div class="space-y-4">
                            @foreach($similarConcerts as $similar)
                                <a href="{{ route('public.concerts.show', $similar) }}" class="block border border-gray-200 rounded-lg p-3 hover:border-purple-300 transition-colors">
                                    <h4 class="font-semibold text-gray-900 text-sm">{{ $similar->title }}</h4>
                                    <p class="text-gray-600 text-xs">{{ $similar->artist }}</p>
                                    <p class="text-gray-600 text-xs">{{ $similar->event_date->format('M j, Y') }}</p>
                                    <span class="text-purple-600 font-semibold text-sm">{{ $similar->formatted_price }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function shareConcert() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $concert->title }}',
                text: 'Check out this amazing concert!',
                url: window.location.href
            });
        } else {
            // Fallback: copy to clipboard
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Link copied to clipboard!');
            });
        }
    }
</script>
@endpush
@endsection
