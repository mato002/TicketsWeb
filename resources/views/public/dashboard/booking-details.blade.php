@extends('layouts.dashboard')

@section('title', 'Booking Details')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Booking Details</h1>
            <p class="text-gray-600 mt-1">Booking #{{ $booking->booking_reference }}</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('public.dashboard.bookings') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            @if($booking->status === 'confirmed')
                <a href="{{ route('public.dashboard.download-ticket', $booking) }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Download Ticket
                </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Concert Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Concert Information</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-.895 2-2 2s-2-.895-2-2 .895-2 2-2 2 .895 2 2zm12-3c0 1.105-.895 2-2 2s-2-.895-2-2 .895-2 2-2 2 .895 2 2zM9 10l12-3"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $booking->concert->name }}</h3>
                            <p class="text-gray-600 mt-1">{{ $booking->concert->description }}</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="font-medium">Date:</span>
                                    <span class="ml-1">{{ $booking->concert->date ? $booking->concert->date->format('l, F j, Y') : 'Date TBD' }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="font-medium">Time:</span>
                                    <span class="ml-1">{{ $booking->concert->date ? $booking->concert->date->format('g:i A') : 'Time TBD' }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="font-medium">Venue:</span>
                                    <span class="ml-1">{{ $booking->concert->venue }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="font-medium">Location:</span>
                                    <span class="ml-1">{{ $booking->concert->city }}, {{ $booking->concert->country }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ticket Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Ticket Information</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <div>
                                <p class="font-medium text-gray-900">Ticket Quantity</p>
                                <p class="text-sm text-gray-600">{{ $booking->ticket_quantity }} ticket(s)</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium text-gray-900">${{ number_format($booking->ticket_price, 2) }} each</p>
                            </div>
                        </div>
                        
                        @if($booking->ticket_categories)
                            <div class="py-3 border-b border-gray-100">
                                <p class="font-medium text-gray-900 mb-2">Ticket Categories</p>
                                <div class="space-y-2">
                                    @foreach($booking->ticket_categories as $category => $details)
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-gray-600">{{ ucfirst($category) }}</span>
                                            <span class="font-medium">{{ $details['quantity'] ?? 0 }} × ${{ number_format($details['price'] ?? 0, 2) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        <div class="flex justify-between items-center py-3">
                            <p class="text-lg font-semibold text-gray-900">Total Amount</p>
                            <p class="text-lg font-semibold text-gray-900">${{ number_format($booking->total_amount, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Special Requests -->
            @if($booking->special_requests)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Special Requests</h2>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700">{{ $booking->special_requests }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Booking Status -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Booking Status</h2>
                </div>
                <div class="p-6">
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center
                            @if($booking->status === 'confirmed') bg-green-100
                            @elseif($booking->status === 'pending') bg-yellow-100
                            @elseif($booking->status === 'cancelled') bg-red-100
                            @else bg-gray-100 @endif">
                            @if($booking->status === 'confirmed')
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @elseif($booking->status === 'pending')
                                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @elseif($booking->status === 'cancelled')
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            @endif
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $booking->status_text }}</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            @if($booking->status === 'confirmed')
                                Your booking has been confirmed and tickets are ready for download.
                            @elseif($booking->status === 'pending')
                                Your booking is being processed. You will receive a confirmation email shortly.
                            @elseif($booking->status === 'cancelled')
                                This booking has been cancelled.
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Booking Timeline -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Booking Timeline</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Booking Created</p>
                                <p class="text-xs text-gray-600">{{ $booking->created_at->format('M j, Y g:i A') }}</p>
                            </div>
                        </div>
                        
                        @if($booking->confirmed_at)
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Booking Confirmed</p>
                                    <p class="text-xs text-gray-600">{{ $booking->confirmed_at->format('M j, Y g:i A') }}</p>
                                </div>
                            </div>
                        @endif
                        
                        @if($booking->cancelled_at)
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Booking Cancelled</p>
                                    <p class="text-xs text-gray-600">{{ $booking->cancelled_at->format('M j, Y g:i A') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Customer Information</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Name</p>
                            <p class="text-sm text-gray-900">{{ $booking->customer_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Email</p>
                            <p class="text-sm text-gray-900">{{ $booking->customer_email }}</p>
                        </div>
                        @if($booking->customer_phone)
                            <div>
                                <p class="text-sm font-medium text-gray-600">Phone</p>
                                <p class="text-sm text-gray-900">{{ $booking->customer_phone }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6">
                    <div class="space-y-3">
                        @if($booking->status === 'confirmed')
                            <a href="{{ route('public.dashboard.download-ticket', $booking) }}" 
                               class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-center block">
                                Download Ticket
                            </a>
                        @endif
                        
                        @if(in_array($booking->status, ['pending', 'confirmed']))
                            <button onclick="openCancelModal()" 
                                    class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                                Cancel Booking
                            </button>
                        @endif
                        
                        <a href="{{ route('public.dashboard.support') }}" 
                           class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors text-center block">
                            Get Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Booking Modal -->
<div id="cancelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <div class="mt-2 px-7 py-3">
                <h3 class="text-lg font-medium text-gray-900">Cancel Booking</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Are you sure you want to cancel this booking? This action cannot be undone.
                    </p>
                </div>
                <form method="POST" action="{{ route('public.dashboard.cancel-booking', $booking) }}" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label for="cancellation_reason" class="block text-sm font-medium text-gray-700 mb-2">
                            Reason for cancellation
                        </label>
                        <textarea id="cancellation_reason" name="cancellation_reason" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Please tell us why you're cancelling..." required></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeCancelModal()" 
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Keep Booking
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            Cancel Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openCancelModal() {
    document.getElementById('cancelModal').classList.remove('hidden');
}

function closeCancelModal() {
    document.getElementById('cancelModal').classList.add('hidden');
    document.getElementById('cancellation_reason').value = '';
}

// Close modal when clicking outside
document.getElementById('cancelModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCancelModal();
    }
});
</script>
@endsection


