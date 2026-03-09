@extends('layouts.public')

@section('title', $concert->title . ' - ConcertHub')
@section('description', $concert->description ? Str::limit($concert->description, 160) : 'Join us for an amazing concert experience with ' . $concert->artist . ' at ' . $concert->venue . ' on ' . $concert->event_date->format('M j, Y') . '.')

@section('content')
<div class="min-h-screen">
    <!-- Hero Section with Background Image -->
    <div class="relative h-96 lg:h-[500px]">
        @if($concert->image_url)
            <div class="absolute inset-0">
                <img src="{{ $concert->image_url }}" alt="{{ $concert->title }}" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/60"></div>
            </div>
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-purple-600 via-blue-600 to-purple-800">
                <div class="absolute inset-0 bg-black/20"></div>
            </div>
        @endif
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
            <div class="text-white max-w-3xl">
                <!-- Featured Badge -->
                <div class="mb-4">
                    @if($concert->featured)
                        <span class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                            Featured Concert
                        </span>
                    @endif
                </div>
                
                <h1 class="text-4xl md:text-6xl font-bold mb-4 leading-tight">{{ $concert->title }}</h1>
                <p class="text-xl md:text-2xl mb-6 text-purple-100 font-semibold">{{ $concert->artist }}</p>
                
                <div class="flex flex-wrap gap-4 mb-8">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $concert->venue }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $concert->event_date->format('M j, Y') }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $concert->event_time->format('g:i A') }}</span>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    @if($concert->available_tickets > 0)
                        <a href="{{ route('public.booking.show', $concert) }}" 
                           class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all transform hover:scale-105 shadow-xl">
                            Book Tickets - {{ $concert->formatted_price }}
                        </a>
                    @else
                        <button disabled class="bg-gray-400 text-white px-8 py-4 rounded-lg font-semibold text-lg cursor-not-allowed shadow-xl">
                            Sold Out
                        </button>
                    @endif
                    <button onclick="shareConcert()" 
                            class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all border border-white/30">
                        Share Concert
                    </button>
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
                                            <p class="text-2xl font-bold text-purple-600">KSH {{ number_format($details['price'] ?? $concert->base_price, 2) }}</p>
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
                                <a href="{{ route('public.events.show', $similar) }}" class="block border border-gray-200 rounded-lg p-3 hover:border-purple-300 transition-colors">
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
