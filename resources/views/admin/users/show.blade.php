@extends('admin.layouts.app')

@section('title', 'User Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user me-2"></i>
        User Details
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-edit me-1"></i>
                Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Back to Users
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- User Information -->
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        User Information
                    </h5>
                    <div class="d-flex gap-2">
                        @if($user->is_active)
                            <span class="badge bg-success fs-6">Active</span>
                        @else
                            <span class="badge bg-danger fs-6">Inactive</span>
                        @endif
                        
                        @if($user->email_verified_at)
                            <span class="badge bg-success fs-6">
                                <i class="fas fa-check me-1"></i>Verified
                            </span>
                        @else
                            <span class="badge bg-warning fs-6">
                                <i class="fas fa-exclamation me-1"></i>Unverified
                            </span>
                        @endif
                        
                        @if($user->id === auth()->id())
                            <span class="badge bg-info fs-6">You</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-4">
                            <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-4" 
                                 style="width: 80px; height: 80px; font-size: 32px;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="mb-1">{{ $user->name }}</h4>
                                <p class="text-muted mb-0">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-6">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{ $user->bookings->count() }}</h5>
                                        <p class="card-text">Total Bookings</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">
                                            ${{ number_format($user->bookings->sum('total_amount'), 2) }}
                                        </h5>
                                        <p class="card-text">Total Spent</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-calendar me-2"></i>Account Information</h6>
                        <ul class="list-unstyled">
                            <li><strong>Member Since:</strong> {{ $user->created_at->format('l, F j, Y') }}</li>
                            <li><strong>Last Updated:</strong> {{ $user->updated_at->format('M d, Y g:i A') }}</li>
                            @if($user->email_verified_at)
                                <li><strong>Email Verified:</strong> {{ $user->email_verified_at->format('M d, Y g:i A') }}</li>
                            @else
                                <li><strong>Email Verified:</strong> <span class="text-warning">Not verified</span></li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-chart-line me-2"></i>Activity Summary</h6>
                        <ul class="list-unstyled">
                            <li><strong>Total Bookings:</strong> {{ $user->bookings->count() }}</li>
                            <li><strong>Active Bookings:</strong> {{ $user->bookings->where('status', '!=', 'cancelled')->count() }}</li>
                            <li><strong>Total Spent:</strong> ${{ number_format($user->bookings->sum('total_amount'), 2) }}</li>
                            <li><strong>Average Booking:</strong> ${{ $user->bookings->count() > 0 ? number_format($user->bookings->avg('total_amount'), 2) : '0.00' }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Bookings -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-ticket-alt me-2"></i>
                    User Bookings
                </h5>
            </div>
            <div class="card-body">
                @if($user->bookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Concert</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->bookings as $booking)
                                    <tr>
                                        <td>#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $booking->concert->title }}</td>
                                        <td>{{ $booking->concert->event_date->format('M d, Y') }}</td>
                                        <td>${{ number_format($booking->total_amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Bookings Found</h5>
                        <p class="text-muted">This user hasn't made any bookings yet.</p>
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
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>
                        Edit User
                    </a>
                    
                    @if($user->id !== auth()->id())
                        <!-- Toggle Active Status -->
                        <form method="POST" action="{{ route('admin.users.toggle-active', $user) }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-{{ $user->is_active ? 'warning' : 'success' }} w-100">
                                <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }} me-2"></i>
                                {{ $user->is_active ? 'Deactivate User' : 'Activate User' }}
                            </button>
                        </form>

                        <!-- Verify Email -->
                        @if(!$user->email_verified_at)
                            <form method="POST" action="{{ route('admin.users.verify-email', $user) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-envelope-check me-2"></i>
                                    Verify Email
                                </button>
                            </form>
                        @endif

                        <!-- Send Password Reset -->
                        <form method="POST" action="{{ route('admin.users.send-password-reset', $user) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-info w-100">
                                <i class="fas fa-key me-2"></i>
                                Send Password Reset
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- User Statistics -->
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
                            <h4 class="text-success">{{ $user->bookings->count() }}</h4>
                            <small class="text-muted">Total Bookings</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-info">${{ number_format($user->bookings->sum('total_amount'), 0) }}</h4>
                        <small class="text-muted">Total Spent</small>
                    </div>
                </div>
                
                @if($user->bookings->count() > 0)
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h5 class="text-warning">${{ number_format($user->bookings->avg('total_amount'), 2) }}</h5>
                                <small class="text-muted">Avg Booking</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h5 class="text-primary">{{ $user->bookings->where('status', 'confirmed')->count() }}</h5>
                            <small class="text-muted">Confirmed</small>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if($user->id !== auth()->id())
            <!-- Danger Zone -->
            <div class="card shadow border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Danger Zone
                    </h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Once you delete a user, there is no going back. Please be certain.</p>
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                          onsubmit="return confirm('Are you absolutely sure you want to delete this user? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>
                            Delete User
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
