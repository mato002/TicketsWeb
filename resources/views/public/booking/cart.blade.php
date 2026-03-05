@extends('layouts.public')

@section('title', 'Shopping Cart - ConcertHub')
@section('description', 'Review your concert tickets and proceed to checkout.')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
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
                <div class="w-16 h-0.5 bg-gray-300"></div>
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

        @if(count($concerts) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h1 class="text-2xl font-bold text-gray-900 mb-6">Your Tickets</h1>
                        
                        <div class="space-y-6">
                            @foreach($concerts as $index => $item)
                                <div class="border border-gray-200 rounded-lg p-6">
                                    <div class="flex flex-col md:flex-row gap-4">
                                        <!-- Concert Image -->
                                        <div class="md:w-24 md:h-24 flex-shrink-0">
                                            @if($item['concert']->image_url)
                                                <img src="{{ $item['concert']->image_url }}" alt="{{ $item['concert']->title }}" class="w-full h-full object-cover rounded-lg">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.369 4.369 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Concert Details -->
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $item['concert']->title ?? 'Concert Title' }}</h3>
                                            <p class="text-purple-600 font-medium mb-2">{{ $item['concert']->artist ?? 'Artist Name' }}</p>
                                            <div class="space-y-1 text-sm text-gray-600">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    <span>{{ $item['concert']->venue ?? 'Venue' }}, {{ $item['concert']->city ?? 'City' }}</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span>{{ $item['concert']->event_date ? $item['concert']->event_date->format('M j, Y') : 'Date TBD' }} at {{ $item['concert']->event_time ? $item['concert']->event_time->format('g:i A') : 'Time TBD' }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Ticket Details -->
                                        <div class="text-right">
                                            <div class="mb-2">
                                                <p class="text-sm text-gray-600">Ticket Category</p>
                                                <p class="font-semibold text-gray-900">{{ ucfirst($item['category']) }}</p>
                                            </div>
                                            <div class="mb-2">
                                                <p class="text-sm text-gray-600">Quantity</p>
                                                <p class="font-semibold text-gray-900">{{ $item['quantity'] }}</p>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-sm text-gray-600">Price per ticket</p>
                                                <p class="font-semibold text-gray-900">${{ number_format($item['price'], 2) }}</p>
                                            </div>
                                            <div class="border-t border-gray-200 pt-2">
                                                <p class="text-lg font-bold text-purple-600">${{ number_format($item['total'], 2) }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Remove Button -->
                                    <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
                                        <a href="{{ route('public.concerts.show', $item['concert']) }}" 
                                           class="text-purple-600 hover:text-purple-700 font-medium">
                                            View Event Details
                                        </a>
                                        <form action="{{ route('cart.remove', $index) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-700 font-medium"
                                                    onclick="return confirm('Are you sure you want to remove this item from your cart?')">
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Continue Shopping -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <a href="{{ route('public.concerts.index') }}" 
                               class="inline-flex items-center text-purple-600 hover:text-purple-700 font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
                        
                        <div class="space-y-3 mb-4">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Tickets Subtotal</span>
                                <span class="font-semibold text-gray-900">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Processing Fee</span>
                                <span class="text-gray-600">$2.50</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4 mb-6">
                            <div class="flex items-center justify-between text-lg font-bold">
                                <span>Total</span>
                                <span class="text-purple-600">${{ number_format($total + 2.50, 2) }}</span>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <a href="{{ route('public.booking.accommodation') }}" 
                               class="w-full bg-purple-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-purple-700 transition-colors text-center block">
                                Add Accommodation
                            </a>
                            <a href="{{ route('public.booking.checkout') }}" 
                               class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-green-700 transition-colors text-center block">
                                Proceed to Checkout
                            </a>
                        </div>

                        <div class="mt-6 text-xs text-gray-500">
                            <p>• All sales are final</p>
                            <p>• Processing fee applies to all orders</p>
                            <p>• Tickets will be sent to your email</p>
                            <p>• You can add accommodation in the next step</p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Your cart is empty</h2>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Looks like you haven't added any concert tickets to your cart yet. 
                    Start exploring amazing concerts and add some tickets!
                </p>
                <div class="space-y-4">
                    <a href="{{ route('public.concerts.index') }}" 
                       class="inline-block bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                        Browse Concerts
                    </a>
                    <div>
                        <a href="{{ route('public.home') }}" class="text-purple-600 hover:text-purple-700 font-medium">
                            Back to Home
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
