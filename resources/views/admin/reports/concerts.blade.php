@extends('admin.layouts.app')

@section('title', 'Concert Reports')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-music me-2"></i>Concert Reports</h2>
    <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.concerts') }}" class="row g-3">
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
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>Filter
                    </button>
                    <a href="{{ route('admin.reports.concerts') }}" class="btn btn-outline-secondary">
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
                <h4>{{ $concertStats['total_concerts'] }}</h4>
                <p class="mb-0">Total Concerts</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h4>{{ $concertStats['published_concerts'] }}</h4>
                <p class="mb-0">Published</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h4>{{ $concertStats['draft_concerts'] }}</h4>
                <p class="mb-0">Draft</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card bg-danger text-white">
            <div class="card-body text-center">
                <h4>{{ $concertStats['cancelled_concerts'] }}</h4>
                <p class="mb-0">Cancelled</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h4>{{ $concertStats['completed_concerts'] }}</h4>
                <p class="mb-0">Completed</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card bg-secondary text-white">
            <div class="card-body text-center">
                <h4>{{ $concertStats['total_tickets_sold'] }}</h4>
                <p class="mb-0">Tickets Sold</p>
            </div>
        </div>
    </div>
</div>

<!-- Concerts Table -->
<div class="card">
    <div class="card-body">
        @if($concerts->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Concert</th>
                            <th>Artist</th>
                            <th>Event Date</th>
                            <th>Venue</th>
                            <th>Price</th>
                            <th>Bookings</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($concerts as $concert)
                            <tr>
                                <td>
                                    <div>
                                        <strong>{{ $concert->title }}</strong>
                                        @if($concert->featured)
                                            <span class="badge bg-warning ms-1">Featured</span>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $concert->artist }}</td>
                                <td>
                                    {{ $concert->event_date->format('M d, Y') }}<br>
                                    <small class="text-muted">{{ $concert->event_time->format('H:i') }}</small>
                                </td>
                                <td>
                                    <div>
                                        {{ $concert->venue }}<br>
                                        <small class="text-muted">{{ $concert->city }}, {{ $concert->state }}</small>
                                    </div>
                                </td>
                                <td>
                                    <strong>${{ number_format($concert->base_price, 2) }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $concert->bookings_count ?? 0 }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $concert->status_badge }}">
                                        {{ ucfirst($concert->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.concerts.show', $concert) }}" class="btn btn-sm btn-outline-primary" title="View Details">
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
                {{ $concerts->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-music fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No concerts found</h4>
                <p class="text-muted">No concerts match your current filters.</p>
            </div>
        @endif
    </div>
</div>
@endsection





