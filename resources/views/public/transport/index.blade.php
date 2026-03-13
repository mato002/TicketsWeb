@extends('layouts.public')

@section('title', 'Transport Services - TwendeeTickets')
@section('description', 'Browse and book transport services for events across Kenya. Find comfortable and affordable transport options to get to your favorite events with TwendeeTickets.')

@section('content')
<!-- Include Popup Banner Components -->
@include('components.popup-banner')
@include('components.scroll-popup')

<div class="bg-gray-50 min-h-screen" x-data="{ mobileFiltersOpen: false }">
    <!-- Header Section -->
    <div class="bg-white shadow-sm" style="background-image: url('https://images.unsplash.com/photo-1446746379205-3a53b9c9a6c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=60'); background-size: cover; background-position: center;">
        <div class="bg-white bg-opacity-95 backdrop-blur-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="text-center">
                    <h1 class="text-3xl md:text-4xl font-black text-gray-900 mb-4">
                        <i class="fas fa-bus text-orange-500"></i> Transport Services
                    </h1>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Travel to events in comfort and style with our reliable transport services
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
                <span>Filter Transport</span>
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
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter Transport</h3>
                    
                    <form action="{{ route('public.transport.search') }}" method="GET" class="space-y-6">
                        <!-- Search Bar -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search Location</label>
                            <div class="relative">
                                <input type="text" 
                                       name="pickup_location" 
                                       value="{{ request('pickup_location') }}"
                                       placeholder="Enter city, venue, or location..."
                                       class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <svg class="absolute left-3 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Event Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Event</label>
                            <select name="event_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                                    style="color: #374151 !important; background-color: #ffffff !important;">
                                <option value="">All Events</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }} style="color: #374151 !important; background-color: #ffffff !important;">
                                        {{ $event->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- City Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                            <select name="pickup_city" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                                    style="color: #374151 !important; background-color: #ffffff !important;">
                                <option value="">All Cities</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city }}" {{ request('pickup_city') == $city ? 'selected' : '' }} style="color: #374151 !important; background-color: #ffffff !important;">
                                        {{ $city }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Travel Date</label>
                            <input type="date" 
                                   name="date" 
                                   value="{{ request('date') }}"
                                   min="{{ now()->format('Y-m-d') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>

                        <!-- Price Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Max Price</label>
                            <input type="number" 
                                   name="max_price" 
                                   value="{{ request('max_price') }}"
                                   min="0" 
                                   step="100"
                                   placeholder="e.g., 2000"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>

                        <!-- Filter Actions -->
                        <div class="space-y-3">
                            <button type="submit" class="w-full bg-purple-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                                <i class="fas fa-search mr-2"></i> Search Transport
                            </button>
                            @if(request()->filled('pickup_location') || request()->filled('pickup_city') || request()->filled('event_id') || request()->filled('date') || request()->filled('min_price') || request()->filled('max_price'))
                                <a href="{{ route('public.transport.index') }}" class="block w-full bg-gray-200 text-gray-700 py-3 px-4 rounded-lg font-semibold hover:bg-gray-300 transition-colors text-center">
                                    <i class="fas fa-times mr-2"></i> Clear Filters
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:w-3/4">
                <!-- Transport Schedules Grid -->
                @if($schedules->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($schedules as $schedule)
                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                                <!-- Vehicle Image -->
                                <div class="relative h-48 bg-gradient-to-br from-orange-400 to-yellow-500">
                                    @if($schedule->vehicle->features_list && in_array('WiFi', $schedule->vehicle->features_list))
                                        <div class="absolute top-4 right-4 bg-white bg-opacity-90 px-3 py-1 rounded-full text-xs font-bold">
                                            <i class="fas fa-wifi text-orange-600"></i> WiFi
                                        </div>
                                    @endif
                                    <div class="flex items-center justify-center h-full">
                                        <i class="fas fa-bus text-white text-4xl"></i>
                                    </div>
                                </div>

                                <!-- Transport Details -->
                                <div class="p-6">
                                    <!-- Event and Route -->
                                    <div class="mb-4">
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                                            <a href="{{ route('public.events.show', $schedule->event) }}" class="text-purple-600 hover:text-purple-700">
                                                {{ $schedule->event->title }}
                                            </a>
                                        </h3>
                                        <div class="flex items-center text-gray-600 text-sm mb-2">
                                            <i class="fas fa-route mr-2 text-orange-500"></i>
                                            {{ $schedule->route->full_route }} ({{ $schedule->route->formatted_distance }})
                                        </div>
                                    </div>

                                    <!-- Pickup and Dropoff -->
                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-700 mb-2">Pickup</h4>
                                            <div class="flex items-center text-gray-600">
                                                <i class="fas fa-map-marker-alt mr-2 text-green-500"></i>
                                                <span>{{ $schedule->pickup_point_name }}</span>
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ $schedule->pickupPoint->address }}, {{ $schedule->pickupPoint->city }}
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-700 mb-2">Dropoff</h4>
                                            <div class="flex items-center text-gray-600">
                                                <i class="fas fa-flag-checkered mr-2 text-red-500"></i>
                                                <span>{{ $schedule->route->end_location }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Timing -->
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-700 mb-2">Departure</h4>
                                            <div class="flex items-center text-gray-600">
                                                <i class="fas fa-clock mr-2 text-blue-500"></i>
                                                <span>{{ $schedule->formatted_departure_time }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-700 mb-2">Arrival</h4>
                                            <div class="flex items-center text-gray-600">
                                                <i class="fas fa-clock mr-2 text-green-500"></i>
                                                <span>{{ $schedule->formatted_arrival_time }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Duration -->
                                    <div class="text-center mb-4">
                                        <span class="bg-orange-100 text-orange-800 px-3 py-2 rounded-full text-sm font-bold">
                                            <i class="fas fa-hourglass-half mr-2"></i>
                                            {{ $schedule->formatted_duration }}
                                        </span>
                                    </div>

                                    <!-- Vehicle Info -->
                                    <div class="border-t border-gray-200 pt-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <div>
                                                <h4 class="text-sm font-bold text-gray-700">Vehicle</h4>
                                                <div class="text-gray-600">
                                                    <span class="font-medium">{{ $schedule->vehicle->full_name }}</span>
                                                    <span class="text-gray-500">({{ $schedule->vehicle->type }})</span>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-2xl font-bold text-orange-500">{{ $schedule->formatted_price }}</span>
                                                <div class="text-sm text-gray-500">per person</div>
                                            </div>
                                        </div>
                                        <div class="text-xs text-gray-600">
                                            <i class="fas fa-users mr-2"></i> {{ $schedule->remaining_seats }} seats available
                                        </div>
                                    </div>

                                    <!-- Features -->
                                    @if($schedule->vehicle->features_list)
                                        <div class="flex flex-wrap gap-2 mt-3">
                                            @foreach($schedule->vehicle->features_list as $feature)
                                                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-bold">
                                                    {{ $feature }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                <!-- Book Button -->
                                <div class="p-6 pt-0 border-t border-gray-200">
                                    @if($schedule->remaining_seats > 0)
                                        <a href="{{ route('public.transport.show', $schedule) }}" 
                                           class="block w-full bg-orange-500 text-white text-center py-4 px-6 rounded-xl font-bold hover:bg-orange-600 transition-all transform hover:scale-105 shadow-lg">
                                            <i class="fas fa-eye mr-2"></i> View Details & Book
                                        </a>
                                    @else
                                        <div class="text-center">
                                            <div class="bg-red-100 text-red-800 px-4 py-3 rounded-lg mb-4">
                                                <i class="fas fa-times-circle mr-2"></i> Fully Booked
                                            </div>
                                            <button disabled 
                                                    class="w-full bg-gray-300 text-gray-500 text-center py-4 px-6 rounded-xl font-bold cursor-not-allowed">
                                                <i class="fas fa-ban mr-2"></i> No Seats Available
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($schedules->hasPages())
                        <div class="mt-8">
                            {{ $schedules->links() }}
                        </div>
                    @endif
                @else
                    <!-- No Transport Available -->
                    <div class="text-center py-16">
                        <div class="w-32 h-32 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-bus text-gray-400 text-4xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">No Transport Available</h2>
                        <p class="text-gray-600 text-lg mb-8 max-w-md mx-auto">
                            We couldn't find any transport options matching your criteria. 
                            Try adjusting your filters or check back later for new schedules.
                        </p>
                        <div class="space-y-4">
                            <a href="{{ route('public.transport.index') }}" 
                               class="inline-block bg-orange-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-600 transition-colors">
                                <i class="fas fa-search mr-2"></i> Browse All Transport
                            </a>
                            <div>
                                <a href="{{ route('public.events.index') }}" class="text-orange-500 hover:text-orange-600 font-medium">
                                    <i class="fas fa-arrow-left mr-2"></i> Back to Events
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

<!-- Transport Features Section -->
<section class="py-16 bg-gradient-to-br from-orange-50 to-yellow-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-3xl p-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">
                    <i class="fas fa-star text-orange-500"></i> Why Choose Our Transport?
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shield-alt text-orange-500 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Safe & Reliable</h3>
                    <p class="text-gray-600">
                        Professional drivers, well-maintained vehicles, and comprehensive insurance coverage for your peace of mind.
                    </p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-route text-orange-500 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Multiple Routes</h3>
                    <p class="text-gray-600">
                        Extensive network of pickup points and destinations across major Kenyan cities and event venues.
                    </p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-orange-500 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Comfortable Travel</h3>
                    <p class="text-gray-600">
                        Modern vehicles with WiFi, air conditioning, music systems, and comfortable seating for enjoyable journeys.
                    </p>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('public.transport.index') }}" 
                   class="inline-block bg-orange-500 text-white px-10 py-4 rounded-2xl font-bold text-lg hover:from-orange-600 hover:to-yellow-600 transition-all transform hover:scale-105 shadow-2xl">
                    <i class="fas fa-bus mr-3"></i> Explore All Transport Options
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Quick Stats -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            <div class="bg-orange-50 rounded-2xl p-6">
                <div class="text-4xl font-bold text-orange-500 mb-2">{{ App\Models\TransportSchedule::count() }}</div>
                <div class="text-gray-600">Active Routes</div>
            </div>
            <div class="bg-purple-50 rounded-2xl p-6">
                <div class="text-4xl font-bold text-purple-600 mb-2">{{ App\Models\Vehicle::count() }}</div>
                <div class="text-gray-600">Vehicles in Fleet</div>
            </div>
            <div class="bg-green-50 rounded-2xl p-6">
                <div class="text-4xl font-bold text-green-600 mb-2">{{ App\Models\PickupPoint::count() }}</div>
                <div class="text-gray-600">Pickup Points</div>
            </div>
            <div class="bg-blue-50 rounded-2xl p-6">
                <div class="text-4xl font-bold text-blue-600 mb-2">{{ App\Models\TransportBooking::count() }}</div>
                <div class="text-gray-600">Happy Customers</div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Auto-refresh for real-time updates
    setInterval(function() {
        // Refresh seat availability every 30 seconds
        fetch('{{ route("public.transport.index") }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            // Update seat counts without full page reload
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            const seatCounts = tempDiv.querySelectorAll('.text-gray-600');
            seatCounts.forEach((element, index) => {
                const currentElement = document.querySelector(`.text-gray-600:nth-child(${index + 1})`);
                if (currentElement && currentElement.textContent !== element.textContent) {
                    currentElement.textContent = element.textContent;
                }
            });
        })
        .catch(error => console.error('Error updating transport data:', error));
    }, 30000); // 30 seconds
</script>
@endsection
