@extends('layouts.public')

@section('title', $schedule->event->title . ' - Transport Details - TwendeeTickets')
@section('description', 'View transport details for ' . $schedule->event->title . ' including vehicle information, route details, pricing, and booking options. Book reliable transport to events with TwendeeTickets.')

@section('content')
<!-- Include Popup Banner Components -->
@include('components.popup-banner')
@include('components.scroll-popup')

<div class="bg-gray-50 min-h-screen py-8" style="background-image: url('https://images.unsplash.com/photo-1446746379205-3a53b9c9a6c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=60'); background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="bg-white bg-opacity-95 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li>
                        <a href="{{ route('public.home') }}" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-home"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.events.index') }}" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-calendar"></i>
                            Events
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.transport.index') }}" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-bus"></i>
                            Transport
                        </a>
                    </li>
                    <li class="flex items-center">
                        <span class="text-gray-500">{{ Str::limit($schedule->event->title, 30) }}</span>
                    </li>
                </ol>
            </nav>

            <!-- Transport Details -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Details -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <!-- Header with Event Info -->
                        <div class="relative h-48 bg-gradient-to-br from-orange-400 to-yellow-500">
                            <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                            <div class="flex items-center justify-center h-full">
                                <div class="text-center">
                                    <i class="fas fa-bus text-white text-5xl mb-2"></i>
                                    <h2 class="text-white text-2xl font-bold">Transport Details</h2>
                                </div>
                            </div>
                        </div>

                        <div class="p-8">
                            <!-- Event Information -->
                            <div class="mb-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-3">
                                    <a href="{{ route('public.events.show', $schedule->event) }}" class="text-purple-600 hover:text-purple-700">
                                        {{ $schedule->event->title }}
                                    </a>
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-700 mb-2">Event Date</h4>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-calendar mr-2 text-blue-500"></i>
                                            {{ $schedule->event->event_date->format('M j, Y - g:i A') }}
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-700 mb-2">Event Venue</h4>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>
                                            {{ $schedule->event->venue }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Route Information -->
                            <div class="border-t border-gray-200 pt-6 mb-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">
                                    <i class="fas fa-route text-orange-500 mr-2"></i>
                                    {{ $schedule->route->name }}
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-700 mb-2">Route</h4>
                                        <div class="text-gray-600">
                                            {{ $schedule->route->full_route }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $schedule->route->formatted_distance }} • {{ $schedule->route->formatted_base_price }} base price
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-700 mb-2">Duration</h4>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-clock mr-2 text-green-500"></i>
                                            {{ $schedule->formatted_duration }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pickup & Dropoff -->
                            <div class="border-t border-gray-200 pt-6 mb-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">
                                    <i class="fas fa-map-marked-alt text-green-500 mr-2"></i>
                                    Pickup & Dropoff Points
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-700 mb-2">Pickup Point</h4>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-map-marker-alt mr-2 text-green-500"></i>
                                            <span>{{ $schedule->pickup_point_name }}</span>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $schedule->pickupPoint->full_address }}
                                        </div>
                                        @if($schedule->pickupPoint->coordinates)
                                            <a href="https://maps.google.com/?q={{ $schedule->pickupPoint->coordinates }}" 
                                               target="_blank" 
                                               class="text-blue-500 hover:text-blue-700 text-sm mt-2 inline-block">
                                                <i class="fas fa-external-link-alt mr-1"></i> View on Map
                                            </a>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-700 mb-2">Dropoff Point</h4>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-flag-checkered mr-2 text-red-500"></i>
                                            <span>{{ $schedule->route->end_location }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Timing -->
                            <div class="border-t border-gray-200 pt-6 mb-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">
                                    <i class="fas fa-clock text-blue-500 mr-2"></i>
                                    Schedule
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-700 mb-2">Departure</h4>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-play-circle mr-2 text-green-500"></i>
                                            {{ $schedule->formatted_departure_time }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            From {{ $schedule->pickupPoint->name }}
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-700 mb-2">Arrival</h4>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-stop-circle mr-2 text-red-500"></i>
                                            {{ $schedule->formatted_arrival_time }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            At {{ $schedule->route->end_location }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing -->
                            <div class="border-t border-gray-200 pt-6 mb-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">
                                    <i class="fas fa-tag text-orange-500 mr-2"></i>
                                    Pricing
                                </h3>
                                <div class="bg-orange-50 rounded-xl p-6">
                                    <div class="text-center mb-4">
                                        <div class="text-4xl font-bold text-orange-500">{{ $schedule->formatted_price }}</div>
                                        <div class="text-gray-600">per person</div>
                                    </div>
                                    <div class="text-sm text-gray-600 text-center">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Price includes: Professional driver, comfortable seating, air conditioning, and music system
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- Booking Form -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">
                            <i class="fas fa-ticket-alt text-purple-600 mr-2"></i>
                            Book This Transport
                        </h3>

                        @if($schedule->remaining_seats > 0)
                            <form action="{{ route('public.transport.book', $schedule) }}" method="POST" class="space-y-6">
                                @csrf
                                
                                <!-- Passenger Count -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-3">Number of Passengers</label>
                                    <select name="passengers_count" class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-purple-500 focus:border-transparent transition-all hover:border-purple-300" required>
                                        @for($i = 1; $i <= min($schedule->remaining_seats, 10); $i++)
                                            <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'Passenger' : 'Passengers' }}</option>
                                        @endfor
                                    </select>
                                    <div class="text-xs text-gray-500 mt-2">{{ $schedule->remaining_seats }} seats available</div>
                                </div>

                                <!-- Special Requests -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-3">Special Requests (Optional)</label>
                                    <textarea name="special_requests" 
                                              rows="4" 
                                              placeholder="Any special requirements or requests..."
                                              class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-purple-500 focus:border-transparent transition-all hover:border-purple-300"></textarea>
                                </div>

                                <!-- Price Summary -->
                                <div class="bg-gray-50 rounded-xl p-6 mb-6">
                                    <div class="flex justify-between items-center mb-4">
                                        <span class="text-gray-700">Selected Passengers:</span>
                                        <span class="font-bold text-gray-900" id="selectedPassengers">1</span>
                                    </div>
                                    <div class="flex justify-between items-center mb-4">
                                        <span class="text-gray-700">Price per Person:</span>
                                        <span class="font-bold text-gray-900">{{ $schedule->formatted_price }}</span>
                                    </div>
                                    <div class="flex justify-between items-center mb-4">
                                        <span class="text-gray-700">Total Price:</span>
                                        <span class="text-2xl font-bold text-orange-500" id="totalPrice">{{ $schedule->formatted_price }}</span>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                @auth
                                    <button type="submit" 
                                            class="w-full bg-orange-500 text-white py-4 px-6 rounded-xl font-bold text-lg hover:bg-orange-600 transition-all transform hover:scale-105 shadow-lg">
                                        <i class="fas fa-check mr-2"></i> Book Transport Now
                                    </button>
                                @else
                                    <div class="text-center">
                                        <p class="text-gray-600 mb-4">Please <a href="{{ route('login') }}" class="text-orange-500 hover:text-orange-600 font-medium">login</a> or <a href="{{ route('register') }}" class="text-orange-500 hover:text-orange-600 font-medium">register</a> to book transport.</p>
                                        <a href="{{ route('login') }}" class="block w-full bg-purple-600 text-white py-4 px-6 rounded-xl font-bold text-lg hover:bg-purple-700 transition-colors text-center">
                                            <i class="fas fa-sign-in-alt mr-2"></i> Login to Book
                                        </a>
                                    </div>
                                @endif
                            </form>
                        @else
                            <!-- Fully Booked -->
                            <div class="text-center">
                                <div class="w-32 h-32 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <i class="fas fa-times-circle text-red-500 text-4xl"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-red-600 mb-4">Fully Booked</h3>
                                <p class="text-gray-600 mb-6">This transport is fully booked. No more seats are available for this schedule.</p>
                                <div class="space-y-4">
                                    <a href="{{ route('public.transport.index') }}" class="block w-full bg-orange-500 text-white py-4 px-6 rounded-xl font-bold text-lg hover:bg-orange-600 transition-colors text-center">
                                        <i class="fas fa-search mr-2"></i> Find Other Transport Options
                                    </a>
                                    <a href="{{ route('public.events.show', $schedule->event) }}" class="block w-full bg-purple-600 text-white py-4 px-6 rounded-xl font-bold text-lg hover:bg-purple-700 transition-colors text-center">
                                        <i class="fas fa-arrow-left mr-2"></i> Back to Event
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Related Transport Options -->
            @if($relatedSchedules && $relatedSchedules->count() > 0)
                <div class="mt-12">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">
                        <i class="fas fa-bus text-orange-500 mr-2"></i>
                        Other Transport Options for This Event
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($relatedSchedules as $relatedSchedule)
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                                <!-- Vehicle Icon -->
                                <div class="relative h-32 bg-gradient-to-br from-blue-400 to-purple-600">
                                    <div class="flex items-center justify-center h-full">
                                        <i class="fas fa-bus text-white text-2xl"></i>
                                    </div>
                                </div>

                                <!-- Details -->
                                <div class="p-6">
                                    <h4 class="text-lg font-bold text-gray-900 mb-2">
                                        <a href="{{ route('public.transport.show', $relatedSchedule) }}" class="text-purple-600 hover:text-purple-700">
                                            {{ $relatedSchedule->event->title }}
                                        </a>
                                    </h4>
                                    <div class="space-y-2 text-sm text-gray-600">
                                        <div class="flex items-center">
                                            <i class="fas fa-route mr-2 text-orange-500"></i>
                                            {{ $relatedSchedule->route->full_route }}
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-clock mr-2 text-blue-500"></i>
                                            {{ $relatedSchedule->formatted_departure_time }}
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span>{{ $relatedSchedule->remaining_seats }} seats</span>
                                            <span class="font-bold text-orange-500">{{ $relatedSchedule->formatted_price }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Update price calculation based on passenger count
    document.addEventListener('DOMContentLoaded', function() {
        const passengersSelect = document.querySelector('select[name="passengers_count"]');
        const totalPriceElement = document.getElementById('totalPrice');
        const selectedPassengersElement = document.getElementById('selectedPassengers');
        const basePrice = {{ $schedule->price }};

        function updatePrice() {
            const passengers = parseInt(passengersSelect.value) || 1;
            const totalPrice = basePrice * passengers;
            
            if (totalPriceElement) {
                totalPriceElement.textContent = 'KSH ' + totalPrice.toLocaleString();
            }
            if (selectedPassengersElement) {
                selectedPassengersElement.textContent = passengers + (passengers === 1 ? ' Passenger' : ' Passengers');
            }
        }

        if (passengersSelect) {
            passengersSelect.addEventListener('change', updatePrice);
        }

        // Initialize
        updatePrice();
    });
</script>
@endsection
