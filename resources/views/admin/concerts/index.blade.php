@extends('admin.layouts.app')

@section('title', 'Concerts Management')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-calendar-alt me-2"></i>
        Concerts Management
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="exportConcerts()">
                <i class="fas fa-download me-1"></i>
                Export
            </button>
        </div>
        <a href="{{ route('admin.concerts.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i>
            Add New Concert
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.concerts.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">All Statuses</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="featured" class="form-label">Featured</label>
                <select class="form-select" id="featured" name="featured">
                    <option value="">All</option>
                    <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Featured Only</option>
                    <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>Not Featured</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="search" class="form-label">Search</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Search by title, artist, or venue">
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Concerts Table -->
<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Artist</th>
                        <th>Venue</th>
                        <th>Date & Time</th>
                        <th>Price</th>
                        <th>Tickets</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($concerts as $concert)
                        <tr>
                            <td>
                                @if($concert->image_url)
                                    <img src="{{ $concert->image_url }}" alt="{{ $concert->title }}" 
                                         class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px;">
                                        <i class="fas fa-music text-white"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $concert->title }}</strong>
                                @if($concert->description)
                                    <br><small class="text-muted">{{ Str::limit($concert->description, 50) }}</small>
                                @endif
                            </td>
                            <td>{{ $concert->artist }}</td>
                            <td>
                                {{ $concert->venue }}<br>
                                <small class="text-muted">{{ $concert->city }}, {{ $concert->state }}</small>
                            </td>
                            <td>
                                {{ $concert->event_date->format('M d, Y') }}<br>
                                <small class="text-muted">{{ $concert->event_time->format('g:i A') }}</small>
                            </td>
                            <td>{{ $concert->formatted_price }}</td>
                            <td>
                                <span class="badge bg-{{ $concert->available_tickets > 0 ? 'success' : 'danger' }}">
                                    {{ $concert->available_tickets }} / {{ $concert->total_tickets }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $concert->status_badge }}">
                                    {{ ucfirst($concert->status) }}
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.concerts.toggle-featured', $concert) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-{{ $concert->featured ? 'warning' : 'outline-warning' }}">
                                        <i class="fas fa-star"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.concerts.show', $concert) }}" class="btn btn-sm btn-outline-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.concerts.edit', $concert) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.concerts.destroy', $concert) }}" class="d-inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this concert?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <i class="fas fa-music fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No concerts found</h5>
                                <p class="text-muted">Start by adding your first concert.</p>
                                <a href="{{ route('admin.concerts.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Add First Concert
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($concerts->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $concerts->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function exportConcerts() {
    // Add export functionality here
    alert('Export functionality will be implemented soon!');
}
</script>
@endpush
