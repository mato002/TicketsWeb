@extends('admin.layouts.app')

@section('title', 'Reports Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-chart-bar me-2"></i>Reports Dashboard</h2>
    <div class="btn-group">
        <a href="{{ route('admin.reports.bookings') }}" class="btn btn-outline-primary">
            <i class="fas fa-ticket-alt me-2"></i>Booking Reports
        </a>
        <a href="{{ route('admin.reports.revenue') }}" class="btn btn-outline-success">
            <i class="fas fa-dollar-sign me-2"></i>Revenue Reports
        </a>
    </div>
</div>

<!-- Key Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ number_format($stats['total_bookings']) }}</h4>
                        <p class="card-text">Total Bookings</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-ticket-alt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">${{ number_format($stats['total_revenue'], 2) }}</h4>
                        <p class="card-text">Total Revenue</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-dollar-sign fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ number_format($stats['total_concerts']) }}</h4>
                        <p class="card-text">Total Concerts</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-music fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ number_format($stats['total_users']) }}</h4>
                        <p class="card-text">Total Users</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Today's Performance -->
<div class="row mb-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Today's Performance</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h3 class="text-primary">{{ $stats['today_bookings'] }}</h3>
                        <p class="text-muted">Bookings Today</p>
                    </div>
                    <div class="col-6">
                        <h3 class="text-success">${{ number_format($stats['today_revenue'], 2) }}</h3>
                        <p class="text-muted">Revenue Today</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">This Month vs Last Month</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h3 class="text-primary">{{ $stats['month_bookings'] }}</h3>
                        <p class="text-muted">This Month</p>
                        <small class="text-muted">vs {{ $stats['last_month_bookings'] }} last month</small>
                    </div>
                    <div class="col-6">
                        <h3 class="text-success">${{ number_format($stats['month_revenue'], 2) }}</h3>
                        <p class="text-muted">This Month</p>
                        <small class="text-muted">vs ${{ number_format($stats['last_month_revenue'], 2) }} last month</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Booking Status Overview -->
<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Booking Status Overview</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-warning">{{ $stats['pending_bookings'] }}</h4>
                            <p class="text-muted mb-0">Pending</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-success">{{ $stats['confirmed_bookings'] }}</h4>
                            <p class="text-muted mb-0">Confirmed</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-danger">{{ $stats['cancelled_bookings'] }}</h4>
                            <p class="text-muted mb-0">Cancelled</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-info">{{ $stats['completed_bookings'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">Completed</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.reports.bookings') }}" class="btn btn-primary">
                        <i class="fas fa-ticket-alt me-2"></i>View All Bookings
                    </a>
                    <a href="{{ route('admin.reports.revenue') }}" class="btn btn-success">
                        <i class="fas fa-chart-line me-2"></i>Revenue Analysis
                    </a>
                    <a href="{{ route('admin.reports.concerts') }}" class="btn btn-info">
                        <i class="fas fa-music me-2"></i>Concert Reports
                    </a>
                    <a href="{{ route('admin.reports.users') }}" class="btn btn-warning">
                        <i class="fas fa-users me-2"></i>User Reports
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Bookings</h5>
            </div>
            <div class="card-body">
                @if($recentBookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Reference</th>
                                    <th>Customer</th>
                                    <th>Concert</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentBookings as $booking)
                                    <tr>
                                        <td><code>{{ $booking->booking_reference }}</code></td>
                                        <td>{{ $booking->customer_name }}</td>
                                        <td>{{ Str::limit($booking->concert->title, 20) }}</td>
                                        <td>${{ number_format($booking->total_amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $booking->status_badge }}">
                                                {{ $booking->status_text }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No recent bookings found.</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Upcoming Concerts</h5>
            </div>
            <div class="card-body">
                @if($upcomingConcerts->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($upcomingConcerts as $concert)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $concert->title }}</h6>
                                    <p class="mb-1 text-muted">{{ $concert->artist }}</p>
                                    <small class="text-muted">{{ $concert->event_date->format('M d, Y') }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-primary">{{ $concert->bookings_count ?? 0 }} bookings</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No upcoming concerts found.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Monthly Revenue Chart -->
@if($monthlyRevenue->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Monthly Revenue Trend</h5>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
@if($monthlyRevenue->count() > 0)
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const monthlyData = @json($monthlyRevenue);
    
    const labels = monthlyData.map(item => {
        const date = new Date(item.month + '-01');
        return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
    });
    
    const revenues = monthlyData.map(item => parseFloat(item.revenue));
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenue ($)',
                data: revenues,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                tension: 0.1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Revenue: $' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            }
        }
    });
});
@endif
</script>
@endpush





