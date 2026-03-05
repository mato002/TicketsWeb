@extends('admin.layouts.app')

@section('title', 'Booking Reports')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-ticket-alt me-2"></i>Booking Reports</h2>
    <div class="btn-group">
        <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
        </a>
        <a href="{{ route('admin.reports.export-bookings') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}" class="btn btn-success">
            <i class="fas fa-download me-2"></i>Export CSV
        </a>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.bookings') }}" class="row g-3">
            <div class="col-md-3">
                <label for="date_from" class="form-label">From Date</label>
                <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
                <label for="date_to" class="form-label">To Date</label>
                <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="concert_id" class="form-label">Concert</label>
                <select class="form-select" id="concert_id" name="concert_id">
                    <option value="">All Concerts</option>
                    @foreach($concerts as $concert)
                        <option value="{{ $concert->id }}" {{ request('concert_id') == $concert->id ? 'selected' : '' }}>
                            {{ $concert->title }} - {{ $concert->event_date->format('M d, Y') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>Filter
                    </button>
                    <a href="{{ route('admin.reports.bookings') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>Clear
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h4>{{ $bookingStats['total_bookings'] }}</h4>
                <p class="mb-0">Total Bookings</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h4>${{ number_format($bookingStats['total_revenue'], 2) }}</h4>
                <p class="mb-0">Total Revenue</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h4>{{ $bookingStats['pending_bookings'] }}</h4>
                <p class="mb-0">Pending</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h4>{{ $bookingStats['confirmed_bookings'] }}</h4>
                <p class="mb-0">Confirmed</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card bg-danger text-white">
            <div class="card-body text-center">
                <h4>{{ $bookingStats['cancelled_bookings'] }}</h4>
                <p class="mb-0">Cancelled</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card bg-secondary text-white">
            <div class="card-body text-center">
                <h4>{{ $bookingStats['completed_bookings'] }}</h4>
                <p class="mb-0">Completed</p>
            </div>
        </div>
    </div>
</div>

<!-- Bookings Table -->
<div class="card">
    <div class="card-body">
        @if($bookings->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Booking Ref</th>
                            <th>Customer</th>
                            <th>Concert</th>
                            <th>Event Date</th>
                            <th>Tickets</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Booking Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td>
                                    <code>{{ $booking->booking_reference }}</code>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $booking->customer_name }}</strong><br>
                                        <small class="text-muted">{{ $booking->customer_email }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $booking->concert->title }}</strong><br>
                                        <small class="text-muted">{{ $booking->concert->artist }}</small>
                                    </div>
                                </td>
                                <td>
                                    {{ $booking->concert->event_date->format('M d, Y') }}
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $booking->ticket_quantity }}</span>
                                </td>
                                <td>
                                    <strong>${{ number_format($booking->total_amount, 2) }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $booking->status_badge }}">
                                        {{ $booking->status_text }}
                                    </span>
                                </td>
                                <td>
                                    {{ $booking->created_at->format('M d, Y H:i') }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $bookings->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No bookings found</h4>
                <p class="text-muted">No bookings match your current filters.</p>
            </div>
        @endif
    </div>
</div>
@endsection





