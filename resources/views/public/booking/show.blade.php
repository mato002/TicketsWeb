@extends('layouts.public')

@section('title', 'Book Tickets - TwendeeTickets')
@section('description', 'Book your tickets for ' . $event->title . ' by ' . $event->artist . ' on ' . $event->event_date->format('M j, Y') . '.')

@section('content')
<!-- Include Popup Banner Components -->
@include('components.popup-banner')
@include('components.scroll-popup')
<div class="bg-gray-50 min-h-screen py-8" style="background-image: url('https://images.unsplash.com/photo-1470225620780-dba8ba36b745?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=60'); background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="bg-white bg-opacity-95 backdrop-blur-sm">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex items-center justify-center space-x-8">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center text-sm font-semibold">
                            <i class="fas fa-ticket-alt text-white"></i>
                        </div>
                        <span class="ml-2 text-purple-600 font-medium">Select Tickets</span>
                    </div>
                <div class="w-16 h-0.5 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-semibold">2</div>
                    <span class="ml-2 text-gray-500">Add Accommodation</span>
                </div>
                <div class="w-16 h-0.5 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-semibold">3</div>
                    <span class="ml-2 text-gray-500">Checkout</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Booking Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <!-- Concert Info Header -->
                    <div class="flex items-center space-x-4 mb-6 pb-6 border-b border-gray-200">
                        @if($event->image_url)
                            <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-16 h-16 object-cover rounded-lg">
                        @else
                            <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.369 4.369 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                                </svg>
                            </div>
                        @endif
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">{{ $event->title }}</h1>
                            <p class="text-purple-600 font-semibold">{{ $event->artist }}</p>
                            <p class="text-gray-600 text-sm">{{ $event->event_date->format('M j, Y') }} at {{ $event->event_time->format('g:i A') }}</p>
                        </div>
                    </div>

                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                Please fix the following errors:
                            </div>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Ticket Selection Form -->
                    <form action="{{ route('cart.add') }}" method="POST" id="bookingForm">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                        
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Select Your Tickets</h2>
                        
                        @if($event->ticket_categories && count($event->ticket_categories) > 0)
                            <div class="space-y-4 mb-6">
                                @foreach($event->ticket_categories as $category => $details)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-300 transition-colors">
                                        <div class="flex items-center justify-between mb-3">
                                            <div>
                                                <h3 class="font-semibold text-gray-900">{{ $details['name'] ?? ucfirst($category) }}</h3>
                                                @if(isset($details['description']))
                                                    <p class="text-gray-600 text-sm">{{ $details['description'] }}</p>
                                                @endif
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xl font-bold text-purple-600">KSH {{ number_format($details['price'] ?? $event->base_price, 2) }}</p>
                                                <p class="text-sm text-gray-600">per ticket</p>
                                            </div>
                                        </div>
                                        
                                        @if(isset($details['benefits']) && is_array($details['benefits']))
                                            <ul class="text-sm text-gray-600 mb-3">
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
                                        
                                        <div class="flex items-center justify-between">
                                            <label class="text-sm font-medium text-gray-700">Quantity:</label>
                                            <div class="flex items-center space-x-2">
                                                <button type="button" onclick="decreaseQuantity('{{ $category }}')" class="w-8 h-8 bg-gray-200 text-gray-700 rounded-full hover:bg-gray-300 transition-colors">-</button>
                                                <input type="number" name="ticket_quantity_{{ $category }}" id="quantity_{{ $category }}" 
                                                       value="0" min="0" max="10" class="w-16 text-center border border-gray-300 rounded-md" onchange="updateForm()">
                                                <button type="button" onclick="increaseQuantity('{{ $category }}')" class="w-8 h-8 bg-gray-200 text-gray-700 rounded-full hover:bg-gray-300 transition-colors">+</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="border border-gray-200 rounded-lg p-4 mb-6">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <h3 class="font-semibold text-gray-900">General Admission</h3>
                                        <p class="text-gray-600 text-sm">Standard ticket for the event</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xl font-bold text-purple-600">{{ $event->formatted_price }}</p>
                                        <p class="text-sm text-gray-600">per ticket</p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <label class="text-sm font-medium text-gray-700">Quantity:</label>
                                    <div class="flex items-center space-x-2">
                                        <button type="button" onclick="decreaseQuantity('general')" class="w-8 h-8 bg-gray-200 text-gray-700 rounded-full hover:bg-gray-300 transition-colors">-</button>
                                        <input type="number" name="ticket_quantity_general" id="quantity_general" 
                                               value="0" min="0" max="10" class="w-16 text-center border border-gray-300 rounded-md" onchange="updateForm()">
                                        <button type="button" onclick="increaseQuantity('general')" class="w-8 h-8 bg-gray-200 text-gray-700 rounded-full hover:bg-gray-300 transition-colors">+</button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Hidden fields for form submission -->
                        <input type="hidden" name="ticket_quantity" id="selected_quantity" value="0">
                        <input type="hidden" name="ticket_category" id="selected_category" value="">

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('public.events.show', $event) }}" 
                               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                                Back to Event
                            </a>
                            <button type="submit" id="addToCartBtn" 
                                    class="px-8 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed"
                                    disabled>
                                Add to Cart
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
                    
                    <div id="orderSummary" class="space-y-3 mb-4">
                        <div class="text-center text-gray-500 py-8">
                            <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <p>Select tickets to see your order summary</p>
                        </div>
                    </div>

                    <div id="totalSection" class="border-t border-gray-200 pt-4 hidden">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-semibold text-gray-900">Subtotal:</span>
                            <span class="font-semibold text-gray-900" id="subtotal">KSH 0.00</span>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-600">Processing Fee:</span>
                            <span class="text-gray-600" id="processingFee">KSH 2.50</span>
                        </div>
                        <div class="flex items-center justify-between text-lg font-bold border-t border-gray-200 pt-2">
                            <span>Total:</span>
                            <span id="total">KSH 2.50</span>
                        </div>
                    </div>

                    <div class="mt-6 text-xs text-gray-500">
                        <p>• All sales are final</p>
                        <p>• Processing fee applies to all orders</p>
                        <p>• Tickets will be sent to your email</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let ticketPrices = @json($event->ticket_categories ?? ['general' => ['price' => $event->base_price]]);
    
    function updateOrderSummary() {
        const summaryDiv = document.getElementById('orderSummary');
        const totalSection = document.getElementById('totalSection');
        const subtotalSpan = document.getElementById('subtotal');
        const totalSpan = document.getElementById('total');
        
        let hasTickets = false;
        let subtotal = 0;
        let selectedCategory = '';
        
        // Check all quantity inputs
        Object.keys(ticketPrices).forEach(category => {
            const quantity = parseInt(document.getElementById(`quantity_${category}`).value) || 0;
            if (quantity > 0) {
                hasTickets = true;
                selectedCategory = category;
                const price = ticketPrices[category].price || ticketPrices[category];
                subtotal += price * quantity;
            }
        });
        
        if (hasTickets) {
            document.getElementById('selected_category').value = selectedCategory;
            document.getElementById('addToCartBtn').disabled = false;
            
            // Update summary display
            summaryDiv.innerHTML = '';
            Object.keys(ticketPrices).forEach(category => {
                const quantity = parseInt(document.getElementById(`quantity_${category}`).value) || 0;
                if (quantity > 0) {
                    const price = ticketPrices[category].price || ticketPrices[category];
                    const categoryName = ticketPrices[category].name || category.charAt(0).toUpperCase() + category.slice(1);
                    
                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'flex justify-between items-center';
                    itemDiv.innerHTML = `
                        <div>
                            <p class="text-sm font-medium">${categoryName}</p>
                            <p class="text-xs text-gray-600">${quantity} × KSH ${price.toFixed(2)}</p>
                        </div>
                        <span class="font-semibold">KSH ${(price * quantity).toFixed(2)}</span>
                    `;
                    summaryDiv.appendChild(itemDiv);
                }
            });
            
            totalSection.classList.remove('hidden');
            subtotalSpan.textContent = `KSH ${subtotal.toFixed(2)}`;
            totalSpan.textContent = `KSH ${(subtotal + 2.50).toFixed(2)}`;
        } else {
            document.getElementById('addToCartBtn').disabled = true;
            totalSection.classList.add('hidden');
            summaryDiv.innerHTML = `
                <div class="text-center text-gray-500 py-8">
                    <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <p>Select tickets to see your order summary</p>
                </div>
            `;
        }
    }
    
    function increaseQuantity(category) {
        const input = document.getElementById(`quantity_${category}`);
        const currentValue = parseInt(input.value) || 0;
        if (currentValue < 10) {
            input.value = currentValue + 1;
            updateOrderSummary();
            updateForm();
        }
    }
    
    function decreaseQuantity(category) {
        const input = document.getElementById(`quantity_${category}`);
        const currentValue = parseInt(input.value) || 0;
        if (currentValue > 0) {
            input.value = currentValue - 1;
            updateOrderSummary();
            updateForm();
        }
    }
    
    function updateForm() {
        let selectedCategory = '';
        let selectedQuantity = 0;
        
        // Find the first category with quantity > 0
        Object.keys(ticketPrices).forEach(category => {
            const input = document.getElementById(`quantity_${category}`);
            const quantity = parseInt(input.value) || 0;
            if (quantity > 0 && selectedCategory === '') {
                selectedCategory = category;
                selectedQuantity = quantity;
            }
        });
        
        // Update hidden fields
        document.getElementById('selected_category').value = selectedCategory;
        document.getElementById('selected_quantity').value = selectedQuantity;
        
        // Enable/disable submit button
        const submitBtn = document.getElementById('addToCartBtn');
        if (selectedQuantity > 0) {
            submitBtn.disabled = false;
            submitBtn.textContent = `Add ${selectedQuantity} Ticket${selectedQuantity > 1 ? 's' : ''} to Cart`;
        } else {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Add to Cart';
        }
    }
    
    // Add event listeners to all quantity inputs
    document.addEventListener('DOMContentLoaded', function() {
        Object.keys(ticketPrices).forEach(category => {
            const input = document.getElementById(`quantity_${category}`);
            input.addEventListener('input', function() {
                updateOrderSummary();
                updateForm();
            });
            input.addEventListener('change', function() {
                updateOrderSummary();
                updateForm();
            });
        });
    });
</script>
@endpush
@endsection
