@extends('admin.layouts.app')

@section('title', 'Edit Concert')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-edit me-2"></i>
        Edit Concert
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
<a href="{{ route('admin.events.show', $concert->id) }}" class="btn btn-sm btn-outline-info">                <i class="fas fa-eye me-1"></i>
                View
            </a>
            <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Back to Concerts
            </a>
        </div>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h6><i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:</h6>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('admin.events.update', $concert) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row">
        <!-- Basic Information -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Basic Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title" class="form-label">Concert Title *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title', $concert->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="artist" class="form-label">Artist/Performer *</label>
                                <input type="text" class="form-control @error('artist') is-invalid @enderror" 
                                       id="artist" name="artist" value="{{ old('artist', $concert->artist) }}" required>
                                @error('artist')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4">{{ old('description', $concert->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="event_date" class="form-label">Event Date *</label>
                                <input type="date" class="form-control @error('event_date') is-invalid @enderror" 
                                       id="event_date" name="event_date" value="{{ old('event_date', $concert->event_date->format('Y-m-d')) }}" required>
                                @error('event_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="event_time" class="form-label">Event Time *</label>
                                <input type="time" class="form-control @error('event_time') is-invalid @enderror" 
                                       id="event_time" name="event_time" value="{{ old('event_time', $concert->event_time->format('H:i')) }}" required>
                                @error('event_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="duration_minutes" class="form-label">Duration (minutes) *</label>
                                <input type="number" class="form-control @error('duration_minutes') is-invalid @enderror" 
                                       id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes', $concert->duration_minutes) }}" 
                                       min="30" max="480" required>
                                @error('duration_minutes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="base_price" class="form-label">Base Price ($) *</label>
                                <input type="number" class="form-control @error('base_price') is-invalid @enderror" 
                                       id="base_price" name="base_price" value="{{ old('base_price', $concert->base_price) }}" 
                                       step="0.01" min="0" required>
                                @error('base_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Venue Information -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Venue Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="venue" class="form-label">Venue Name *</label>
                        <input type="text" class="form-control @error('venue') is-invalid @enderror" 
                               id="venue" name="venue" value="{{ old('venue', $concert->venue) }}" required>
                        @error('venue')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="venue_address" class="form-label">Venue Address *</label>
                        <textarea class="form-control @error('venue_address') is-invalid @enderror" 
                                  id="venue_address" name="venue_address" rows="2" required>{{ old('venue_address', $concert->venue_address) }}</textarea>
                        @error('venue_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="city" class="form-label">City *</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                       id="city" name="city" value="{{ old('city', $concert->city) }}" required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="state" class="form-label">State/Province *</label>
                                <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                       id="state" name="state" value="{{ old('state', $concert->state) }}" required>
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="country" class="form-label">Country *</label>
                                <input type="text" class="form-control @error('country') is-invalid @enderror" 
                                       id="country" name="country" value="{{ old('country', $concert->country) }}" required>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="number" class="form-control @error('latitude') is-invalid @enderror" 
                                       id="latitude" name="latitude" value="{{ old('latitude', $concert->latitude) }}" 
                                       step="0.00000001" placeholder="e.g., 40.7128">
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="number" class="form-control @error('longitude') is-invalid @enderror" 
                                       id="longitude" name="longitude" value="{{ old('longitude', $concert->longitude) }}" 
                                       step="0.00000001" placeholder="e.g., -74.0060">
                                @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="total_tickets" class="form-label">Total Tickets *</label>
                                <input type="number" class="form-control @error('total_tickets') is-invalid @enderror" 
                                       id="total_tickets" name="total_tickets" value="{{ old('total_tickets', $concert->total_tickets) }}" 
                                       min="1" required>
                                @error('total_tickets')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="available_tickets" class="form-label">Available Tickets *</label>
                                <input type="number" class="form-control @error('available_tickets') is-invalid @enderror" 
                                       id="available_tickets" name="available_tickets" value="{{ old('available_tickets', $concert->available_tickets) }}" 
                                       min="0" required>
                                @error('available_tickets')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Ticket Categories -->
                    <div class="mb-3">
                        <label class="form-label">Ticket Categories</label>
                        <div id="ticket-categories">
                            @if(old('ticket_categories'))
                                @foreach(old('ticket_categories') as $index => $category)
                                    <div class="ticket-category row mb-2">
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="ticket_categories[{{ $index }}][name]" 
                                                   placeholder="Category name" value="{{ $category['name'] ?? '' }}">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" class="form-control" name="ticket_categories[{{ $index }}][price]" 
                                                   placeholder="Price" step="0.01" min="0" value="{{ $category['price'] ?? '' }}">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" class="form-control" name="ticket_categories[{{ $index }}][quantity]" 
                                                   placeholder="Quantity" min="0" value="{{ $category['quantity'] ?? '' }}">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeCategory(this)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @elseif($concert->ticket_categories && count($concert->ticket_categories) > 0)
                                @foreach($concert->ticket_categories as $index => $category)
                                    <div class="ticket-category row mb-2">
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="ticket_categories[{{ $index }}][name]" 
                                                   placeholder="Category name" value="{{ $category['name'] }}">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" class="form-control" name="ticket_categories[{{ $index }}][price]" 
                                                   placeholder="Price" step="0.01" min="0" value="{{ $category['price'] }}">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" class="form-control" name="ticket_categories[{{ $index }}][quantity]" 
                                                   placeholder="Quantity" min="0" value="{{ $category['quantity'] ?? '' }}">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeCategory(this)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="ticket-category row mb-2">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="ticket_categories[0][name]" 
                                               placeholder="Category name (e.g., VIP, Regular)">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" class="form-control" name="ticket_categories[0][price]" 
                                               placeholder="Price" step="0.01" min="0">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" class="form-control" name="ticket_categories[0][quantity]" 
                                               placeholder="Quantity" min="0">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeCategory(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="addCategory()">
                            <i class="fas fa-plus me-1"></i>Add Category
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Status & Settings -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cog me-2"></i>
                        Status & Settings
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="draft" {{ old('status', $concert->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $concert->status) == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="cancelled" {{ old('status', $concert->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="completed" {{ old('status', $concert->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="featured" name="featured" 
                                   {{ old('featured', $concert->featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="featured">
                                Featured Concert
                            </label>
                        </div>
                        <small class="text-muted">Featured concerts appear prominently on the homepage.</small>
                    </div>
                </div>
            </div>

            <!-- Image Upload -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-image me-2"></i>
                        Concert Image
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="image_url" class="form-label">Image URL</label>
                        <input type="url" class="form-control @error('image_url') is-invalid @enderror" 
                               id="image_url" name="image_url" value="{{ old('image_url', $concert->image_url) }}" 
                               placeholder="https://example.com/image.jpg">
                        @error('image_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="text-center">
                        <div id="image-preview" class="mb-3">
                            <img id="preview-img" src="{{ $concert->image_url ?: '' }}" alt="Preview" 
                                 class="img-fluid rounded" style="max-height: 200px; {{ !$concert->image_url ? 'display: none;' : '' }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Update Concert
                        </button>
                        <a href="{{ route('admin.events.show', $concert) }}" class="btn btn-outline-info">
                            <i class="fas fa-eye me-2"></i>
                            View Concert
                        </a>
                        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
let categoryIndex = {{ count(old('ticket_categories', $concert->ticket_categories ?? [])) }};

function addCategory() {
    const container = document.getElementById('ticket-categories');
    const newCategory = document.createElement('div');
    newCategory.className = 'ticket-category row mb-2';
    newCategory.innerHTML = `
        <div class="col-md-4">
            <input type="text" class="form-control" name="ticket_categories[${categoryIndex}][name]" 
                   placeholder="Category name (e.g., VIP, Regular)">
        </div>
        <div class="col-md-3">
            <input type="number" class="form-control" name="ticket_categories[${categoryIndex}][price]" 
                   placeholder="Price" step="0.01" min="0">
        </div>
        <div class="col-md-3">
            <input type="number" class="form-control" name="ticket_categories[${categoryIndex}][quantity]" 
                   placeholder="Quantity" min="0">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeCategory(this)">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(newCategory);
    categoryIndex++;
}

function removeCategory(button) {
    button.closest('.ticket-category').remove();
}

// Image preview
document.getElementById('image_url').addEventListener('input', function() {
    const url = this.value;
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    
    if (url) {
        previewImg.src = url;
        previewImg.style.display = 'block';
    } else {
        previewImg.style.display = 'none';
    }
});

// Set available tickets max based on total tickets
document.getElementById('total_tickets').addEventListener('input', function() {
    const availableInput = document.getElementById('available_tickets');
    availableInput.max = this.value;
});
</script>
@endpush
