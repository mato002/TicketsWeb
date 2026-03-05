@extends('admin.layouts.app')

@section('title', 'Revenue Reports')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-dollar-sign me-2"></i>Revenue Reports</h2>
    <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.revenue') }}" class="row g-3">
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
                    <a href="{{ route('admin.reports.revenue') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>Clear
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Revenue Statistics -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h3>${{ number_format($revenueStats['total_revenue'], 2) }}</h3>
                <p class="mb-0">Total Revenue</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h3>${{ number_format($revenueStats['average_booking_value'], 2) }}</h3>
                <p class="mb-0">Average Booking Value</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h3>{{ number_format($revenueStats['total_tickets_sold']) }}</h3>
                <p class="mb-0">Tickets Sold</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h3>${{ number_format($revenueStats['total_revenue'] / max($revenueStats['total_tickets_sold'], 1), 2) }}</h3>
                <p class="mb-0">Revenue per Ticket</p>
            </div>
        </div>
    </div>
</div>

<!-- Revenue by Status -->
@if($revenueStats['revenue_by_status']->count() > 0)
<div class="row mb-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Revenue by Status</h5>
            </div>
            <div class="card-body">
                <canvas id="statusChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Revenue Breakdown</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th class="text-end">Revenue</th>
                                <th class="text-end">Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($revenueStats['revenue_by_status'] as $status => $revenue)
                                <tr>
                                    <td>
                                        <span class="badge bg-{{ $status == 'confirmed' ? 'success' : ($status == 'pending' ? 'warning' : ($status == 'cancelled' ? 'danger' : 'info')) }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>
                                    <td class="text-end">${{ number_format($revenue, 2) }}</td>
                                    <td class="text-end">
                                        {{ number_format(($revenue / $revenueStats['total_revenue']) * 100, 1) }}%
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

<!-- Monthly Revenue Chart -->
@if($monthlyRevenue->count() > 0)
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Monthly Revenue Trend</h5>
            </div>
            <div class="card-body">
                <canvas id="monthlyChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Top Performing Concerts -->
@if($revenueByConcert->count() > 0)
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Top Performing Concerts</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Rank</th>
                                <th>Concert</th>
                                <th>Artist</th>
                                <th class="text-end">Revenue</th>
                                <th class="text-end">Bookings</th>
                                <th class="text-end">Avg per Booking</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($revenueByConcert as $index => $concert)
                                <tr>
                                    <td>
                                        <span class="badge bg-{{ $index < 3 ? 'success' : 'primary' }}">
                                            #{{ $index + 1 }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong>{{ $concert->title }}</strong>
                                    </td>
                                    <td>{{ $concert->artist }}</td>
                                    <td class="text-end">
                                        <strong>${{ number_format($concert->revenue, 2) }}</strong>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge bg-info">{{ $concert->booking_count }}</span>
                                    </td>
                                    <td class="text-end">
                                        ${{ number_format($concert->revenue / $concert->booking_count, 2) }}
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue by Status Chart
    @if($revenueStats['revenue_by_status']->count() > 0)
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusData = @json($revenueStats['revenue_by_status']);
    
    const statusLabels = Object.keys(statusData).map(status => status.charAt(0).toUpperCase() + status.slice(1));
    const statusValues = Object.values(statusData);
    const statusColors = ['#28a745', '#ffc107', '#dc3545', '#17a2b8'];
    
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusValues,
                backgroundColor: statusColors,
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': $' + context.parsed.toLocaleString() + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
    @endif
    
    // Monthly Revenue Chart
    @if($monthlyRevenue->count() > 0)
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyData = @json($monthlyRevenue);
    
    const monthlyLabels = monthlyData.map(item => {
        const date = new Date(item.month + '-01');
        return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
    });
    
    const monthlyRevenues = monthlyData.map(item => parseFloat(item.revenue));
    
    new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Revenue ($)',
                data: monthlyRevenues,
                backgroundColor: 'rgba(40, 167, 69, 0.8)',
                borderColor: 'rgb(40, 167, 69)',
                borderWidth: 1
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
    @endif
});
</script>
@endpush





