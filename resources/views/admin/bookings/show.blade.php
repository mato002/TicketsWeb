@extends('admin.layouts.app')

@section('title', 'Booking Details - ' . $booking->booking_reference)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-ticket-alt me-2"></i>Booking Details</h2>
    <div class="btn-group">
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Bookings
        </a>
        <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Edit
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <!-- Booking Information -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Booking Information</h5>
                <span class="badge bg-{{ $booking->status_badge }} fs-6">
                    {{ $booking->status_text }}
                </span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Booking Reference:</strong></td>
                                <td><code>{{ $booking->booking_reference }}</code></td>
                            </tr>
                            <tr>
                                <td><strong>Customer Name:</strong></td>
                                <td>{{ $booking->customer_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Customer Email:</strong></td>
                                <td>{{ $booking->customer_email }}</td>
                            </tr>
                            <tr>
                                <td><strong>Customer Phone:</strong></td>
                                <td>{{ $booking->customer_phone ?: 'Not provided' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Booking Date:</strong></td>
                                <td>{{ $booking->booking_date->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Ticket Quantity:</strong></td>
                                <td><span class="badge bg-info">{{ $booking->ticket_quantity }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Price per Ticket:</strong></td>
                                <td>{{ $booking->formatted_ticket_price }}</td>
                            </tr>
                            <tr>
                                <td><strong>Total Amount:</strong></td>
                                <td><strong class="text-primary">{{ $booking->formatted_total_amount }}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($booking->special_requests)
                    <div class="mt-3">
                        <h6>Special Requests:</h6>
                        <div class="bg-light p-3 rounded">
                            {{ $booking->special_requests }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Concert Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Concert Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h4>{{ $booking->concert->title }}</h4>
                        <p class="text-muted mb-2">{{ $booking->concert->artist }}</p>
                        <p class="mb-2">{{ $booking->concert->description }}</p>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Venue:</strong> {{ $booking->concert->venue }}</p>
                                <p><strong>Address:</strong> {{ $booking->concert->venue_address }}</p>
                                <p><strong>City:</strong> {{ $booking->concert->city }}, {{ $booking->concert->state }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Date:</strong> {{ $booking->concert->event_date->format('M d, Y') }}</p>
                                <p><strong>Time:</strong> {{ $booking->concert->event_time->format('H:i') }}</p>
                                <p><strong>Duration:</strong> {{ $booking->concert->duration_minutes }} minutes</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        @if($booking->concert->image_url)
                            <img src="{{ $booking->concert->image_url }}" alt="{{ $booking->concert->title }}" 
                                 class="img-fluid rounded">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 200px;">
                                <i class="fas fa-music fa-3x text-muted"></i>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Sidebar -->
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($booking->status === 'pending')
                        <form method="POST" action="{{ route('admin.bookings.confirm', $booking) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check me-2"></i>Confirm Booking
                            </button>
                        </form>
                    @endif
                    
                    @if(in_array($booking->status, ['pending', 'confirmed']))
                        <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-warning w-100"
                                    onclick="return confirm('Are you sure you want to cancel this booking?')">
                                <i class="fas fa-times me-2"></i>Cancel Booking
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Booking
                    </a>
                    
                    <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100"
                                onclick="return confirm('Are you sure you want to delete this booking? This action cannot be undone.')">
                            <i class="fas fa-trash me-2"></i>Delete Booking
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Status Timeline -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Status Timeline</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Booking Created</h6>
                            <p class="timeline-text">{{ $booking->booking_date->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    
                    @if($booking->confirmed_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Booking Confirmed</h6>
                                <p class="timeline-text">{{ $booking->confirmed_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    @endif
                    
                    @if($booking->cancelled_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-danger"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Booking Cancelled</h6>
                                <p class="timeline-text">{{ $booking->cancelled_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 5px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -31px;
    top: 15px;
    width: 2px;
    height: calc(100% + 5px);
    background-color: #dee2e6;
}

.timeline-title {
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.timeline-text {
    font-size: 0.8rem;
    color: #6c757d;
    margin-bottom: 0;
}
</style>
@endpush
