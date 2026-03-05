@extends('admin.layouts.app')

@section('title', 'User Reports')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-users me-2"></i>User Reports</h2>
    <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.users') }}" class="row g-3">
            <div class="col-md-4">
                <label for="date_from" class="form-label">From Date</label>
                <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-4">
                <label for="date_to" class="form-label">To Date</label>
                <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>Filter
                    </button>
                    <a href="{{ route('admin.reports.users') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>Clear
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h4>{{ $userStats['total_users'] }}</h4>
                <p class="mb-0">Total Users</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h4>{{ $userStats['users_with_bookings'] }}</h4>
                <p class="mb-0">Users with Bookings</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h4>{{ $userStats['new_users_this_month'] }}</h4>
                <p class="mb-0">New This Month</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h4>{{ $userStats['total_users'] > 0 ? number_format(($userStats['users_with_bookings'] / $userStats['total_users']) * 100, 1) : 0 }}%</h4>
                <p class="mb-0">Booking Rate</p>
            </div>
        </div>
    </div>
</div>

<!-- Top Customers -->
@if($userStats['top_customers']->count() > 0)
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Top Customers by Revenue</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Rank</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th class="text-end">Total Bookings</th>
                                <th class="text-end">Total Spent</th>
                                <th class="text-end">Avg per Booking</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userStats['top_customers'] as $index => $customer)
                                <tr>
                                    <td>
                                        <span class="badge bg-{{ $index < 3 ? 'success' : 'primary' }}">
                                            #{{ $index + 1 }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong>{{ $customer->name }}</strong>
                                    </td>
                                    <td>{{ $customer->email }}</td>
                                    <td class="text-end">
                                        <span class="badge bg-info">{{ $customer->bookings_count }}</span>
                                    </td>
                                    <td class="text-end">
                                        <strong>${{ number_format($customer->bookings_sum_total_amount, 2) }}</strong>
                                    </td>
                                    <td class="text-end">
                                        ${{ number_format($customer->bookings_sum_total_amount / max($customer->bookings_count, 1), 2) }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.users.show', $customer) }}" class="btn btn-sm btn-outline-primary" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Users Table -->
<div class="card">
    <div class="card-body">
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Registration Date</th>
                            <th>Bookings</th>
                            <th>Total Spent</th>
                            <th>Last Activity</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div>
                                        <strong>{{ $user->name }}</strong>
                                        @if($user->email_verified_at)
                                            <i class="fas fa-check-circle text-success ms-1" title="Email Verified"></i>
                                        @else
                                            <i class="fas fa-exclamation-circle text-warning ms-1" title="Email Not Verified"></i>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $user->bookings_count ?? 0 }}</span>
                                </td>
                                <td>
                                    <strong>${{ number_format($user->bookings_sum_total_amount ?? 0, 2) }}</strong>
                                </td>
                                <td>
                                    {{ $user->updated_at->format('M d, Y') }}
                                </td>
                                <td>
                                    <span class="badge bg-{{ $user->email_verified_at ? 'success' : 'warning' }}">
                                        {{ $user->email_verified_at ? 'Active' : 'Pending' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-primary" title="View Details">
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
                {{ $users->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No users found</h4>
                <p class="text-muted">No users match your current filters.</p>
            </div>
        @endif
    </div>
</div>
@endsection





