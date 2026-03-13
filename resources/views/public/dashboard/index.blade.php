@extends('layouts.dashboard')

@section('title', 'Dashboard - TwendeeTickets')

@section('content')
<!-- Include Popup Banner Components -->
@include('components.popup-banner')
@include('components.scroll-popup')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl p-6 text-white" style="background-image: url('https://images.unsplash.com/photo-1551434677892-1dd2d4ef876?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=60'); background-size: cover; background-position: center;">
        <div class="bg-black bg-opacity-40 backdrop-blur-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-black text-white">Welcome back, {{ auth()->user()->name }}!</h2>
                    <p class="text-blue-100 mt-1">Here's what's happening with your bookings</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-blue-100">Last login</p>
                <p class="text-lg font-semibold">{{ auth()->user()->updated_at->format('M j, Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Bookings</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $bookingStats['total_bookings'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Confirmed</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $bookingStats['confirmed_bookings'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $bookingStats['pending_bookings'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-lg">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Cancelled</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $bookingStats['cancelled_bookings'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Bookings -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Bookings</h3>
                    <a href="{{ route('public.dashboard.bookings') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View all</a>
                </div>
            </div>
            <div class="p-6">
                @if($bookings->count() > 0)
                    <div class="space-y-4">
                        @foreach($bookings->take(5) as $booking)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $booking->concert->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $booking->concert->date ? $booking->concert->date->format('M j, Y') : 'Date TBD' }} • {{ $booking->concert->venue }}</p>
                                    <p class="text-sm text-gray-500">{{ $booking->ticket_quantity }} ticket(s) • {{ $booking->formatted_total_amount }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full 
                                        @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                        @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $booking->status_text }}
                                    </span>
                                    <a href="{{ route('public.dashboard.booking-details', $booking) }}" class="text-blue-600 hover:text-blue-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                        <p class="text-gray-500">No bookings yet</p>
                        <a href="{{ route('public.events.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Browse events</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Upcoming Concerts -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Upcoming Events</h3>
                    <a href="{{ route('public.events.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View all</a>
                </div>
            </div>
            <div class="p-6">
                @if($upcomingEvents->count() > 0)
                    <div class="space-y-4">
                        @foreach($upcomingEvents as $event)
                            <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-.895 2-2 2s-2-.895-2-2 .895-2 2-2 2 .895 2 2zm12-3c0 1.105-.895 2-2 2s-2-.895-2-2 .895-2 2-2 2 .895 2 2zM9 10l12-3"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $event->title }}</h4>
                                    <p class="text-sm text-gray-600">{{ $event->event_date->format('M j, Y') }} • {{ $event->venue }}</p>
                                    <p class="text-sm text-gray-500">{{ $event->city }}, {{ $event->country }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">From ${{ number_format($event->base_price, 2) }}</p>
                                    <a href="{{ route('public.events.show', $event) }}" class="text-blue-600 hover:text-blue-700 text-sm">View details</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-.895 2-2 2s-2-.895-2-2 .895-2 2-2 2 .895 2 2zm12-3c0 1.105-.895 2-2 2s-2-.895-2-2 .895-2 2-2 2 .895 2 2zM9 10l12-3"></path>
                        </svg>
                        <p class="text-gray-500">No upcoming concerts</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <a href="{{ route('public.events.index') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <div class="p-3 bg-blue-100 rounded-lg mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Browse Events</h4>
                        <p class="text-sm text-gray-600">Discover new events</p>
                    </div>
                </a>

                <a href="{{ route('public.dashboard.payments') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <div class="p-3 bg-green-100 rounded-lg mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Payment History</h4>
                        <p class="text-sm text-gray-600">View transactions</p>
                    </div>
                </a>

                <a href="{{ route('public.dashboard.support') }}" class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                    <div class="p-3 bg-yellow-100 rounded-lg mr-4">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 11-9.75 9.75 9.75 9.75 0 019.75-9.75z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Get Support</h4>
                        <p class="text-sm text-gray-600">Need help? Contact us</p>
                    </div>
                </a>

                <a href="{{ route('public.dashboard.profile') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <div class="p-3 bg-purple-100 rounded-lg mr-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Update Profile</h4>
                        <p class="text-sm text-gray-600">Manage your account</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection


