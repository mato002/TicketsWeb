@extends('admin.layouts.app')

@section('title', 'Payment Settings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-credit-card me-2"></i>Payment Settings</h2>
    <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Settings
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Payment Gateway Configuration</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings.payment.update') }}">
                    @csrf
                    
                    <div class="row">
                        <!-- Payment Method -->
                        <div class="col-12 mb-4">
                            <label for="payment_method" class="form-label">Primary Payment Method *</label>
                            <select name="payment_method" id="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
                                <option value="stripe" {{ old('payment_method', $settings['payment_method']) == 'stripe' ? 'selected' : '' }}>Stripe</option>
                                <option value="paypal" {{ old('payment_method', $settings['payment_method']) == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                <option value="square" {{ old('payment_method', $settings['payment_method']) == 'square' ? 'selected' : '' }}>Square</option>
                                <option value="offline" {{ old('payment_method', $settings['payment_method']) == 'offline' ? 'selected' : '' }}>Offline Payment</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Stripe Configuration -->
                    <div id="stripe-config" class="payment-config" style="display: {{ old('payment_method', $settings['payment_method']) == 'stripe' ? 'block' : 'none' }};">
                        <h6 class="mb-3">Stripe Configuration</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="stripe_public_key" class="form-label">Stripe Public Key</label>
                                <input type="text" 
                                       name="stripe_public_key" 
                                       id="stripe_public_key" 
                                       value="{{ old('stripe_public_key', $settings['stripe_public_key']) }}"
                                       class="form-control @error('stripe_public_key') is-invalid @enderror"
                                       placeholder="pk_test_...">
                                @error('stripe_public_key')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stripe_secret_key" class="form-label">Stripe Secret Key</label>
                                <input type="password" 
                                       name="stripe_secret_key" 
                                       id="stripe_secret_key" 
                                       value="{{ old('stripe_secret_key', $settings['stripe_secret_key']) }}"
                                       class="form-control @error('stripe_secret_key') is-invalid @enderror"
                                       placeholder="sk_test_...">
                                @error('stripe_secret_key')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- PayPal Configuration -->
                    <div id="paypal-config" class="payment-config" style="display: {{ old('payment_method', $settings['payment_method']) == 'paypal' ? 'block' : 'none' }};">
                        <h6 class="mb-3">PayPal Configuration</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="paypal_client_id" class="form-label">PayPal Client ID</label>
                                <input type="text" 
                                       name="paypal_client_id" 
                                       id="paypal_client_id" 
                                       value="{{ old('paypal_client_id', $settings['paypal_client_id']) }}"
                                       class="form-control @error('paypal_client_id') is-invalid @enderror"
                                       placeholder="Your PayPal Client ID">
                                @error('paypal_client_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="paypal_client_secret" class="form-label">PayPal Client Secret</label>
                                <input type="password" 
                                       name="paypal_client_secret" 
                                       id="paypal_client_secret" 
                                       value="{{ old('paypal_client_secret', $settings['paypal_client_secret']) }}"
                                       class="form-control @error('paypal_client_secret') is-invalid @enderror"
                                       placeholder="Your PayPal Client Secret">
                                @error('paypal_client_secret')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="paypal_mode" class="form-label">PayPal Mode</label>
                                <select name="paypal_mode" id="paypal_mode" class="form-select @error('paypal_mode') is-invalid @enderror">
                                    <option value="sandbox" {{ old('paypal_mode', $settings['paypal_mode']) == 'sandbox' ? 'selected' : '' }}>Sandbox (Testing)</option>
                                    <option value="live" {{ old('paypal_mode', $settings['paypal_mode']) == 'live' ? 'selected' : '' }}>Live (Production)</option>
                                </select>
                                @error('paypal_mode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h6 class="mb-3">Pricing Configuration</h6>
                    
                    <div class="row">
                        <!-- Tax Rate -->
                        <div class="col-md-6 mb-3">
                            <label for="tax_rate" class="form-label">Tax Rate (%) *</label>
                            <input type="number" 
                                   name="tax_rate" 
                                   id="tax_rate" 
                                   value="{{ old('tax_rate', $settings['tax_rate']) }}"
                                   class="form-control @error('tax_rate') is-invalid @enderror" 
                                   min="0" 
                                   max="100" 
                                   step="0.01"
                                   required>
                            @error('tax_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Percentage tax rate applied to all bookings</div>
                        </div>

                        <!-- Processing Fee -->
                        <div class="col-md-6 mb-3">
                            <label for="processing_fee" class="form-label">Processing Fee ($) *</label>
                            <input type="number" 
                                   name="processing_fee" 
                                   id="processing_fee" 
                                   value="{{ old('processing_fee', $settings['processing_fee']) }}"
                                   class="form-control @error('processing_fee') is-invalid @enderror" 
                                   min="0" 
                                   step="0.01"
                                   required>
                            @error('processing_fee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Fixed processing fee per booking</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Help Sidebar -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Payment Setup Help</h5>
            </div>
            <div class="card-body">
                <h6>Getting API Keys</h6>
                <div class="accordion" id="paymentAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="stripeHeader">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#stripeCollapse">
                                Stripe Setup
                            </button>
                        </h2>
                        <div id="stripeCollapse" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
                            <div class="accordion-body">
                                <ol class="small">
                                    <li>Create account at <a href="https://stripe.com" target="_blank">stripe.com</a></li>
                                    <li>Go to Developers > API Keys</li>
                                    <li>Copy Publishable Key (pk_...)</li>
                                    <li>Copy Secret Key (sk_...)</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="paypalHeader">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#paypalCollapse">
                                PayPal Setup
                            </button>
                        </h2>
                        <div id="paypalCollapse" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
                            <div class="accordion-body">
                                <ol class="small">
                                    <li>Create account at <a href="https://developer.paypal.com" target="_blank">developer.paypal.com</a></li>
                                    <li>Create a new app</li>
                                    <li>Copy Client ID and Secret</li>
                                    <li>Use Sandbox for testing</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <h6 class="mt-3">Pricing Tips</h6>
                <ul class="list-unstyled small">
                    <li><i class="fas fa-check text-success me-2"></i>Research local tax rates</li>
                    <li><i class="fas fa-check text-success me-2"></i>Consider payment processor fees</li>
                    <li><i class="fas fa-check text-success me-2"></i>Set reasonable processing fees</li>
                    <li><i class="fas fa-info-circle text-info me-2"></i>Test with small amounts first</li>
                </ul>

                <div class="alert alert-warning mt-3">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Security:</strong> Never share your secret keys. Store them securely and use environment variables in production.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethod = document.getElementById('payment_method');
    const stripeConfig = document.getElementById('stripe-config');
    const paypalConfig = document.getElementById('paypal-config');

    function togglePaymentConfig() {
        const method = paymentMethod.value;
        
        // Hide all configs
        stripeConfig.style.display = 'none';
        paypalConfig.style.display = 'none';
        
        // Show selected config
        if (method === 'stripe') {
            stripeConfig.style.display = 'block';
        } else if (method === 'paypal') {
            paypalConfig.style.display = 'block';
        }
    }

    paymentMethod.addEventListener('change', togglePaymentConfig);
    
    // Initialize on page load
    togglePaymentConfig();
});
</script>
@endpush
