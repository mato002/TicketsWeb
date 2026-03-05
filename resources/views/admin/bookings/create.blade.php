@extends('admin.layouts.app')

@section('title', 'Create New Booking')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-plus me-2"></i>Create New Booking</h2>
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Bookings
    </a>
</div>

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
                <h5 class="card-title mb-0">Booking Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.bookings.store') }}">
                    @csrf
                    
                    <div class="row">
                        <!-- User Selection -->
                        <div class="col-md-6 mb-3">
                            <label for="user_id" class="form-label">Customer *</label>
                            <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                <option value="">Select Customer</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Concert Selection -->
                        <div class="col-md-6 mb-3">
                            <label for="concert_id" class="form-label">Concert *</label>
                            <select name="concert_id" id="concert_id" class="form-select @error('concert_id') is-invalid @enderror" required>
                                <option value="">Select Concert</option>
                                @foreach($concerts as $concert)
                                    <option value="{{ $concert->id }}" 
                                            {{ old('concert_id') == $concert->id ? 'selected' : '' }}
                                            data-price="{{ $concert->base_price }}"
                                            data-available="{{ $concert->available_tickets }}">
                                        {{ $concert->title }} - {{ $concert->artist }} 
                                        ({{ $concert->event_date->format('M d, Y') }})
                                        - ${{ number_format($concert->base_price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('concert_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Ticket Quantity -->
                        <div class="col-md-4 mb-3">
                            <label for="ticket_quantity" class="form-label">Number of Tickets *</label>
                            <input type="number" 
                                   name="ticket_quantity" 
                                   id="ticket_quantity" 
                                   min="1" 
                                   max="10" 
                                   value="{{ old('ticket_quantity', 1) }}"
                                   class="form-control @error('ticket_quantity') is-invalid @enderror" 
                                   required>
                            @error('ticket_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Maximum 10 tickets per booking</div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-4 mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Total Price Display -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Total Price</label>
                            <div id="total-price" class="form-control-plaintext bg-light p-2 rounded text-center fw-bold">
                                $0.00
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="col-md-6 mb-3">
                            <label for="customer_name" class="form-label">Customer Name *</label>
                            <input type="text" 
                                   name="customer_name" 
                                   id="customer_name" 
                                   value="{{ old('customer_name') }}"
                                   class="form-control @error('customer_name') is-invalid @enderror" 
                                   required>
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="customer_email" class="form-label">Customer Email *</label>
                            <input type="email" 
                                   name="customer_email" 
                                   id="customer_email" 
                                   value="{{ old('customer_email') }}"
                                   class="form-control @error('customer_email') is-invalid @enderror" 
                                   required>
                            @error('customer_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="customer_phone" class="form-label">Customer Phone</label>
                            <input type="tel" 
                                   name="customer_phone" 
                                   id="customer_phone" 
                                   value="{{ old('customer_phone') }}"
                                   class="form-control @error('customer_phone') is-invalid @enderror">
                            @error('customer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Special Requests -->
                        <div class="col-12 mb-3">
                            <label for="special_requests" class="form-label">Special Requests</label>
                            <textarea name="special_requests" 
                                      id="special_requests" 
                                      rows="3"
                                      class="form-control @error('special_requests') is-invalid @enderror"
                                      placeholder="Any special requirements or requests...">{{ old('special_requests') }}</textarea>
                            @error('special_requests')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Create Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Concert Details Sidebar -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Concert Details</h5>
            </div>
            <div class="card-body">
                <div id="concert-details" class="text-muted">
                    <p class="mb-0">Select a concert to view details</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const concertSelect = document.getElementById('concert_id');
    const ticketQuantity = document.getElementById('ticket_quantity');
    const totalPrice = document.getElementById('total-price');
    const concertDetails = document.getElementById('concert-details');

    function updateTotalPrice() {
        const selectedOption = concertSelect.options[concertSelect.selectedIndex];
        if (selectedOption.value && selectedOption.dataset.price) {
            const price = parseFloat(selectedOption.dataset.price);
            const quantity = parseInt(ticketQuantity.value) || 1;
            const total = price * quantity;
            totalPrice.textContent = '$' + total.toFixed(2);
        } else {
            totalPrice.textContent = '$0.00';
        }
    }

    function showConcertDetails() {
        const selectedOption = concertSelect.options[concertSelect.selectedIndex];
        if (selectedOption.value) {
            const available = selectedOption.dataset.available;
            const price = parseFloat(selectedOption.dataset.price);
            concertDetails.innerHTML = `
                <div class="mb-2">
                    <strong>Available Tickets:</strong> ${available}
                </div>
                <div class="mb-2">
                    <strong>Price per Ticket:</strong> $${price.toFixed(2)}
                </div>
                <div class="mb-2">
                    <strong>Event Date:</strong> ${selectedOption.textContent.match(/\\([^)]+\\)/)?.[0] || 'N/A'}
                </div>
            `;
        } else {
            concertDetails.innerHTML = '<p class="mb-0 text-muted">Select a concert to view details</p>';
        }
    }

    concertSelect.addEventListener('change', function() {
        showConcertDetails();
        updateTotalPrice();
    });

    ticketQuantity.addEventListener('input', updateTotalPrice);

    // Initialize on page load
    showConcertDetails();
    updateTotalPrice();
});
</script>
@endpush
