@extends('layouts.public')

@section('title', 'Checkout - ConcertHub')
@section('description', 'Complete your concert booking and accommodation reservation.')

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
                    <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-semibold">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <span class="ml-2 text-green-500 font-medium">Add Accommodation</span>
                </div>
                <div class="w-16 h-0.5 bg-green-500"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center text-sm font-semibold">3</div>
                    <span class="ml-2 text-purple-600 font-medium">Checkout</span>
                </div>
            </div>
        </div>

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Complete Your Booking</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Review your order and provide payment information to secure your tickets
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Checkout Form -->
            <div class="lg:col-span-2">
                <form id="checkoutForm" class="space-y-8">
                    @csrf
                    
                    <!-- Contact Information -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Contact Information</h2>
                        
                        @if(Auth::check())
                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium text-gray-900">{{ Auth::user()->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                                    </div>
                                    <a href="{{ route('profile.edit') }}" class="text-purple-600 hover:text-purple-700 text-sm font-medium">
                                        Edit Profile
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm text-yellow-800">You are checking out as a guest</p>
                                        <a href="{{ route('login') }}" class="text-yellow-700 hover:text-yellow-800 text-sm font-medium underline">Login to use your saved information</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if(!Auth::check())
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                    <input type="text" name="customer_name" required 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                           placeholder="Enter your full name">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                                    <input type="email" name="customer_email" required 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                           placeholder="Enter your email address">
                                </div>
                            @endif
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                                <input type="tel" name="customer_phone" required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                       placeholder="Enter your phone number">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Special Requests</label>
                                <input type="text" name="special_requests" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                       placeholder="Any special requests?">
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Payment Information</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Card Number *</label>
                                <input type="text" name="card_number" required placeholder="1234 5678 9012 3456"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Expiry Date *</label>
                                    <input type="text" name="expiry_date" required placeholder="MM/YY"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">CVV *</label>
                                    <input type="text" name="cvv" required placeholder="123"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cardholder Name *</label>
                                <input type="text" name="cardholder_name" required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Billing Address -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Billing Address</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Street Address *</label>
                                <input type="text" name="address" required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                                    <input type="text" name="city" required 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">State *</label>
                                    <input type="text" name="state" required 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">ZIP Code *</label>
                                    <input type="text" name="zip_code" required 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                                <select name="country" required 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <option value="US">United States</option>
                                    <option value="CA">Canada</option>
                                    <option value="UK">United Kingdom</option>
                                    <option value="AU">Australia</option>
                                    <option value="DE">Germany</option>
                                    <option value="FR">France</option>
                                    <option value="ES">Spain</option>
                                    <option value="IT">Italy</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-start">
                            <input type="checkbox" name="terms_accepted" required id="terms"
                                   class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                            <label for="terms" class="ml-3 text-sm text-gray-700">
                                I agree to the <a href="#" class="text-purple-600 hover:underline">Terms of Service</a> 
                                and <a href="#" class="text-purple-600 hover:underline">Privacy Policy</a>. 
                                I understand that all sales are final and tickets are non-refundable.
                            </label>
                        </div>
                        
                        <div class="flex items-start mt-4">
                            <input type="checkbox" name="marketing_accepted" id="marketing"
                                   class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                            <label for="marketing" class="ml-3 text-sm text-gray-700">
                                I would like to receive updates about upcoming concerts and special offers.
                            </label>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
                    
                    <!-- Tickets -->
                    <div class="mb-4">
                        <h4 class="font-medium text-gray-900 mb-2">Tickets</h4>
                        <div class="space-y-2">
                            @foreach($events as $item)
                                <div class="flex justify-between text-sm">
                                    <div>
                                        <p class="font-medium">{{ $item['event']->organizer }}</p>
                                        <p class="text-gray-600">{{ $item['quantity'] }}x {{ ucfirst($item['category']) }}</p>
                                    </div>
                                    <span class="font-medium">KSH {{ number_format($item['total'], 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Accommodation -->
                    @if($accommodation && $accommodationBooking)
                        <div class="mb-4">
                            <h4 class="font-medium text-gray-900 mb-2">Accommodation</h4>
                            <div class="flex justify-between text-sm">
                                <div>
                                    <p class="font-medium">{{ $accommodation->name }}</p>
                                    <p class="text-gray-600">
                                        {{ \Carbon\Carbon::parse($accommodationBooking['check_in'])->format('M j') }} - 
                                        {{ \Carbon\Carbon::parse($accommodationBooking['check_out'])->format('M j') }}
                                    </p>
                                    <p class="text-gray-600">{{ $accommodationBooking['nights'] }} night{{ $accommodationBooking['nights'] != 1 ? 's' : '' }}</p>
                                </div>
                                <span class="font-medium">KSH {{ number_format($accommodationBooking['total_price'], 2) }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Totals -->
                    <div class="border-t border-gray-200 pt-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">KSH {{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Processing Fee</span>
                            <span class="font-medium">KSH 2.50</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold border-t border-gray-200 pt-2">
                            <span>Total</span>
                            <span class="text-purple-600">KSH {{ number_format($total + 2.50, 2) }}</span>
                        </div>
                    </div>

                    <!-- Complete Booking Button -->
                    <button onclick="completeBooking()" 
                            class="w-full mt-6 bg-purple-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-purple-700 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed">
                        Complete Booking - KSH {{ number_format($total + 2.50, 2) }}
                    </button>

                    <!-- Security Notice -->
                    <div class="mt-4 text-xs text-gray-500">
                        <div class="flex items-center mb-2">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Secure SSL encrypted payment</span>
                        </div>
                        <p>Your payment information is encrypted and secure. We never store your complete card details.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function completeBooking() {
        const form = document.getElementById('checkoutForm');
        const formData = new FormData(form);
        
        // Basic validation
        const requiredFields = ['customer_phone', 'card_number', 'expiry_date', 'cvv', 'cardholder_name', 'address', 'city', 'state', 'zip_code', 'country'];
        
        // Add guest checkout fields if user is not authenticated
        @if(!Auth::check())
            requiredFields.push('customer_name', 'customer_email');
        @endif
        
        let isValid = true;
        
        requiredFields.forEach(field => {
            const input = form.querySelector(`[name="${field}"]`);
            if (!input.value.trim()) {
                input.classList.add('border-red-500');
                isValid = false;
            } else {
                input.classList.remove('border-red-500');
            }
        });
        
        const termsCheckbox = form.querySelector('[name="terms_accepted"]');
        if (!termsCheckbox.checked) {
            alert('Please accept the Terms of Service to continue.');
            isValid = false;
        }
        
        if (!isValid) {
            alert('Please fill in all required fields.');
            return;
        }
        
        // Show loading state
        const button = document.querySelector('button[onclick="completeBooking()"]');
        const originalText = button.textContent;
        button.disabled = true;
        button.textContent = 'Processing...';
        
        // Submit form data to server
        fetch('{{ route("public.booking.process") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Booking completed successfully! You will receive a confirmation email shortly.');
                window.location.href = data.redirect_url;
            } else {
                alert('Booking failed: ' + data.message);
                button.disabled = false;
                button.textContent = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
            button.disabled = false;
            button.textContent = originalText;
        });
    }
    
    // Format card number input
    document.querySelector('[name="card_number"]').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
        let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
        if (formattedValue.length > 19) formattedValue = formattedValue.substr(0, 19);
        e.target.value = formattedValue;
    });
    
    // Format expiry date input
    document.querySelector('[name="expiry_date"]').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
        e.target.value = value;
    });
</script>
@endpush
@endsection
