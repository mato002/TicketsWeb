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
        <a href="{{ route('admin.events.create') }}" class="btn btn-sm btn-primary">
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

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.events.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">All Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="event_type" class="form-label">Event Type</label>
                <select class="form-select" id="event_type" name="event_type">
                    <option value="">All Types</option>
                    <option value="music" {{ request('event_type') == 'music' ? 'selected' : '' }}>Music</option>
                    <option value="sports" {{ request('event_type') == 'sports' ? 'selected' : '' }}>Sports</option>
                    <option value="theater" {{ request('event_type') == 'theater' ? 'selected' : '' }}>Theater</option>
                    <option value="comedy" {{ request('event_type') == 'comedy' ? 'selected' : '' }}>Comedy</option>
                    <option value="conference" {{ request('event_type') == 'conference' ? 'selected' : '' }}>Conference</option>
                    <option value="workshop" {{ request('event_type') == 'workshop' ? 'selected' : '' }}>Workshop</option>
                    <option value="festival" {{ request('event_type') == 'festival' ? 'selected' : '' }}>Festival</option>
                    <option value="exhibition" {{ request('event_type') == 'exhibition' ? 'selected' : '' }}>Exhibition</option>
                    <option value="family" {{ request('event_type') == 'family' ? 'selected' : '' }}>Family</option>
                    <option value="outdoor" {{ request('event_type') == 'outdoor' ? 'selected' : '' }}>Outdoor</option>
                    <option value="cultural" {{ request('event_type') == 'cultural' ? 'selected' : '' }}>Cultural</option>
                    <option value="business" {{ request('event_type') == 'business' ? 'selected' : '' }}>Business</option>
                    <option value="other" {{ request('event_type') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="featured" class="form-label">Featured</label>
                <select class="form-select" id="featured" name="featured">
                    <option value="">All</option>
                    <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Featured</option>
                    <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>Not Featured</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="search" class="form-label">Search</label>
                <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Search events...">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search me-2"></i>Filter
                </button>
                <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-2"></i>Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Concerts Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Venue</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($concerts as $concert)
                        <tr>
                            <td>
                                @if($concert->image)
                                    <img src="{{ asset('storage/' . $concert->image) }}" alt="{{ $concert->title }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-gray-200 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $concert->title }}</strong>
                                    @if($concert->event_type)
                                        <br><small class="text-muted">{{ $concert->event_type_name }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                {{ $concert->event_date?->format('M j, Y') ?? 'TBD' }}
                                @if($concert->event_time)
                                    <br><small class="text-muted">{{ $concert->event_time->format('h:i A') }}</small>
                                @endif
                            </td>
                            <td>{{ $concert->venue ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $concert->event_type_color }} text-white">
                                    {{ $concert->event_type_name }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $concert->status_badge }} text-white">
                                    {{ ucfirst($concert->status) }}
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.events.toggle-featured', $concert) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-{{ $concert->featured ? 'warning' : 'outline-warning' }}">
                                        <i class="fas fa-star{{ $concert->featured ? '' : '-o' }}"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.events.show', $concert) }}" class="btn btn-sm btn-outline-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.events.edit', $concert) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.events.destroy', $concert) }}" class="d-inline" 
                                          onsubmit="event.preventDefault(); deleteConcert(this);">
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
                            <td colspan="8" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-music fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No concerts found</h5>
                                    <p class="text-muted">Start by adding your first concert.</p>
                                    <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Add First Concert
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Showing {{ $concerts->firstItem() }} to {{ $concerts->lastItem() }} of {{ $concerts->total() }} entries
            </div>
            {{ $concerts->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
function exportConcerts() {
    const url = '{{ route("admin.events.export") }}';
    window.open(url, '_blank');
}

function deleteConcert(form) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
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
