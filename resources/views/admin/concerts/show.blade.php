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
                    <div class="col-md-6 text-end">
                        @if($concert->image_url)
                            <img src="{{ $concert->image_url }}" alt="{{ $concert->title }}" 
                                 class="img-fluid rounded" style="max-height: 200px;">
                        @else
                            <div class="bg-secondary d-flex align-items-center justify-content-center rounded" 
                                 style="height: 200px;">
                                <i class="fas fa-music fa-3x text-white"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-calendar me-2"></i>Event Information</h6>
                        <ul class="list-unstyled">
                            <li><strong>Date:</strong> {{ $concert->event_date->format('l, F j, Y') }}</li>
                            <li><strong>Time:</strong> {{ $concert->event_time->format('g:i A') }}</li>
                            <li><strong>Duration:</strong> {{ $concert->duration_minutes }} minutes</li>
                            <li><strong>Base Price:</strong> {{ $concert->formatted_price }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-map-marker-alt me-2"></i>Venue Information</h6>
                        <ul class="list-unstyled">
                            <li><strong>Venue:</strong> {{ $concert->venue }}</li>
                            <li><strong>Address:</strong> {{ $concert->venue_address }}</li>
                            <li><strong>Location:</strong> {{ $concert->city }}, {{ $concert->state }}, {{ $concert->country }}</li>
                            @if($concert->latitude && $concert->longitude)
                                <li><strong>Coordinates:</strong> {{ $concert->latitude }}, {{ $concert->longitude }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ticket Information -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-ticket-alt me-2"></i>
                    Ticket Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $concert->total_tickets }}</h5>
                                <p class="card-text">Total Tickets</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-{{ $concert->available_tickets > 0 ? 'success' : 'danger' }} text-white">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $concert->available_tickets }}</h5>
                                <p class="card-text">Available Tickets</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($concert->ticket_categories && count($concert->ticket_categories) > 0)
                    <h6>Ticket Categories</h6>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($concert->ticket_categories as $category)
                                    <tr>
                                        <td>{{ $category['name'] }}</td>
                                        <td>${{ number_format($category['price'], 2) }}</td>
                                        <td>{{ $category['quantity'] ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar Actions -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.concerts.edit', $concert) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>
                        Edit Concert
                    </a>
                    
                    <form method="POST" action="{{ route('admin.concerts.toggle-featured', $concert) }}" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-{{ $concert->featured ? 'warning' : 'outline-warning' }} w-100">
                            <i class="fas fa-star me-2"></i>
                            {{ $concert->featured ? 'Remove from Featured' : 'Mark as Featured' }}
                        </button>
                    </form>

                    <!-- Status Update -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-cog me-2"></i>
                            Update Status
                        </button>
                        <ul class="dropdown-menu w-100">
                            <li>
                                <form method="POST" action="{{ route('admin.concerts.update-status', $concert) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="draft">
                                    <button type="submit" class="dropdown-item {{ $concert->status == 'draft' ? 'active' : '' }}">
                                        <i class="fas fa-edit me-2"></i>Draft
                                    </button>
                                </form>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('admin.concerts.update-status', $concert) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="published">
                                    <button type="submit" class="dropdown-item {{ $concert->status == 'published' ? 'active' : '' }}">
                                        <i class="fas fa-eye me-2"></i>Published
                                    </button>
                                </form>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('admin.concerts.update-status', $concert) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="dropdown-item {{ $concert->status == 'cancelled' ? 'active' : '' }}">
                                        <i class="fas fa-times me-2"></i>Cancelled
                                    </button>
                                </form>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('admin.concerts.update-status', $concert) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="dropdown-item {{ $concert->status == 'completed' ? 'active' : '' }}">
                                        <i class="fas fa-check me-2"></i>Completed
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Statistics
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h4 class="text-success">{{ $concert->total_tickets - $concert->available_tickets }}</h4>
                            <small class="text-muted">Sold</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-info">{{ $concert->available_tickets }}</h4>
                        <small class="text-muted">Available</small>
                    </div>
                </div>
                
                @php
                    $soldPercentage = $concert->total_tickets > 0 ? (($concert->total_tickets - $concert->available_tickets) / $concert->total_tickets) * 100 : 0;
                @endphp
                
                <div class="progress mt-3" style="height: 8px;">
                    <div class="progress-bar bg-success" role="progressbar" 
                         style="width: {{ $soldPercentage }}%"></div>
                </div>
                <small class="text-muted">{{ number_format($soldPercentage, 1) }}% sold</small>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="card shadow border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Danger Zone
                </h5>
            </div>
            <div class="card-body">
                <p class="card-text">Once you delete a concert, there is no going back. Please be certain.</p>
                <form method="POST" action="{{ route('admin.concerts.destroy', $concert) }}" 
                      onsubmit="return confirm('Are you absolutely sure you want to delete this concert? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>
                        Delete Concert
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
