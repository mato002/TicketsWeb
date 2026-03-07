@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-tachometer-alt me-2"></i>
        Dashboard
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-download me-1"></i>
                Export
            </button>
        </div>
        <div class="btn-group me-2">
            <a href="{{ route('admin.events.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i>
                Add Event
            </a>
            <a href="{{ route('admin.accommodations.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-bed me-1"></i>
                Add Accommodation
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Concerts
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">24</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Bookings
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">1,234</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-ticket-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Revenue
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">$45,678</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Users
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\User::count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity and Quick Actions -->
<div class="row">
    <!-- Recent Bookings -->
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-clock me-2"></i>
                    Recent Bookings
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Event</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#BK001</td>
                                <td>Rock Concert 2024</td>
                                <td>John Doe</td>
                                <td>2024-01-15</td>
                                <td>$150.00</td>
                                <td><span class="badge bg-success">Confirmed</span></td>
                            </tr>
                            <tr>
                                <td>#BK002</td>
                                <td>Jazz Night</td>
                                <td>Jane Smith</td>
                                <td>2024-01-14</td>
                                <td>$85.00</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                            </tr>
                            <tr>
                                <td>#BK003</td>
                                <td>Pop Festival</td>
                                <td>Mike Johnson</td>
                                <td>2024-01-13</td>
                                <td>$200.00</td>
                                <td><span class="badge bg-success">Confirmed</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-bolt me-2"></i>
                    Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Add New Event
                    </a>
                    <a href="{{ route('admin.accommodations.create') }}" class="btn btn-info">
                        <i class="fas fa-bed me-2"></i>
                        Manage Accommodations
                    </a>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-info">
                        <i class="fas fa-calendar-alt me-2"></i>
                        View All Events
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-warning">
                        <i class="fas fa-users me-2"></i>
                        Manage Users
                    </a>
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-calendar-check me-2"></i>
                    Upcoming Events
                </h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Rock Concert 2024</h6>
                            <small class="text-muted">Jan 20, 2024 - 8:00 PM</small>
                        </div>
                        <span class="badge bg-primary rounded-pill">2 days</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Jazz Night</h6>
                            <small class="text-muted">Jan 25, 2024 - 7:30 PM</small>
                        </div>
                        <span class="badge bg-primary rounded-pill">7 days</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Pop Festival</h6>
                            <small class="text-muted">Feb 1, 2024 - 6:00 PM</small>
                        </div>
                        <span class="badge bg-primary rounded-pill">14 days</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
