@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-edit me-2"></i>
        Edit User
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-info">
                <i class="fas fa-eye me-1"></i>
                View User
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Back to Users
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

<form action="{{ route('admin.users.update', $user) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="row">
        <!-- User Information -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        User Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" placeholder="Leave blank to keep current password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Leave blank to keep the current password.</small>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" 
                               placeholder="Confirm new password">
                    </div>
                </div>
            </div>

            <!-- Account Status -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cog me-2"></i>
                        Account Status
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="is_active" class="form-label">Account Status</label>
                                <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active">
                                    <option value="1" {{ old('is_active', $user->is_active) ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !old('is_active', $user->is_active) ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email_verified_at" class="form-label">Email Verification</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="verify_email" name="verify_email" 
                                           {{ $user->email_verified_at ? 'checked' : '' }}>
                                    <label class="form-check-label" for="verify_email">
                                        Email is verified
                                    </label>
                                </div>
                                @if($user->email_verified_at)
                                    <small class="text-muted">
                                        Verified on: {{ $user->email_verified_at->format('M d, Y g:i A') }}
                                    </small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Current User Info -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>
                        Current Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" 
                             style="width: 60px; height: 60px; font-size: 24px;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h6>{{ $user->name }}</h6>
                        <p class="text-muted">{{ $user->email }}</p>
                    </div>
                    
                    <hr>
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h6 class="text-success">{{ $user->bookings->count() }}</h6>
                                <small class="text-muted">Bookings</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h6 class="text-info">${{ number_format($user->bookings->sum('total_amount'), 0) }}</h6>
                            <small class="text-muted">Total Spent</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Details -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info me-2"></i>
                        Account Details
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <strong>Member Since:</strong><br>
                            <small class="text-muted">{{ $user->created_at->format('M d, Y') }}</small>
                        </li>
                        <li class="mb-2">
                            <strong>Last Updated:</strong><br>
                            <small class="text-muted">{{ $user->updated_at->format('M d, Y g:i A') }}</small>
                        </li>
                        <li class="mb-2">
                            <strong>Status:</strong><br>
                            @if($user->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </li>
                        <li>
                            <strong>Email Status:</strong><br>
                            @if($user->email_verified_at)
                                <span class="badge bg-success">Verified</span>
                            @else
                                <span class="badge bg-warning">Unverified</span>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Actions -->
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Update User
                        </button>
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-info">
                            <i class="fas fa-eye me-2"></i>
                            View User
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
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
// Password confirmation validation
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const confirmPassword = document.getElementById('password_confirmation');
    
    if (password && confirmPassword.value) {
        if (password !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Passwords do not match');
        } else {
            confirmPassword.setCustomValidity('');
        }
    }
});

document.getElementById('password_confirmation').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmPassword = this.value;
    
    if (password && confirmPassword) {
        if (password !== confirmPassword) {
            this.setCustomValidity('Passwords do not match');
        } else {
            this.setCustomValidity('');
        }
    }
});

// Prevent admin from deactivating themselves
@if($user->id === auth()->id())
document.getElementById('is_active').addEventListener('change', function() {
    if (this.value === '0') {
        alert('You cannot deactivate your own account.');
        this.value = '1';
    }
});
@endif
</script>
@endpush
