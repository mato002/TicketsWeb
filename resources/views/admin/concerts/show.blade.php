@extends('admin.layouts.app')

@section('title', 'View Concert')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-eye me-2"></i>
        View Concert
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.events.edit', $concert) }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-edit me-1"></i>
                Edit
            </a>
            <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Back to Concerts
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Concert Details -->
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Concert Details
                    </h5>
                    <span class="badge bg-{{ $concert->status_badge }} fs-6">
                        {{ ucfirst($concert->status) }}
                        @if($concert->featured)
                            <i class="fas fa-star ms-1"></i>
                        @endif
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>{{ $concert->title }}</h4>
                        <p class="text-muted">{{ $concert->artist }}</p>
                        @if($concert->description)
                            <p>{{ $concert->description }}</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        @if($concert->image)
                            <img src="{{ asset('storage/' . $concert->image) }}" alt="{{ $concert->title }}" class="img-fluid rounded">
                        @else
                            <div class="bg-gray-200 d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-image text-gray-400 fa-3x"></i>
                            </div>
                        @endif
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Event Date:</strong> {{ $concert->event_date?->format('F j, Y') ?? 'TBD' }}</p>
                        <p><strong>Event Time:</strong> {{ $concert->event_time?->format('h:i A') ?? 'TBD' }}</p>
                        <p><strong>Venue:</strong> {{ $concert->venue ?? 'N/A' }}</p>
                        <p><strong>Base Price:</strong> KSH {{ number_format($concert->base_price, 2) }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Event Type:</strong> {{ $concert->event_type_name ?? 'N/A' }}</p>
                        <p><strong>Available Tickets:</strong> {{ $concert->available_tickets }}</p>
                        <p><strong>Status:</strong> <span class="badge bg-{{ $concert->status_badge }} text-white">{{ ucfirst($concert->status) }}</span></p>
                        <p><strong>Featured:</strong> {{ $concert->featured ? 'Yes' : 'No' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Actions -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-cogs me-2"></i>
                    Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.events.edit', $concert) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>
                        Edit Concert
                    </a>
                    
                    <form method="POST" action="{{ route('admin.events.toggle-featured', $concert) }}" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-{{ $concert->featured ? 'warning' : 'outline-warning' }} w-100">
                            <i class="fas fa-star{{ $concert->featured ? '' : '-o' }}"></i>
                            {{ $concert->featured ? 'Remove from Featured' : 'Mark as Featured' }}
                        </button>
                    </form>
                </div>
                
                <!-- Status Actions -->
                <div class="mt-3">
                    <h6>Update Status</h6>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-edit me-2"></i>
                            Change Status
                        </button>
                        <ul class="dropdown-menu w-100">
                            <li>
                                <form method="POST" action="{{ route('admin.events.update-status', $concert) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="draft">
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-file me-2"></i>Set as Draft
                                    </button>
                                </form>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('admin.events.update-status', $concert) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="published">
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-check me-2"></i>Publish
                                    </button>
                                </form>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('admin.events.update-status', $concert) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-times me-2"></i>Cancel
                                    </button>
                                </form>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('admin.events.update-status', $concert) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-check-circle me-2"></i>Mark as Completed
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Delete Action -->
                <div class="mt-3">
                    <form method="POST" action="{{ route('admin.events.destroy', $concert) }}" 
                          onsubmit="return confirm('Are you absolutely sure you want to delete this concert? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash me-2"></i>
                            Delete Concert
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
