@extends('admin.layouts.app')

@section('title', 'Booking Settings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-ticket-alt me-2"></i>Booking Settings</h2>
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
                <h5 class="card-title mb-0">Booking Configuration</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings.booking.update') }}">
                    @csrf
                    
                    <div class="row">
                        <!-- Max Tickets Per Booking -->
                        <div class="col-md-6 mb-3">
                            <label for="max_tickets_per_booking" class="form-label">Maximum Tickets Per Booking *</label>
                            <input type="number" 
                                   name="max_tickets_per_booking" 
                                   id="max_tickets_per_booking" 
                                   value="{{ old('max_tickets_per_booking', $settings['max_tickets_per_booking']) }}"
                                   class="form-control @error('max_tickets_per_booking') is-invalid @enderror" 
                                   min="1" 
                                   max="20"
                                   required>
                            @error('max_tickets_per_booking')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Maximum number of tickets a customer can book in one transaction</div>
                        </div>

                        <!-- Booking Cancellation Hours -->
                        <div class="col-md-6 mb-3">
                            <label for="booking_cancellation_hours" class="form-label">Cancellation Deadline (Hours) *</label>
                            <input type="number" 
                                   name="booking_cancellation_hours" 
                                   id="booking_cancellation_hours" 
                                   value="{{ old('booking_cancellation_hours', $settings['booking_cancellation_hours']) }}"
                                   class="form-control @error('booking_cancellation_hours') is-invalid @enderror" 
                                   min="0" 
                                   max="168"
                                   required>
                            @error('booking_cancellation_hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Hours before event when cancellation is no longer allowed (0 = no cancellation)</div>
                        </div>

                        <!-- Booking Reminder Hours -->
                        <div class="col-md-6 mb-3">
                            <label for="booking_reminder_hours" class="form-label">Reminder Hours *</label>
                            <input type="number" 
                                   name="booking_reminder_hours" 
                                   id="booking_reminder_hours" 
                                   value="{{ old('booking_reminder_hours', $settings['booking_reminder_hours']) }}"
                                   class="form-control @error('booking_reminder_hours') is-invalid @enderror" 
                                   min="1" 
                                   max="168"
                                   required>
                            @error('booking_reminder_hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Hours before event to send reminder emails</div>
                        </div>
                    </div>

                    <hr>

                    <h6 class="mb-3">Booking Process Settings</h6>
                    
                    <div class="row">
                        <!-- Booking Confirmation Required -->
                        <div class="col-12 mb-3">
                            <div class="form-check">
                                <input type="checkbox" 
                                       name="booking_confirmation_required" 
                                       id="booking_confirmation_required" 
                                       class="form-check-input"
                                       {{ old('booking_confirmation_required', $settings['booking_confirmation_required']) ? 'checked' : '' }}>
                                <label for="booking_confirmation_required" class="form-check-label">
                                    <strong>Require Manual Confirmation</strong>
                                    <div class="form-text">Bookings will remain pending until manually confirmed by admin</div>
                                </label>
                            </div>
                        </div>

                        <!-- Auto Confirm Bookings -->
                        <div class="col-12 mb-3">
                            <div class="form-check">
                                <input type="checkbox" 
                                       name="auto_confirm_bookings" 
                                       id="auto_confirm_bookings" 
                                       class="form-check-input"
                                       {{ old('auto_confirm_bookings', $settings['auto_confirm_bookings']) ? 'checked' : '' }}>
                                <label for="auto_confirm_bookings" class="form-check-label">
                                    <strong>Auto-Confirm Bookings</strong>
                                    <div class="form-text">Automatically confirm bookings upon creation (overrides manual confirmation)</div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h6 class="mb-3">Policies & Terms</h6>
                    
                    <div class="row">
                        <!-- Refund Policy -->
                        <div class="col-12 mb-3">
                            <label for="refund_policy" class="form-label">Refund Policy</label>
                            <textarea name="refund_policy" 
                                      id="refund_policy" 
                                      rows="4"
                                      class="form-control @error('refund_policy') is-invalid @enderror"
                                      placeholder="Describe your refund policy...">{{ old('refund_policy', $settings['refund_policy']) }}</textarea>
                            @error('refund_policy')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">This policy will be displayed to customers during booking</div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="col-12 mb-3">
                            <label for="terms_conditions" class="form-label">Terms and Conditions</label>
                            <textarea name="terms_conditions" 
                                      id="terms_conditions" 
                                      rows="6"
                                      class="form-control @error('terms_conditions') is-invalid @enderror"
                                      placeholder="Enter your terms and conditions...">{{ old('terms_conditions', $settings['terms_conditions']) }}</textarea>
                            @error('terms_conditions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">These terms will be shown to customers and must be accepted before booking</div>
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
                <h5 class="card-title mb-0">Booking Settings Help</h5>
            </div>
            <div class="card-body">
                <h6>Ticket Limits</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success me-2"></i>Set reasonable limits to prevent abuse</li>
                    <li><i class="fas fa-check text-success me-2"></i>Consider venue capacity when setting limits</li>
                    <li><i class="fas fa-check text-success me-2"></i>Higher limits may require more staff</li>
                </ul>

                <h6 class="mt-3">Cancellation Policy</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success me-2"></i>0 hours = No cancellation allowed</li>
                    <li><i class="fas fa-check text-success me-2"></i>24 hours = Cancel up to 1 day before</li>
                    <li><i class="fas fa-check text-success me-2"></i>48 hours = Cancel up to 2 days before</li>
                </ul>

                <h6 class="mt-3">Confirmation Process</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-info-circle text-info me-2"></i><strong>Manual:</strong> Admin reviews each booking</li>
                    <li><i class="fas fa-info-circle text-info me-2"></i><strong>Auto:</strong> Bookings confirmed immediately</li>
                    <li><i class="fas fa-exclamation-triangle text-warning me-2"></i>Auto-confirm overrides manual setting</li>
                </ul>

                <div class="alert alert-warning mt-3">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Legal Note:</strong> Ensure your terms and conditions comply with local laws and regulations.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
