@extends('layouts.public')

@section('title', 'Booking Confirmation - ' . $booking->booking_reference)
@section('description', 'Your booking has been confirmed! Booking reference: ' . $booking->booking_reference)

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Header -->
        <div class="text-center mb-8">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                <i class="fas fa-check text-green-600 text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Booking Confirmed!</h1>
            <p class="text-lg text-gray-600">Your booking has been successfully confirmed</p>
        </div>

        <!-- Booking Details Card -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Booking Details</h2>
                    <p class="text-gray-600">Reference: <span class="font-mono font-semibold">{{ $booking->booking_reference }}</span></p>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-green-600">${{ number_format($booking->total_amount, 2) }}</div>
                    <div class="text-sm text-gray-500">Total Paid</div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">Customer Information</h3>
                    <div class="space-y-1 text-sm text-gray-600">
                        <p><strong>Name:</strong> {{ $booking->customer_name }}</p>
                        <p><strong>Email:</strong> {{ $booking->customer_email }}</p>
                        <p><strong>Phone:</strong> {{ $booking->customer_phone }}</p>
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">Booking Information</h3>
                    <div class="space-y-1 text-sm text-gray-600">
                        <p><strong>Booking Date:</strong> {{ $booking->booking_date->format('M j, Y g:i A') }}</p>
                        <p><strong>Status:</strong> <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Confirmed</span></p>
                        <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $booking->payment_method)) }}</p>
                    </div>
                </div>
            </div>

            <!-- Items -->
            <div class="border-t pt-6">
                <h3 class="font-semibold text-gray-900 mb-4">Booking Items</h3>
                <div class="space-y-4">
                    @foreach($booking->items as $item)
                        <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">
                                    @if($item->bookable_type === 'App\Models\Concert')
                                        {{ $item->bookable->title }}
                                    @else
                                        {{ $item->bookable->name }}
                                    @endif
                                </h4>
                                <div class="text-sm text-gray-600 mt-1">
                                    @if($item->bookable_type === 'App\Models\Concert')
                                        <p><strong>Artist:</strong> {{ $item->bookable->artist }}</p>
                                        <p><strong>Venue:</strong> {{ $item->bookable->venue }}</p>
                                        <p><strong>Date:</strong> {{ $item->bookable->event_date->format('M j, Y') }} at {{ $item->bookable->event_time->format('g:i A') }}</p>
                                        <p><strong>Quantity:</strong> {{ $item->quantity }} ticket(s)</p>
                                        @if(isset($item->details['ticket_category']))
                                            <p><strong>Category:</strong> {{ ucfirst($item->details['ticket_category']) }}</p>
                                        @endif
                                    @else
                                        <p><strong>Type:</strong> {{ ucfirst($item->bookable->type) }}</p>
                                        <p><strong>Location:</strong> {{ $item->bookable->city }}, {{ $item->bookable->state }}</p>
                                        <p><strong>Nights:</strong> {{ $item->quantity }}</p>
                                        @if(isset($item->details['check_in']))
                                            <p><strong>Check-in:</strong> {{ $item->details['check_in'] }}</p>
                                            <p><strong>Check-out:</strong> {{ $item->details['check_out'] }}</p>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="text-right ml-4">
                                <div class="font-semibold text-gray-900">${{ number_format($item->total_price, 2) }}</div>
                                <div class="text-sm text-gray-500">${{ number_format($item->unit_price, 2) }} each</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Special Requests -->
            @if($booking->special_requests)
                <div class="border-t pt-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Special Requests</h3>
                    <p class="text-gray-600">{{ $booking->special_requests }}</p>
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('public.home') }}" 
               class="bg-purple-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors text-center">
                <i class="fas fa-home mr-2"></i>
                Back to Home
            </a>
            
            @if($booking->user && Auth::check() && Auth::id() === $booking->user_id)
                <a href="{{ route('public.dashboard.bookings') }}" 
                   class="bg-gray-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors text-center">
                    <i class="fas fa-ticket-alt mr-2"></i>
                    View All Bookings
                </a>
            @endif
            
            <button onclick="window.print()" 
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                <i class="fas fa-print mr-2"></i>
                Print Confirmation
            </button>
        </div>

        <!-- Important Information -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="font-semibold text-blue-900 mb-3">
                <i class="fas fa-info-circle mr-2"></i>
                Important Information
            </h3>
            <div class="text-sm text-blue-800 space-y-2">
                <p>• Please keep this confirmation email and booking reference for your records.</p>
                <p>• Arrive at the venue at least 30 minutes before the event start time.</p>
                <p>• Bring a valid ID and this confirmation to the venue.</p>
                <p>• For any questions or changes, contact us using the booking reference.</p>
                @if($booking->user && Auth::check() && Auth::id() === $booking->user_id)
                    <p>• You can view and manage your bookings in your dashboard.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        background: white !important;
    }
    
    .bg-gray-50 {
        background: white !important;
    }
    
    .shadow-md {
        box-shadow: none !important;
    }
}
</style>
@endsection