@extends('layouts.public')

@section('title', 'Payment - TwendeeTickets')
@section('description', 'Complete your payment for booking #' . $booking->booking_reference)

@section('content')
<!-- Include Popup Banner Components -->
@include('components.popup-banner')
@include('components.scroll-popup')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-center space-x-8">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-semibold">✓</div>
                    <span class="ml-2 text-green-600 font-medium">Select Tickets</span>
                </div>
                <div class="w-16 h-0.5 bg-green-600"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-semibold">✓</div>
                    <span class="ml-2 text-green-600 font-medium">Add Accommodation</span>
                </div>
                <div class="w-16 h-0.5 bg-green-600"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center text-sm font-semibold">3</div>
                    <span class="ml-2 text-purple-600 font-medium">Payment</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Payment Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">
                        <i class="fas fa-credit-card mr-2"></i>
                        Payment Information
                    </h2>

                    <form id="payment-form" method="POST" action="{{ route('payment.process', $booking) }}">
                        @csrf
                        
                        <!-- Payment Method Selection -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Payment Method</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($paymentMethods as $method => $details)
                                    <div class="payment-method-option {{ $details['enabled'] ? '' : 'opacity-50 cursor-not-allowed' }}">
                                        <input type="radio" 
                                               id="payment_method_{{ $method }}" 
                                               name="payment_method" 
                                               value="{{ $method }}"
                                               {{ $method === 'credit_card' ? 'checked' : '' }}
                                               {{ !$details['enabled'] ? 'disabled' : '' }}
                                               class="sr-only payment-method-input">
                                        <label for="payment_method_{{ $method }}" 
                                               class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-purple-300 transition-colors {{ $method === 'credit_card' ? 'border-purple-500 bg-purple-50' : '' }}">
                                            <i class="{{ $details['icon'] }} text-2xl mr-3 {{ $method === 'credit_card' ? 'text-purple-600' : 'text-gray-400' }}"></i>
                                            <div>
                                                <div class="font-medium {{ $method === 'credit_card' ? 'text-purple-900' : 'text-gray-700' }}">{{ $details['name'] }}</div>
                                                <div class="text-sm text-gray-500">{{ $details['description'] }}</div>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Credit Card Form -->
                        <div id="credit-card-form" class="payment-form-section">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="card_number" class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
                                    <input type="text" 
                                           id="card_number" 
                                           name="card_number" 
                                           placeholder="1234 5678 9012 3456"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="cardholder_name" class="block text-sm font-medium text-gray-700 mb-1">Cardholder Name</label>
                                    <input type="text" 
                                           id="cardholder_name" 
                                           name="cardholder_name" 
                                           placeholder="John Doe"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                <div>
                                    <label for="card_expiry" class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                                    <input type="text" 
                                           id="card_expiry" 
                                           name="card_expiry" 
                                           placeholder="MM/YY"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="card_cvv" class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                                    <input type="text" 
                                           id="card_cvv" 
                                           name="card_cvv" 
                                           placeholder="123"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                            </div>
                        </div>

                        <!-- PayPal Form -->
                        <div id="paypal-form" class="payment-form-section hidden">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                                <div class="flex items-center mb-4">
                                    <i class="fab fa-paypal text-blue-600 text-3xl mr-4"></i>
                                    <div>
                                        <div class="font-semibold text-blue-900 text-lg">PayPal Payment</div>
                                        <div class="text-sm text-blue-700">Secure payment through PayPal</div>
                                    </div>
                                </div>
                                <div class="bg-white rounded-lg p-4 border border-blue-200">
                                    <div class="text-sm text-gray-600 mb-3">
                                        <strong>How it works:</strong>
                                    </div>
                                    <ul class="text-sm text-gray-600 space-y-1 mb-4">
                                        <li>• Click "Pay with PayPal" to continue</li>
                                        <li>• You'll be redirected to PayPal's secure site</li>
                                        <li>• Log in to your PayPal account</li>
                                        <li>• Complete the payment</li>
                                        <li>• Return to our site for confirmation</li>
                                    </ul>
                                    <div class="flex items-center text-xs text-gray-500">
                                        <i class="fas fa-shield-alt mr-2 text-green-500"></i>
                                        <span>PayPal provides buyer protection and secure transactions</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bank Transfer Form -->
                        <div id="bank_transfer-form" class="payment-form-section hidden">
                            <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                                <div class="flex items-center mb-4">
                                    <i class="fas fa-university text-green-600 text-3xl mr-4"></i>
                                    <div>
                                        <div class="font-semibold text-green-900 text-lg">Bank Transfer</div>
                                        <div class="text-sm text-green-700">Direct bank transfer payment</div>
                                    </div>
                                </div>
                                <div class="bg-white rounded-lg p-4 border border-green-200">
                                    <div class="text-sm text-gray-600 mb-3">
                                        <strong>Payment Instructions:</strong>
                                    </div>
                                    <div class="space-y-2 text-sm text-gray-600 mb-4">
                                        <div class="flex justify-between">
                                            <span>Amount:</span>
                                            <span class="font-semibold">KSH <span id="bank-transfer-amount">{{ number_format($booking->total_amount, 2) }}</span></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Reference:</span>
                                            <span class="font-mono font-semibold">{{ $booking->booking_reference }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Bank:</span>
                                            <span>ConcertHub Bank</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Account:</span>
                                            <span class="font-mono">1234567890</span>
                                        </div>
                                    </div>
                                    <div class="bg-yellow-50 border border-yellow-200 rounded p-3 mb-4">
                                        <div class="text-sm text-yellow-800">
                                            <strong>Important:</strong> Please include your booking reference ({{ $booking->booking_reference }}) in the transfer description. Payment may take 1-3 business days to process.
                                        </div>
                                    </div>
                                    <div class="flex items-center text-xs text-gray-500">
                                        <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                        <span>You'll receive confirmation once payment is received</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Wallet Top-up Form -->
                        <div id="wallet_topup-form" class="payment-form-section hidden">
                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-6 mb-6">
                                <div class="flex items-center mb-4">
                                    <i class="fas fa-wallet text-purple-600 text-3xl mr-4"></i>
                                    <div>
                                        <div class="font-semibold text-purple-900 text-lg">Wallet Top-up</div>
                                        <div class="text-sm text-purple-700">Add funds to your wallet for easy payments</div>
                                    </div>
                                </div>
                                <div class="bg-white rounded-lg p-4 border border-purple-200">
                                    <div class="text-sm text-gray-600 mb-3">
                                        <strong>How it works:</strong>
                                    </div>
                                    <ul class="text-sm text-gray-600 space-y-1 mb-4">
                                        <li>• Add funds to your wallet using any payment method</li>
                                        <li>• Use wallet balance for instant payments</li>
                                        <li>• No processing fees for wallet transactions</li>
                                        <li>• Secure and convenient payment option</li>
                                    </ul>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label for="topup_amount" class="block text-sm font-medium text-gray-700 mb-1">Top-up Amount</label>
                                            <select id="topup_amount" name="topup_amount" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                                <option value="50">KSH 50</option>
                                                <option value="100">KSH 100</option>
                                                <option value="200">KSH 200</option>
                                                <option value="500">KSH 500</option>
                                                <option value="custom">Custom Amount</option>
                                            </select>
                                        </div>
                                        <div id="custom_amount_field" class="hidden">
                                            <label for="custom_amount" class="block text-sm font-medium text-gray-700 mb-1">Custom Amount</label>
                                            <input type="number" id="custom_amount" name="custom_amount" min="10" max="1000" step="10" placeholder="Enter amount" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        </div>
                                    </div>
                                    
                                    <div class="bg-blue-50 border border-blue-200 rounded p-3 mb-4">
                                        <div class="text-sm text-blue-800">
                                            <strong>Current Wallet Balance:</strong> KSH <span id="wallet-balance">0.00</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center text-xs text-gray-500">
                                        <i class="fas fa-shield-alt mr-2 text-green-500"></i>
                                        <span>Wallet funds are secure and can be used for future bookings</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- M-Pesa Form -->
                        <div id="mpesa-form" class="payment-form-section hidden">
                            <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                                <div class="flex items-center mb-4">
                                    <i class="fas fa-mobile-alt text-green-600 text-3xl mr-4"></i>
                                    <div>
                                        <div class="font-semibold text-green-900 text-lg">M-Pesa Payment</div>
                                        <div class="text-sm text-green-700">Pay with your M-Pesa mobile money</div>
                                    </div>
                                </div>
                                <div class="bg-white rounded-lg p-4 border border-green-200">
                                    <div class="text-sm text-gray-600 mb-3">
                                        <strong>How to pay with M-Pesa:</strong>
                                    </div>
                                    <ul class="text-sm text-gray-600 space-y-1 mb-4">
                                        <li>• Enter your M-Pesa phone number below</li>
                                        <li>• Click "Pay with M-Pesa" to continue</li>
                                        <li>• You'll receive an M-Pesa prompt on your phone</li>
                                        <li>• Enter your M-Pesa PIN to complete payment</li>
                                        <li>• You'll receive confirmation via SMS</li>
                                    </ul>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label for="mpesa_phone" class="block text-sm font-medium text-gray-700 mb-1">M-Pesa Phone Number</label>
                                            <input type="tel" 
                                                   id="mpesa_phone" 
                                                   name="mpesa_phone" 
                                                   placeholder="07XXXXXXXX or 254XXXXXXXXX"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        </div>
                                        <div>
                                            <label for="mpesa_till" class="block text-sm font-medium text-gray-700 mb-1">Pay to Till Number (Optional)</label>
                                            <input type="text" 
                                                   id="mpesa_till" 
                                                   name="mpesa_till" 
                                                   placeholder="Enter till number if paying directly"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        </div>
                                        <div>
                                            <label for="mpesa_amount" class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                                            <input type="text" 
                                                   id="mpesa_amount" 
                                                   name="mpesa_amount" 
                                                   readonly
                                                   value="KSH {{ number_format($booking->total_amount, 2) }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-600">
                                        </div>
                                    </div>
                                    
                                    <div class="bg-yellow-50 border border-yellow-200 rounded p-3 mb-4">
                                        <div class="text-sm text-yellow-800">
                                            <strong>Important:</strong> Ensure your M-Pesa account has sufficient balance. You will receive an SMS confirmation once payment is processed.
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center text-xs text-gray-500">
                                        <i class="fas fa-shield-alt mr-2 text-green-500"></i>
                                        <span>M-Pesa payments are secure and processed by Safaricom</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Billing Address -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Billing Address</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div class="md:col-span-2">
                                    <label for="billing_address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                    <input type="text" 
                                           id="billing_address" 
                                           name="billing_address" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="billing_city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                    <input type="text" 
                                           id="billing_city" 
                                           name="billing_city" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="billing_state" class="block text-sm font-medium text-gray-700 mb-1">State</label>
                                    <input type="text" 
                                           id="billing_state" 
                                           name="billing_state" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="billing_zip" class="block text-sm font-medium text-gray-700 mb-1">ZIP Code</label>
                                    <input type="text" 
                                           id="billing_zip" 
                                           name="billing_zip" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="billing_country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                    <select id="billing_country" 
                                            name="billing_country" 
                                            required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        <option value="US">United States</option>
                                        <option value="CA">Canada</option>
                                        <option value="GB">United Kingdom</option>
                                        <option value="AU">Australia</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="border-t pt-6 mb-6">
                            <div class="flex items-start">
                                <input type="checkbox" 
                                       id="terms_accepted" 
                                       name="terms_accepted" 
                                       required
                                       class="mt-1 mr-3 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="terms_accepted" class="text-sm text-gray-600">
                                    I agree to the <a href="{{ route('public.pages.terms') }}" target="_blank" class="text-purple-600 hover:text-purple-700 underline">Terms of Service</a> 
                                    and <a href="{{ route('public.pages.privacy') }}" target="_blank" class="text-purple-600 hover:text-purple-700 underline">Privacy Policy</a>. 
                                    I understand that all sales are final and tickets are non-refundable unless the event is cancelled.
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-6">
                            <button type="submit" 
                                    id="submit-payment"
                                    class="bg-purple-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed">
                                <i class="fas fa-lock mr-2"></i>
                                <span id="submit-text">Pay KSH <span id="total-amount">{{ number_format($booking->total_amount, 2) }}</span></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Order Summary</h3>
                    
                    <div class="space-y-3 mb-4">
                        @foreach($booking->items as $item)
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="font-medium text-gray-900">
                                        @if($item->bookable_type === 'App\Models\Concert')
                                            {{ $item->bookable->title }}
                                        @else
                                            {{ $item->bookable->name }}
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500">Qty: {{ $item->quantity }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-medium text-gray-900">KSH {{ number_format($item->total_price, 2) }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-medium">KSH {{ number_format($booking->total_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Processing Fee:</span>
                            <span class="font-medium" id="processing-fee">KSH 0.00</span>
                        </div>
                        <div class="flex justify-between items-center text-lg font-bold">
                            <span>Total:</span>
                            <span id="final-total">KSH {{ number_format($booking->total_amount, 2) }}</span>
                        </div>
                    </div>

                    <div class="mt-6 text-xs text-gray-500">
                        <p class="mb-2">
                            <i class="fas fa-shield-alt mr-1"></i>
                            Your payment information is secure and encrypted.
                        </p>
                        <p>
                            By completing this payment, you agree to our terms and conditions.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="payment-loading" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 text-center">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600 mx-auto mb-4"></div>
        <div class="text-lg font-medium text-gray-900">Processing Payment...</div>
        <div class="text-sm text-gray-600">Please do not close this window</div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethodInputs = document.querySelectorAll('.payment-method-input');
    const creditCardForm = document.getElementById('credit-card-form');
    const paypalForm = document.getElementById('paypal-form');
    const bankTransferForm = document.getElementById('bank_transfer-form');
    const walletTopupForm = document.getElementById('wallet_topup-form');
    const mpesaForm = document.getElementById('mpesa-form');
    const processingFeeElement = document.getElementById('processing-fee');
    const finalTotalElement = document.getElementById('final-total');
    const totalAmountElement = document.getElementById('total-amount');
    const bankTransferAmountElement = document.getElementById('bank-transfer-amount');
    const paymentForm = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-payment');
    const submitTextElement = document.getElementById('submit-text');
    const loadingOverlay = document.getElementById('payment-loading');

    // Handle payment method selection
    paymentMethodInputs.forEach(input => {
        input.addEventListener('change', function() {
            const method = this.value;
            
            // Update form visibility
            if (method === 'credit_card') {
                creditCardForm.classList.remove('hidden');
                paypalForm.classList.add('hidden');
                bankTransferForm.classList.add('hidden');
                walletTopupForm.classList.add('hidden');
                submitTextElement.innerHTML = 'Pay KSH <span id="total-amount">' + {{ $booking->total_amount }} + '</span>';
            } else if (method === 'paypal') {
                creditCardForm.classList.add('hidden');
                paypalForm.classList.remove('hidden');
                bankTransferForm.classList.add('hidden');
                walletTopupForm.classList.add('hidden');
                submitTextElement.innerHTML = 'Pay with PayPal - KSH <span id="total-amount">' + {{ $booking->total_amount }} + '</span>';
            } else if (method === 'bank_transfer') {
                creditCardForm.classList.add('hidden');
                paypalForm.classList.add('hidden');
                bankTransferForm.classList.remove('hidden');
                walletTopupForm.classList.add('hidden');
                submitTextElement.innerHTML = 'Confirm Bank Transfer - KSH <span id="total-amount">' + {{ $booking->total_amount }} + '</span>';
            } else if (method === 'wallet_topup') {
                creditCardForm.classList.add('hidden');
                paypalForm.classList.add('hidden');
                bankTransferForm.classList.add('hidden');
                walletTopupForm.classList.remove('hidden');
                mpesaForm.classList.add('hidden');
                submitTextElement.innerHTML = 'Top-up Wallet - KSH <span id="total-amount">' + {{ $booking->total_amount }} + '</span>';
            } else if (method === 'mpesa') {
                creditCardForm.classList.add('hidden');
                paypalForm.classList.add('hidden');
                bankTransferForm.classList.add('hidden');
                walletTopupForm.classList.add('hidden');
                mpesaForm.classList.remove('hidden');
                submitTextElement.innerHTML = 'Pay with M-Pesa - KSH <span id="total-amount">' + {{ $booking->total_amount }} + '</span>';
            }
            
            // Calculate fees
            calculateFees();
        });
    });

    // Calculate processing fees
    function calculateFees() {
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
        const amount = {{ $booking->total_amount }};
        
        fetch('{{ route("payment.calculate-fees") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                amount: amount,
                payment_method: selectedMethod
            })
        })
        .then(response => response.json())
        .then(data => {
            processingFeeElement.textContent = '$' + data.processing_fee.toFixed(2);
            finalTotalElement.textContent = '$' + data.total_amount.toFixed(2);
            totalAmountElement.textContent = data.total_amount.toFixed(2);
            if (bankTransferAmountElement) {
                bankTransferAmountElement.textContent = data.total_amount.toFixed(2);
            }
        })
        .catch(error => {
            console.error('Error calculating fees:', error);
        });
    }

    // Handle form submission
    paymentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate terms checkbox
        const termsCheckbox = document.getElementById('terms_accepted');
        if (!termsCheckbox.checked) {
            alert('Please accept the Terms of Service to continue.');
            termsCheckbox.focus();
            return;
        }
        
        // Validate required fields based on payment method
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
        let isValid = true;
        let errorMessage = '';
        
        if (selectedMethod === 'credit_card') {
            const requiredFields = ['card_number', 'cardholder_name', 'card_expiry', 'card_cvv', 'billing_address', 'billing_city', 'billing_state', 'billing_zip', 'billing_country'];
            requiredFields.forEach(field => {
                const input = document.getElementById(field);
                if (!input.value.trim()) {
                    input.classList.add('border-red-500');
                    isValid = false;
                    errorMessage = 'Please fill in all required fields.';
                } else {
                    input.classList.remove('border-red-500');
                }
            });
        } else if (selectedMethod === 'paypal') {
            const requiredFields = ['billing_address', 'billing_city', 'billing_state', 'billing_zip', 'billing_country'];
            requiredFields.forEach(field => {
                const input = document.getElementById(field);
                if (!input.value.trim()) {
                    input.classList.add('border-red-500');
                    isValid = false;
                    errorMessage = 'Please fill in all required billing information.';
                } else {
                    input.classList.remove('border-red-500');
                }
            });
        } else if (selectedMethod === 'wallet_topup') {
            const topupAmount = document.getElementById('topup_amount').value;
            const customAmount = document.getElementById('custom_amount').value;
            
            if (topupAmount === 'custom' && !customAmount) {
                document.getElementById('custom_amount').classList.add('border-red-500');
                isValid = false;
                errorMessage = 'Please enter a custom amount or select a preset amount.';
            } else if (topupAmount === 'custom' && parseFloat(customAmount) < 10) {
                document.getElementById('custom_amount').classList.add('border-red-500');
                isValid = false;
                errorMessage = 'Minimum top-up amount is KSH 10.';
            } else {
                document.getElementById('custom_amount').classList.remove('border-red-500');
            }
        } else if (selectedMethod === 'mpesa') {
            const mpesaPhone = document.getElementById('mpesa_phone');
            if (!mpesaPhone.value.trim()) {
                mpesaPhone.classList.add('border-red-500');
                isValid = false;
                errorMessage = 'Please enter your M-Pesa phone number.';
            } else {
                mpesaPhone.classList.remove('border-red-500');
            }
        }
        
        if (!isValid) {
            alert(errorMessage);
            return;
        }
        
        // Show loading overlay
        loadingOverlay.classList.remove('hidden');
        submitButton.disabled = true;
        
        // Submit form via AJAX
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Redirect to confirmation page
                window.location.href = data.redirect_url;
            } else {
                // Show error message
                alert(data.message);
                loadingOverlay.classList.add('hidden');
                submitButton.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Payment processing failed. Please try again.');
            loadingOverlay.classList.add('hidden');
            submitButton.disabled = false;
        });
    });

    // Format card number input
    document.getElementById('card_number').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
        let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
        e.target.value = formattedValue;
    });

    // Format expiry date input
    document.getElementById('card_expiry').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
        e.target.value = value;
    });

    // Format CVV input
    document.getElementById('card_cvv').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/[^0-9]/g, '').substring(0, 4);
    });

    // Handle wallet top-up amount selection
    const topupAmountSelect = document.getElementById('topup_amount');
    const customAmountField = document.getElementById('custom_amount_field');
    const customAmountInput = document.getElementById('custom_amount');
    
    if (topupAmountSelect) {
        topupAmountSelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                customAmountField.classList.remove('hidden');
                customAmountInput.focus();
            } else {
                customAmountField.classList.add('hidden');
                customAmountInput.value = '';
            }
        });
    }
    
    if (customAmountInput) {
        customAmountInput.addEventListener('input', function() {
            const amount = parseFloat(this.value) || 0;
            if (amount > 0) {
                // Update the total amount for wallet top-up
                totalAmountElement.textContent = amount.toFixed(2);
                finalTotalElement.textContent = 'KSH ' + amount.toFixed(2);
                processingFeeElement.textContent = 'KSH 0.00';
            }
        });
    }

    // Initial fee calculation
    calculateFees();
});
</script>
@endpush
