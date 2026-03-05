@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Accommodations</h1>
                <a href="{{ route('admin.accommodations.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Accommodation
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Location</th>
                                    <th>Price/Night</th>
                                    <th>Status</th>
                                    <th>Featured</th>
                                    <th>Rating</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($accommodations as $accommodation)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($accommodation->images && count($accommodation->images) > 0)
                                                    <img src="{{ $accommodation->images[0] }}" 
                                                         alt="{{ $accommodation->name }}" 
                                                         class="rounded me-2" 
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <strong>{{ $accommodation->name }}</strong>
                                                    @if($accommodation->description)
                                                        <br><small class="text-muted">{{ Str::limit($accommodation->description, 50) }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ ucfirst($accommodation->type) }}</span>
                                        </td>
                                        <td>
                                            {{ $accommodation->city }}, {{ $accommodation->state }}
                                        </td>
                                        <td>
                                            <strong>{{ $accommodation->formatted_price }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $accommodation->status_badge }}">
                                                {{ ucfirst($accommodation->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($accommodation->featured)
                                                <span class="badge bg-warning">Featured</span>
                                            @else
                                                <span class="text-muted">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($accommodation->rating)
                                                <div class="d-flex align-items-center">
                                                    <span class="me-1">{{ $accommodation->formatted_rating }}</span>
                                                    <small class="text-muted">({{ $accommodation->review_count }} reviews)</small>
                                                </div>
                                            @else
                                                <span class="text-muted">No rating</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.accommodations.show', $accommodation) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.accommodations.edit', $accommodation) }}" 
                                                   class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.accommodations.toggle-featured', $accommodation) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-warning">
                                                        <i class="fas fa-star"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.accommodations.destroy', $accommodation) }}" 
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this accommodation?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
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
                                                <i class="fas fa-bed fa-2x mb-2"></i>
                                                <p>No accommodations found.</p>
                                                <a href="{{ route('admin.accommodations.create') }}" class="btn btn-primary">
                                                    Add First Accommodation
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($accommodations->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $accommodations->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


