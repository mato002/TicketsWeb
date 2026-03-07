@extends('admin.layouts.app')

@section('title', 'Bookings Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-ticket-alt me-2"></i>Bookings Management</h2>
    <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Create New Booking
    </a>
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

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.bookings.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Search</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Booking ref, name, or email">
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
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search me-1"></i>Filter
                    </button>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>Clear
                    </a>
                </div>
            </div>
        </form>
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
                            <th>Tickets</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Date</th>
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
                                        <small class="text-muted">{{ $booking->concert->artist }}</small><br>
                                        <small class="text-muted">{{ $booking->concert->event_date->format('M d, Y') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $booking->ticket_quantity }}</span>
                                </td>
                                <td>
                                    <strong>{{ $booking->formatted_total_amount }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $booking->status_badge }}">
                                        {{ $booking->status_text }}
                                    </span>
                                </td>
                                <td>
                                    {{ $booking->booking_date->format('M d, Y H:i') }}
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.bookings.show', $booking) }}" 
                                           class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.bookings.edit', $booking) }}" 
                                           class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        @if($booking->status === 'pending')
                                            <form method="POST" action="{{ route('admin.bookings.confirm', $booking) }}" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-success" title="Confirm">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if(in_array($booking->status, ['pending', 'confirmed']))
                                            <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Cancel"
                                                        onclick="event.preventDefault(); cancelBooking(this);">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                                    onclick="event.preventDefault(); deleteBooking(this);">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
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
                <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Create First Booking
                </a>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function cancelBooking(form) {
    Swal.fire({
        title: 'Cancel Booking?',
        text: "Are you sure you want to cancel this booking?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f59e0b',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, cancel it!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

function deleteBooking(form) {
    Swal.fire({
        title: 'Delete Booking?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
</script>
@endpush
@endsection
