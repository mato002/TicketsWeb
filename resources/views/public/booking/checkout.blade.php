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

                    <!-- Payment Method Selection -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Payment Method</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Choose how you want to pay</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- M-Pesa (Primary) -->
                                    <div class="payment-method-option">
                                        <input type="radio" 
                                               id="payment_method_mpesa" 
                                               name="payment_method" 
                                               value="mpesa"
                                               checked
                                               class="sr-only payment-method-input">
                                        <label for="payment_method_mpesa" 
                                               class="flex items-center p-4 border-2 border-green-500 bg-green-50 rounded-lg cursor-pointer hover:border-green-600 transition-colors">
                                            <i class="fas fa-mobile-alt text-2xl mr-3 text-green-600"></i>
                                            <div>
                                                <div class="font-medium text-green-900">M-Pesa</div>
                                                <div class="text-sm text-green-700">Pay with mobile money</div>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <!-- Credit Card -->
                                    <div class="payment-method-option">
                                        <input type="radio" 
                                               id="payment_method_credit_card" 
                                               name="payment_method" 
                                               value="credit_card"
                                               class="sr-only payment-method-input">
                                        <label for="payment_method_credit_card" 
                                               class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-purple-300 transition-colors">
                                            <i class="fas fa-credit-card text-2xl mr-3 text-gray-400"></i>
                                            <div>
                                                <div class="font-medium text-gray-700">Credit/Debit Card</div>
                                                <div class="text-sm text-gray-500">Visa, Mastercard, etc.</div>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <!-- PayPal -->
                                    <div class="payment-method-option">
                                        <input type="radio" 
                                               id="payment_method_paypal" 
                                               name="payment_method" 
                                               value="paypal"
                                               class="sr-only payment-method-input">
                                        <label for="payment_method_paypal" 
                                               class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-purple-300 transition-colors">
                                            <i class="fab fa-paypal text-2xl mr-3 text-blue-400"></i>
                                            <div>
                                                <div class="font-medium text-gray-700">PayPal</div>
                                                <div class="text-sm text-gray-500">Secure online payment</div>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <!-- Bank Transfer -->
                                    <div class="payment-method-option">
                                        <input type="radio" 
                                               id="payment_method_bank_transfer" 
                                               name="payment_method" 
                                               value="bank_transfer"
                                               class="sr-only payment-method-input">
                                        <label for="payment_method_bank_transfer" 
                                               class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-purple-300 transition-colors">
                                            <i class="fas fa-university text-2xl mr-3 text-gray-400"></i>
                                            <div>
                                                <div class="font-medium text-gray-700">Bank Transfer</div>
                                                <div class="text-sm text-gray-500">Direct bank payment</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- M-Pesa Form (Shown by default) -->
                    <div id="mpesa-form" class="bg-white rounded-lg shadow-md p-6 payment-form-section">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">M-Pesa Payment Details</h2>
                        
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-mobile-alt text-green-600 text-xl mr-3"></i>
                                <div>
                                    <div class="font-semibold text-green-900">How M-Pesa works:</div>
                                    <div class="text-sm text-green-700">Fast, secure mobile money payment</div>
                                </div>
                            </div>
                            <ul class="text-sm text-green-800 space-y-1">
                                <li>• Enter your M-Pesa phone number</li>
                                <li>• Click "Complete Booking"</li>
                                <li>• You'll receive an M-Pesa prompt on your phone</li>
                                <li>• Enter your M-Pesa PIN to confirm payment</li>
                                <li>• Receive instant confirmation via SMS</li>
                            </ul>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">M-Pesa Phone Number *</label>
                                <input type="tel" 
                                       name="mpesa_phone" 
                                       required
                                       placeholder="07XXXXXXXX or 254XXXXXXXXX"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <p class="text-xs text-gray-500 mt-1">Format: 07XXXXXXXX or 254XXXXXXXXX</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Phone Number *</label>
                                <input type="tel" 
                                       name="mpesa_phone_confirm" 
                                       required
                                       placeholder="Confirm phone number"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Credit Card Form (Hidden by default) -->
                    <div id="credit-card-form" class="bg-white rounded-lg shadow-md p-6 payment-form-section hidden">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Credit Card Information</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Card Number *</label>
                                <input type="text" name="card_number" placeholder="1234 5678 9012 3456"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Expiry Date *</label>
                                    <input type="text" name="expiry_date" placeholder="MM/YY"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">CVV *</label>
                                    <input type="text" name="cvv" placeholder="123"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cardholder Name *</label>
                                <input type="text" name="cardholder_name" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- PayPal Form (Hidden by default) -->
                    <div id="paypal-form" class="bg-white rounded-lg shadow-md p-6 payment-form-section hidden">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">PayPal Payment</h2>
                        
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-center mb-3">
                                <i class="fab fa-paypal text-blue-600 text-xl mr-3"></i>
                                <div>
                                    <div class="font-semibold text-blue-900">Secure PayPal Payment</div>
                                    <div class="text-sm text-blue-700">You'll be redirected to PayPal's secure site</div>
                                </div>
                            </div>
                            <p class="text-sm text-blue-800">Click "Complete Booking" to continue with PayPal payment.</p>
                        </div>
                    </div>

                    <!-- Bank Transfer Form (Hidden by default) -->
                    <div id="bank-transfer-form" class="bg-white rounded-lg shadow-md p-6 payment-form-section hidden">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Bank Transfer Instructions</h2>
                        
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="font-medium">Amount to pay:</span>
                                    <span class="font-semibold">KSH {{ number_format($total + 2.50, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Bank:</span>
                                    <span>ConcertHub Bank</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Account Number:</span>
                                    <span class="font-mono">1234567890</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Reference:</span>
                                    <span class="font-mono text-xs">BOOKING_[Your Name]</span>
                                </div>
                            </div>
                            <div class="mt-3 p-2 bg-yellow-50 border border-yellow-200 rounded text-xs text-yellow-800">
                                <strong>Important:</strong> Include your name as reference. Payment takes 1-3 business days to process.
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
    // Handle payment method switching
    document.addEventListener('DOMContentLoaded', function() {
        const paymentMethodInputs = document.querySelectorAll('.payment-method-input');
        const mpesaForm = document.getElementById('mpesa-form');
        const creditCardForm = document.getElementById('credit-card-form');
        const paypalForm = document.getElementById('paypal-form');
        const bankTransferForm = document.getElementById('bank-transfer-form');
        
        paymentMethodInputs.forEach(input => {
            input.addEventListener('change', function() {
                const method = this.value;
                
                // Hide all forms first
                mpesaForm.classList.add('hidden');
                creditCardForm.classList.add('hidden');
                paypalForm.classList.add('hidden');
                bankTransferForm.classList.add('hidden');
                
                // Update border colors for all payment method options
                document.querySelectorAll('.payment-method-option label').forEach(label => {
                    label.classList.remove('border-green-500', 'bg-green-50', 'border-purple-500', 'bg-purple-50', 'border-blue-500', 'bg-blue-50');
                    label.classList.add('border-gray-200');
                    label.querySelectorAll('i, div > div:first-child, div > div:last-child').forEach(el => {
                        el.classList.remove('text-green-600', 'text-green-900', 'text-green-700', 'text-purple-600', 'text-purple-900', 'text-purple-700', 'text-blue-600', 'text-blue-900', 'text-blue-700');
                        el.classList.add('text-gray-400', 'text-gray-700', 'text-gray-500');
                    });
                });
                
                // Show selected form and update styling
                const selectedLabel = document.querySelector(`label[for="${this.id}"]`);
                if (method === 'mpesa') {
                    mpesaForm.classList.remove('hidden');
                    selectedLabel.classList.remove('border-gray-200');
                    selectedLabel.classList.add('border-green-500', 'bg-green-50');
                    selectedLabel.querySelectorAll('i, div > div:first-child, div > div:last-child').forEach(el => {
                        el.classList.remove('text-gray-400', 'text-gray-700', 'text-gray-500');
                        if (el.tagName === 'I') {
                            el.classList.add('text-green-600');
                        } else if (el.parentElement.tagName === 'DIV' && el.parentElement.children[0] === el) {
                            el.classList.add('text-green-900');
                        } else {
                            el.classList.add('text-green-700');
                        }
                    });
                } else if (method === 'credit_card') {
                    creditCardForm.classList.remove('hidden');
                    selectedLabel.classList.remove('border-gray-200');
                    selectedLabel.classList.add('border-purple-500', 'bg-purple-50');
                    selectedLabel.querySelectorAll('i, div > div:first-child, div > div:last-child').forEach(el => {
                        el.classList.remove('text-gray-400', 'text-gray-700', 'text-gray-500');
                        if (el.tagName === 'I') {
                            el.classList.add('text-purple-600');
                        } else if (el.parentElement.tagName === 'DIV' && el.parentElement.children[0] === el) {
                            el.classList.add('text-purple-900');
                        } else {
                            el.classList.add('text-purple-700');
                        }
                    });
                } else if (method === 'paypal') {
                    paypalForm.classList.remove('hidden');
                    selectedLabel.classList.remove('border-gray-200');
                    selectedLabel.classList.add('border-blue-500', 'bg-blue-50');
                    selectedLabel.querySelectorAll('i, div > div:first-child, div > div:last-child').forEach(el => {
                        el.classList.remove('text-gray-400', 'text-gray-700', 'text-gray-500');
                        if (el.tagName === 'I') {
                            el.classList.add('text-blue-600');
                        } else if (el.parentElement.tagName === 'DIV' && el.parentElement.children[0] === el) {
                            el.classList.add('text-blue-900');
                        } else {
                            el.classList.add('text-blue-700');
                        }
                    });
                } else if (method === 'bank_transfer') {
                    bankTransferForm.classList.remove('hidden');
                    selectedLabel.classList.remove('border-gray-200');
                    selectedLabel.classList.add('border-green-500', 'bg-green-50');
                    selectedLabel.querySelectorAll('i, div > div:first-child, div > div:last-child').forEach(el => {
                        el.classList.remove('text-gray-400', 'text-gray-700', 'text-gray-500');
                        if (el.tagName === 'I') {
                            el.classList.add('text-green-600');
                        } else if (el.parentElement.tagName === 'DIV' && el.parentElement.children[0] === el) {
                            el.classList.add('text-green-900');
                        } else {
                            el.classList.add('text-green-700');
                        }
                    });
                }
            });
        });
    });

    function completeBooking() {
        const form = document.getElementById('checkoutForm');
        const formData = new FormData(form);
        const selectedPaymentMethod = formData.get('payment_method');
        
        // Basic validation
        let requiredFields = ['customer_phone'];
        let isValid = true;
        
        // Add guest checkout fields if user is not authenticated
        @if(!Auth::check())
            requiredFields.push('customer_name', 'customer_email');
        @endif
        
        // Add payment method specific fields
        if (selectedPaymentMethod === 'mpesa') {
            requiredFields.push('mpesa_phone', 'mpesa_phone_confirm');
            
            // Validate phone numbers match
            const mpesaPhone = form.querySelector('[name="mpesa_phone"]').value;
            const mpesaPhoneConfirm = form.querySelector('[name="mpesa_phone_confirm"]').value;
            
            if (mpesaPhone !== mpesaPhoneConfirm) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'M-Pesa phone numbers do not match.',
                    confirmButtonColor: '#7c3aed'
                });
                form.querySelector('[name="mpesa_phone_confirm"]').classList.add('border-red-500');
                isValid = false;
            }
            
            // Validate phone format
            const phoneRegex = /^(07[0-9]{8}|254[0-9]{9})$/;
            if (!phoneRegex.test(mpesaPhone.replace(/\s+/g, ''))) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Phone Number',
                    text: 'Please enter a valid M-Pesa phone number (07XXXXXXXX or 254XXXXXXXXX).',
                    confirmButtonColor: '#7c3aed'
                });
                form.querySelector('[name="mpesa_phone"]').classList.add('border-red-500');
                isValid = false;
            }
        } else if (selectedPaymentMethod === 'credit_card') {
            requiredFields.push('card_number', 'expiry_date', 'cvv', 'cardholder_name');
        }
        
        // Validate all required fields
        requiredFields.forEach(field => {
            const input = form.querySelector(`[name="${field}"]`);
            if (input && !input.value.trim()) {
                input.classList.add('border-red-500');
                isValid = false;
            } else if (input) {
                input.classList.remove('border-red-500');
            }
        });
        
        const termsCheckbox = form.querySelector('[name="terms_accepted"]');
        if (!termsCheckbox.checked) {
            Swal.fire({
                icon: 'warning',
                title: 'Terms Required',
                text: 'Please accept Terms of Service to continue.',
                confirmButtonColor: '#7c3aed'
            });
            isValid = false;
        }
        
        if (!isValid) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please fill in all required fields correctly.',
                confirmButtonColor: '#7c3aed'
            });
            return;
        }
        
        // Show loading state
        const button = document.querySelector('button[onclick="completeBooking()"]');
        const originalText = button.textContent;
        button.disabled = true;
        
        if (selectedPaymentMethod === 'mpesa') {
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Initiating M-Pesa...';
        } else if (selectedPaymentMethod === 'credit_card') {
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing Card Payment...';
        } else if (selectedPaymentMethod === 'paypal') {
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Redirecting to PayPal...';
        } else {
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
        }
        
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
                if (selectedPaymentMethod === 'mpesa') {
                    Swal.fire({
                        icon: 'success',
                        title: 'M-Pesa Initiated!',
                        text: 'M-Pesa prompt sent! Please check your phone and enter your PIN to complete payment.',
                        confirmButtonColor: '#10b981',
                        timer: 3000,
                        timerProgressBar: true
                    }).then(() => {
                        window.location.href = data.redirect_url;
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Booking Completed!',
                        text: 'Booking completed successfully! You will receive a confirmation email shortly.',
                        confirmButtonColor: '#10b981',
                        timer: 3000,
                        timerProgressBar: true
                    }).then(() => {
                        window.location.href = data.redirect_url;
                    });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Booking Failed',
                    text: data.message,
                    confirmButtonColor: '#7c3aed'
                });
                button.disabled = false;
                button.textContent = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Network Error',
                text: 'An error occurred. Please try again.',
                confirmButtonColor: '#7c3aed'
            });
            button.disabled = false;
            button.textContent = originalText;
        });
    }
    
    // Format card number input
    const cardNumberInput = document.querySelector('[name="card_number"]');
    if (cardNumberInput) {
        cardNumberInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            if (formattedValue.length > 19) formattedValue = formattedValue.substr(0, 19);
            e.target.value = formattedValue;
        });
    }
    
    // Format expiry date input
    const expiryDateInput = document.querySelector('[name="expiry_date"]');
    if (expiryDateInput) {
        expiryDateInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value;
        });
    }
</script>
@endpush
@endsection
