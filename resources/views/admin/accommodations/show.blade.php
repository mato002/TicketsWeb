@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">{{ $accommodation->name }}</h1>
                <div>
                    <a href="{{ route('admin.accommodations.edit', $accommodation) }}" class="btn btn-primary me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.accommodations.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Accommodation Details</h5>
                            
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Name:</strong></div>
                                <div class="col-sm-9">{{ $accommodation->name }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Type:</strong></div>
                                <div class="col-sm-9">
                                    <span class="badge bg-info">{{ ucfirst($accommodation->type) }}</span>
                                </div>
                            </div>

                            @if($accommodation->description)
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Description:</strong></div>
                                    <div class="col-sm-9">{{ $accommodation->description }}</div>
                                </div>
                            @endif

                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Address:</strong></div>
                                <div class="col-sm-9">{{ $accommodation->full_address }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Contact:</strong></div>
                                <div class="col-sm-9">
                                    @if($accommodation->phone)
                                        <div><i class="fas fa-phone"></i> {{ $accommodation->phone }}</div>
                                    @endif
                                    @if($accommodation->email)
                                        <div><i class="fas fa-envelope"></i> {{ $accommodation->email }}</div>
                                    @endif
                                    @if($accommodation->website)
                                        <div><i class="fas fa-globe"></i> <a href="{{ $accommodation->website }}" target="_blank">{{ $accommodation->website }}</a></div>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Pricing:</strong></div>
                                <div class="col-sm-9">
                                    <div class="d-flex align-items-center">
                                        <span class="h4 text-primary me-2">{{ $accommodation->formatted_price }}</span>
                                        <small class="text-muted">per night</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Max Guests:</strong></div>
                                <div class="col-sm-9">{{ $accommodation->max_guests }} guests</div>
                            </div>

                            @if($accommodation->amenities && count($accommodation->amenities) > 0)
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Amenities:</strong></div>
                                    <div class="col-sm-9">
                                        @foreach($accommodation->amenities as $amenity)
                                            <span class="badge bg-secondary me-1">{{ $amenity }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($accommodation->latitude && $accommodation->longitude)
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Coordinates:</strong></div>
                                    <div class="col-sm-9">
                                        <small class="text-muted">
                                            {{ $accommodation->latitude }}, {{ $accommodation->longitude }}
                                        </small>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Status & Rating</h5>
                            
                            <div class="mb-3">
                                <strong>Status:</strong>
                                <span class="badge bg-{{ $accommodation->status_badge }} ms-2">
                                    {{ ucfirst($accommodation->status) }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <strong>Featured:</strong>
                                @if($accommodation->featured)
                                    <span class="badge bg-warning ms-2">Yes</span>
                                @else
                                    <span class="text-muted ms-2">No</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <strong>Rating:</strong>
                                <div class="mt-1">
                                    @if($accommodation->rating)
                                        <div class="d-flex align-items-center">
                                            <span class="h5 text-warning me-2">{{ $accommodation->formatted_rating }}</span>
                                            <small class="text-muted">({{ $accommodation->review_count }} reviews)</small>
                                        </div>
                                    @else
                                        <span class="text-muted">No rating yet</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <strong>Created:</strong>
                                <div class="text-muted">{{ $accommodation->created_at->format('M d, Y H:i') }}</div>
                            </div>

                            <div class="mb-3">
                                <strong>Last Updated:</strong>
                                <div class="text-muted">{{ $accommodation->updated_at->format('M d, Y H:i') }}</div>
                            </div>
                        </div>
                    </div>

                    @if($accommodation->images && count($accommodation->images) > 0)
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title">Images</h5>
                                <div class="row">
                                    @foreach($accommodation->images as $image)
                                        <div class="col-6 mb-2">
                                            <img src="{{ $image }}" alt="{{ $accommodation->name }}" 
                                                 class="img-fluid rounded" style="height: 100px; object-fit: cover; width: 100%;">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="card mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Quick Actions</h5>
                            
                            <div class="d-grid gap-2">
                                <form action="{{ route('admin.accommodations.toggle-featured', $accommodation) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-warning btn-sm w-100">
                                        <i class="fas fa-star"></i> 
                                        {{ $accommodation->featured ? 'Remove from Featured' : 'Add to Featured' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.accommodations.destroy', $accommodation) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this accommodation?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm w-100">
                                        <i class="fas fa-trash"></i> Delete Accommodation
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


