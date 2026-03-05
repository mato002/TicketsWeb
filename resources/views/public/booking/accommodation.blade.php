@extends('layouts.public')

@section('title', 'Add Accommodation - ConcertHub')
@section('description', 'Find and book accommodation near your concert venues.')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-center space-x-8">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-semibold">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <span class="ml-2 text-green-500 font-medium">Select Tickets</span>
                </div>
                <div class="w-16 h-0.5 bg-green-500"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center text-sm font-semibold">2</div>
                    <span class="ml-2 text-purple-600 font-medium">Add Accommodation</span>
                </div>
                <div class="w-16 h-0.5 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-semibold">3</div>
                    <span class="ml-2 text-gray-500">Checkout</span>
                </div>
            </div>
        </div>

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Find Your Perfect Stay</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Book accommodation near your concert venues for a complete experience
            </p>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">All Cities</option>
                        @foreach($accommodations->pluck('city')->unique() as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">All Types</option>
                        <option value="hotel">Hotel</option>
                        <option value="hostel">Hostel</option>
                        <option value="apartment">Apartment</option>
                        <option value="bnb">Bed & Breakfast</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">Any Price</option>
                        <option value="0-100">$0 - $100</option>
                        <option value="100-200">$100 - $200</option>
                        <option value="200-300">$200 - $300</option>
                        <option value="300+">$300+</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">Any Rating</option>
                        <option value="4.5">4.5+ Stars</option>
                        <option value="4.0">4.0+ Stars</option>
                        <option value="3.5">3.5+ Stars</option>
                        <option value="3.0">3.0+ Stars</option>
                    </select>
                </div>
            </div>
        </div>

        @if($accommodations->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($accommodations as $accommodation)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
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
                            @if($accommodation->featured)
                                <div class="absolute top-4 left-4">
                                    <span class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                        Featured
                                    </span>
                                </div>
                            @endif
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
                                <span class="text-sm">{{ $accommodation->city }}, {{ $accommodation->state }}</span>
                            </div>

                            @if($accommodation->amenities && count($accommodation->amenities) > 0)
                                <div class="mb-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach(array_slice($accommodation->amenities, 0, 3) as $amenity)
                                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">{{ $amenity }}</span>
                                        @endforeach
                                        @if(count($accommodation->amenities) > 3)
                                            <span class="text-gray-500 text-xs">+{{ count($accommodation->amenities) - 3 }} more</span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-2xl font-bold text-green-600">{{ $accommodation->formatted_price }}</span>
                                    <span class="text-gray-600 text-sm">/ night</span>
                                </div>
                                <button onclick="openBookingModal({{ $accommodation->id }})" 
                                        class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                                    Book Now
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $accommodations->links() }}
            </div>

            <!-- Skip Accommodation -->
            <div class="text-center mt-8">
                <p class="text-gray-600 mb-4">Don't need accommodation? You can skip this step.</p>
                <a href="{{ route('public.booking.checkout') }}" 
                   class="bg-gray-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-700 transition-colors">
                    Skip & Continue to Checkout
                </a>
            </div>
        @else
            <!-- No Accommodations -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Accommodations Found</h3>
                <p class="text-gray-600 mb-8">We couldn't find accommodations in the cities for your concerts.</p>
                <a href="{{ route('public.booking.checkout') }}" 
                   class="bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                    Continue to Checkout
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Booking Modal -->
<div id="bookingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Book Accommodation</h3>
            
            <form id="accommodationForm" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Check-in Date</label>
                        <input type="date" name="check_in" required 
                               min="{{ date('Y-m-d') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Check-out Date</label>
                        <input type="date" name="check_out" required 
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Number of Guests</label>
                        <select name="guests" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'Guest' : 'Guests' }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeBookingModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                        Add to Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openBookingModal(accommodationId) {
        document.getElementById('accommodationForm').action = `/booking/accommodation/${accommodationId}`;
        document.getElementById('bookingModal').classList.remove('hidden');
    }
    
    function closeBookingModal() {
        document.getElementById('bookingModal').classList.add('hidden');
    }
    
    // Close modal when clicking outside
    document.getElementById('bookingModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeBookingModal();
        }
    });
</script>
@endpush
@endsection
