@extends('layouts.public')

@section('title', $accommodation->name . ' - TwendeeTickets')
@section('description', $accommodation->description ? Str::limit($accommodation->description, 160) : 'Book your stay at ' . $accommodation->name . ' in ' . $accommodation->city . '. ' . ucfirst($accommodation->type) . ' accommodation with great amenities.')

@section('content')
<!-- Include Popup Banner Components -->
@include('components.popup-banner')
@include('components.scroll-popup')
<div class="bg-gray-50 min-h-screen">
    <!-- Accommodation Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Accommodation Image -->
                <div class="lg:w-1/2">
                    <div class="relative">
                        @if($accommodation->images && count($accommodation->images) > 0)
                            <img src="{{ $accommodation->images[0] }}" alt="{{ $accommodation->name }}" class="w-full h-96 object-cover rounded-lg shadow-lg">
                        @else
                            <div class="w-full h-96 bg-gradient-to-r from-green-500 to-blue-500 rounded-lg shadow-lg flex items-center justify-center">
                                <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        @endif
                        @if($accommodation->is_featured)
                            <div class="absolute top-4 left-4">
                                <span class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                                    Featured
                                </span>
                            </div>
                        @endif
                        @if($accommodation->rating)
                            <div class="absolute top-4 right-4 bg-white bg-opacity-95 px-3 py-2 rounded-lg shadow">
                                <span class="text-lg font-semibold text-gray-900">⭐ {{ $accommodation->formatted_rating }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Accommodation Info -->
                <div class="lg:w-1/2">
                    <div class="mb-4">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">{{ $accommodation->name }}</h1>
                        <p class="text-xl text-green-600 font-semibold">{{ ucfirst($accommodation->type) }}</p>
                    </div>

                    <div class="space-y-4 mb-6">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $accommodation->address }}</p>
                                <p class="text-gray-600">{{ $accommodation->city }}, {{ $accommodation->state }} {{ $accommodation->zip_code }}</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">Available Rooms</p>
                                <p class="text-gray-600">{{ $accommodation->available_rooms }} rooms available</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            <div>
                                <p class="text-3xl font-bold text-green-600">{{ $accommodation->formatted_price }}</p>
                                <p class="text-gray-600">per night</p>
                            </div>
                        </div>
                    </div>

                    @if($accommodation->description)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">About This Property</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $accommodation->description }}</p>
                        </div>
                    @endif

                    <!-- Quick Actions -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('public.booking.accommodation') }}" 
                           class="flex-1 bg-green-600 text-white px-6 py-4 rounded-lg font-semibold hover:bg-green-700 transition-colors text-center">
                            Book Now
                        </a>
                        <a href="{{ route('public.accommodations.index') }}" 
                           class="flex-1 bg-gray-200 text-gray-800 px-6 py-4 rounded-lg font-semibold hover:bg-gray-300 transition-colors text-center">
                            View More Options
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Amenities -->
                @if($accommodation->amenities && count($accommodation->amenities) > 0)
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Amenities</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($accommodation->amenities as $amenity)
                            <div class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>{{ $amenity }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Additional Images -->
                @if($accommodation->images && count($accommodation->images) > 1)
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Photo Gallery</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach(array_slice($accommodation->images, 1) as $image)
                            <img src="{{ $image }}" alt="{{ $accommodation->name }}" class="w-full h-48 object-cover rounded-lg">
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Policies -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Policies</h2>
                    <div class="space-y-4 text-gray-700">
                        <div>
                            <h3 class="font-semibold mb-1">Check-in / Check-out</h3>
                            <p>Check-in: After 3:00 PM</p>
                            <p>Check-out: Before 11:00 AM</p>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-1">Cancellation</h3>
                            <p>Free cancellation up to 48 hours before check-in. Cancellations within 48 hours will be charged one night's stay.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Booking Card -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6 sticky top-20">
                    <div class="text-center mb-4">
                        <p class="text-3xl font-bold text-green-600">{{ $accommodation->formatted_price }}</p>
                        <p class="text-gray-600">per night</p>
                    </div>
                    <a href="{{ route('public.booking.accommodation') }}" 
                       class="block w-full bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors text-center mb-3">
                        Book This Property
                    </a>
                    <p class="text-sm text-gray-500 text-center">You won't be charged yet</p>
                </div>

                <!-- Contact Info -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Need Help?</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-gray-900">Email</p>
                                <p class="text-gray-600">{{ $accommodation->contact_email ?? 'support@concerthub.com' }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-gray-900">Phone</p>
                                <p class="text-gray-600">{{ $accommodation->contact_phone ?? '1-800-CONCERT' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nearby Accommodations -->
        @if($nearbyAccommodations->count() > 0)
        <div class="mt-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">More Options in {{ $accommodation->city }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($nearbyAccommodations as $nearby)
                    <div class="concert-card bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="relative">
                            @if($nearby->images && count($nearby->images) > 0)
                                <img src="{{ $nearby->images[0] }}" alt="{{ $nearby->name }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-r from-green-500 to-blue-500 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                            @endif
                            @if($nearby->rating)
                                <div class="absolute top-3 right-3 bg-white bg-opacity-90 px-2 py-1 rounded">
                                    <span class="text-sm font-semibold">⭐ {{ $nearby->formatted_rating }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $nearby->name }}</h3>
                            <p class="text-gray-600 mb-2 text-sm">{{ ucfirst($nearby->type) }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-xl font-bold text-green-600">{{ $nearby->formatted_price }}</span>
                                <a href="{{ route('public.accommodations.show', $nearby) }}" 
                                   class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition-colors">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

