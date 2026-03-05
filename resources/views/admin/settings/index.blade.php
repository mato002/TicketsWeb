@extends('admin.layouts.app')

@section('title', 'Settings Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-cog me-2"></i>Settings Dashboard</h2>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <!-- General Settings -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-globe fa-3x text-primary"></i>
                </div>
                <h5 class="card-title">General Settings</h5>
                <p class="card-text text-muted">Configure site name, description, timezone, and other basic settings.</p>
                <a href="{{ route('admin.settings.general') }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Configure
                </a>
            </div>
        </div>
    </div>

    <!-- Email Settings -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-envelope fa-3x text-info"></i>
                </div>
                <h5 class="card-title">Email Settings</h5>
                <p class="card-text text-muted">Configure SMTP settings, email templates, and notification preferences.</p>
                <a href="{{ route('admin.settings.email') }}" class="btn btn-info">
                    <i class="fas fa-edit me-2"></i>Configure
                </a>
            </div>
        </div>
    </div>

    <!-- Booking Settings -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-ticket-alt fa-3x text-warning"></i>
                </div>
                <h5 class="card-title">Booking Settings</h5>
                <p class="card-text text-muted">Configure booking rules, cancellation policies, and ticket limits.</p>
                <a href="{{ route('admin.settings.booking') }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>Configure
                </a>
            </div>
        </div>
    </div>

    <!-- Payment Settings -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-credit-card fa-3x text-success"></i>
                </div>
                <h5 class="card-title">Payment Settings</h5>
                <p class="card-text text-muted">Configure payment gateways, tax rates, and processing fees.</p>
                <a href="{{ route('admin.settings.payment') }}" class="btn btn-success">
                    <i class="fas fa-edit me-2"></i>Configure
                </a>
            </div>
        </div>
    </div>

    <!-- Security Settings -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-shield-alt fa-3x text-danger"></i>
                </div>
                <h5 class="card-title">Security Settings</h5>
                <p class="card-text text-muted">Configure security policies, session timeouts, and access controls.</p>
                <a href="{{ route('admin.settings.security') }}" class="btn btn-danger">
                    <i class="fas fa-edit me-2"></i>Configure
                </a>
            </div>
        </div>
    </div>

    <!-- System Information -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-info-circle fa-3x text-secondary"></i>
                </div>
                <h5 class="card-title">System Information</h5>
                <p class="card-text text-muted">View system status, version information, and performance metrics.</p>
                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#systemInfoModal">
                    <i class="fas fa-info me-2"></i>View Info
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Quick Settings Overview -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Settings Overview</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center">
                            <h6 class="text-muted">Site Name</h6>
                            <p class="fw-bold">{{ $settings['general']['site_name'] }}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h6 class="text-muted">Currency</h6>
                            <p class="fw-bold">{{ $settings['general']['currency'] }}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h6 class="text-muted">Max Tickets</h6>
                            <p class="fw-bold">{{ $settings['booking']['max_tickets_per_booking'] }}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h6 class="text-muted">Payment Method</h6>
                            <p class="fw-bold text-capitalize">{{ $settings['payment']['payment_method'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- System Information Modal -->
<div class="modal fade" id="systemInfoModal" tabindex="-1" aria-labelledby="systemInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="systemInfoModalLabel">System Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Application Information</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Laravel Version:</strong></td>
                                <td>{{ app()->version() }}</td>
                            </tr>
                            <tr>
                                <td><strong>PHP Version:</strong></td>
                                <td>{{ PHP_VERSION }}</td>
                            </tr>
                            <tr>
                                <td><strong>Environment:</strong></td>
                                <td><span class="badge bg-{{ app()->environment() === 'production' ? 'success' : 'warning' }}">{{ app()->environment() }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Debug Mode:</strong></td>
                                <td><span class="badge bg-{{ config('app.debug') ? 'danger' : 'success' }}">{{ config('app.debug') ? 'Enabled' : 'Disabled' }}</span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Server Information</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Server Software:</strong></td>
                                <td>{{ $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Operating System:</strong></td>
                                <td>{{ PHP_OS }}</td>
                            </tr>
                            <tr>
                                <td><strong>Memory Limit:</strong></td>
                                <td>{{ ini_get('memory_limit') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Max Execution Time:</strong></td>
                                <td>{{ ini_get('max_execution_time') }}s</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
