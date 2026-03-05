@extends('admin.layouts.app')

@section('title', 'Security Settings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-shield-alt me-2"></i>Security Settings</h2>
    <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Settings
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Security Configuration</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings.security.update') }}">
                    @csrf
                    
                    <div class="row">
                        <!-- Session Timeout -->
                        <div class="col-md-6 mb-3">
                            <label for="session_timeout" class="form-label">Session Timeout (Minutes) *</label>
                            <input type="number" 
                                   name="session_timeout" 
                                   id="session_timeout" 
                                   value="{{ old('session_timeout', $settings['session_timeout']) }}"
                                   class="form-control @error('session_timeout') is-invalid @enderror" 
                                   min="5" 
                                   max="480"
                                   required>
                            @error('session_timeout')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">How long users stay logged in (5-480 minutes)</div>
                        </div>

                        <!-- Max Login Attempts -->
                        <div class="col-md-6 mb-3">
                            <label for="max_login_attempts" class="form-label">Max Login Attempts *</label>
                            <input type="number" 
                                   name="max_login_attempts" 
                                   id="max_login_attempts" 
                                   value="{{ old('max_login_attempts', $settings['max_login_attempts']) }}"
                                   class="form-control @error('max_login_attempts') is-invalid @enderror" 
                                   min="3" 
                                   max="10"
                                   required>
                            @error('max_login_attempts')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Failed attempts before account lockout (3-10)</div>
                        </div>

                        <!-- Lockout Duration -->
                        <div class="col-md-6 mb-3">
                            <label for="lockout_duration" class="form-label">Lockout Duration (Minutes) *</label>
                            <input type="number" 
                                   name="lockout_duration" 
                                   id="lockout_duration" 
                                   value="{{ old('lockout_duration', $settings['lockout_duration']) }}"
                                   class="form-control @error('lockout_duration') is-invalid @enderror" 
                                   min="5" 
                                   max="60"
                                   required>
                            @error('lockout_duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">How long account stays locked (5-60 minutes)</div>
                        </div>

                        <!-- Password Min Length -->
                        <div class="col-md-6 mb-3">
                            <label for="password_min_length" class="form-label">Minimum Password Length *</label>
                            <input type="number" 
                                   name="password_min_length" 
                                   id="password_min_length" 
                                   value="{{ old('password_min_length', $settings['password_min_length']) }}"
                                   class="form-control @error('password_min_length') is-invalid @enderror" 
                                   min="6" 
                                   max="20"
                                   required>
                            @error('password_min_length')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Minimum characters required for passwords (6-20)</div>
                        </div>
                    </div>

                    <hr>

                    <h6 class="mb-3">Advanced Security Options</h6>
                    
                    <div class="row">
                        <!-- Require 2FA -->
                        <div class="col-12 mb-3">
                            <div class="form-check">
                                <input type="checkbox" 
                                       name="require_2fa" 
                                       id="require_2fa" 
                                       class="form-check-input"
                                       {{ old('require_2fa', $settings['require_2fa']) ? 'checked' : '' }}>
                                <label for="require_2fa" class="form-check-label">
                                    <strong>Require Two-Factor Authentication</strong>
                                    <div class="form-text">All admin users must enable 2FA for enhanced security</div>
                                </label>
                            </div>
                        </div>

                        <!-- IP Whitelist -->
                        <div class="col-12 mb-3">
                            <label for="ip_whitelist" class="form-label">IP Address Whitelist</label>
                            <textarea name="ip_whitelist" 
                                      id="ip_whitelist" 
                                      rows="4"
                                      class="form-control @error('ip_whitelist') is-invalid @enderror"
                                      placeholder="192.168.1.1&#10;10.0.0.1&#10;203.0.113.0/24">{{ old('ip_whitelist', $settings['ip_whitelist']) }}</textarea>
                            @error('ip_whitelist')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">One IP address or CIDR block per line. Leave empty to allow all IPs.</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Security Status & Help -->
    <div class="col-lg-4">
        <!-- Security Status -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Security Status</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Session Security</span>
                    <span class="badge bg-success">Active</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Login Protection</span>
                    <span class="badge bg-success">Enabled</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Password Policy</span>
                    <span class="badge bg-success">Strong</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Two-Factor Auth</span>
                    <span class="badge bg-{{ $settings['require_2fa'] ? 'success' : 'warning' }}">
                        {{ $settings['require_2fa'] ? 'Required' : 'Optional' }}
                    </span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>IP Restrictions</span>
                    <span class="badge bg-{{ $settings['ip_whitelist'] ? 'info' : 'secondary' }}">
                        {{ $settings['ip_whitelist'] ? 'Restricted' : 'Open' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Security Help -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Security Best Practices</h5>
            </div>
            <div class="card-body">
                <h6>Session Management</h6>
                <ul class="list-unstyled small">
                    <li><i class="fas fa-check text-success me-2"></i>Shorter timeouts = more security</li>
                    <li><i class="fas fa-check text-success me-2"></i>Longer timeouts = better UX</li>
                    <li><i class="fas fa-info-circle text-info me-2"></i>Balance security with usability</li>
                </ul>

                <h6 class="mt-3">Login Protection</h6>
                <ul class="list-unstyled small">
                    <li><i class="fas fa-check text-success me-2"></i>3-5 attempts is usually sufficient</li>
                    <li><i class="fas fa-check text-success me-2"></i>15-30 minute lockouts prevent abuse</li>
                    <li><i class="fas fa-exclamation-triangle text-warning me-2"></i>Too strict may lock out legitimate users</li>
                </ul>

                <h6 class="mt-3">Password Policy</h6>
                <ul class="list-unstyled small">
                    <li><i class="fas fa-check text-success me-2"></i>8+ characters recommended</li>
                    <li><i class="fas fa-check text-success me-2"></i>Require mixed case and numbers</li>
                    <li><i class="fas fa-check text-success me-2"></i>Consider special characters</li>
                </ul>

                <h6 class="mt-3">IP Whitelist</h6>
                <ul class="list-unstyled small">
                    <li><i class="fas fa-info-circle text-info me-2"></i>Use for office/admin access only</li>
                    <li><i class="fas fa-info-circle text-info me-2"></i>Supports CIDR notation (192.168.1.0/24)</li>
                    <li><i class="fas fa-exclamation-triangle text-warning me-2"></i>Be careful with dynamic IPs</li>
                </ul>

                <div class="alert alert-danger mt-3">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Warning:</strong> Incorrect security settings may lock you out of the admin panel. Test changes carefully.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
