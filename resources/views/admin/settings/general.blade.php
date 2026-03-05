@extends('admin.layouts.app')

@section('title', 'General Settings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-globe me-2"></i>General Settings</h2>
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
                <h5 class="card-title mb-0">Site Configuration</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings.general.update') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <!-- Site Name -->
                        <div class="col-md-6 mb-3">
                            <label for="site_name" class="form-label">Site Name *</label>
                            <input type="text" 
                                   name="site_name" 
                                   id="site_name" 
                                   value="{{ old('site_name', $settings['site_name']) }}"
                                   class="form-control @error('site_name') is-invalid @enderror" 
                                   required>
                            @error('site_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Admin Email -->
                        <div class="col-md-6 mb-3">
                            <label for="admin_email" class="form-label">Admin Email *</label>
                            <input type="email" 
                                   name="admin_email" 
                                   id="admin_email" 
                                   value="{{ old('admin_email', $settings['admin_email']) }}"
                                   class="form-control @error('admin_email') is-invalid @enderror" 
                                   required>
                            @error('admin_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Site Description -->
                        <div class="col-12 mb-3">
                            <label for="site_description" class="form-label">Site Description</label>
                            <textarea name="site_description" 
                                      id="site_description" 
                                      rows="3"
                                      class="form-control @error('site_description') is-invalid @enderror"
                                      placeholder="Brief description of your site...">{{ old('site_description', $settings['site_description']) }}</textarea>
                            @error('site_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Site Keywords -->
                        <div class="col-12 mb-3">
                            <label for="site_keywords" class="form-label">Site Keywords</label>
                            <input type="text" 
                                   name="site_keywords" 
                                   id="site_keywords" 
                                   value="{{ old('site_keywords', $settings['site_keywords']) }}"
                                   class="form-control @error('site_keywords') is-invalid @enderror"
                                   placeholder="concert, booking, tickets, music">
                            @error('site_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Separate keywords with commas</div>
                        </div>

                        <!-- Logo Upload -->
                        <div class="col-12 mb-3">
                            <label for="logo" class="form-label">Site Logo</label>
                            <input type="file" 
                                   name="logo" 
                                   id="logo" 
                                   class="form-control @error('logo') is-invalid @enderror"
                                   accept="image/*">
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($settings['logo'] && file_exists(public_path($settings['logo'])))
                                <div class="mt-2">
                                    <img src="{{ asset($settings['logo']) }}" alt="Current Logo" class="img-thumbnail" style="max-width: 200px;">
                                    <p class="text-muted mt-1">Current logo</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <h6 class="mb-3">Regional Settings</h6>
                    
                    <div class="row">
                        <!-- Timezone -->
                        <div class="col-md-6 mb-3">
                            <label for="timezone" class="form-label">Timezone *</label>
                            <select name="timezone" id="timezone" class="form-select @error('timezone') is-invalid @enderror" required>
                                <option value="">Select Timezone</option>
                                <option value="UTC" {{ old('timezone', $settings['timezone']) == 'UTC' ? 'selected' : '' }}>UTC</option>
                                <option value="America/New_York" {{ old('timezone', $settings['timezone']) == 'America/New_York' ? 'selected' : '' }}>Eastern Time</option>
                                <option value="America/Chicago" {{ old('timezone', $settings['timezone']) == 'America/Chicago' ? 'selected' : '' }}>Central Time</option>
                                <option value="America/Denver" {{ old('timezone', $settings['timezone']) == 'America/Denver' ? 'selected' : '' }}>Mountain Time</option>
                                <option value="America/Los_Angeles" {{ old('timezone', $settings['timezone']) == 'America/Los_Angeles' ? 'selected' : '' }}>Pacific Time</option>
                                <option value="Europe/London" {{ old('timezone', $settings['timezone']) == 'Europe/London' ? 'selected' : '' }}>London</option>
                                <option value="Europe/Paris" {{ old('timezone', $settings['timezone']) == 'Europe/Paris' ? 'selected' : '' }}>Paris</option>
                                <option value="Asia/Tokyo" {{ old('timezone', $settings['timezone']) == 'Asia/Tokyo' ? 'selected' : '' }}>Tokyo</option>
                            </select>
                            @error('timezone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Currency -->
                        <div class="col-md-6 mb-3">
                            <label for="currency" class="form-label">Currency *</label>
                            <select name="currency" id="currency" class="form-select @error('currency') is-invalid @enderror" required>
                                <option value="">Select Currency</option>
                                <option value="USD" {{ old('currency', $settings['currency']) == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                <option value="EUR" {{ old('currency', $settings['currency']) == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                <option value="GBP" {{ old('currency', $settings['currency']) == 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                <option value="CAD" {{ old('currency', $settings['currency']) == 'CAD' ? 'selected' : '' }}>CAD - Canadian Dollar</option>
                                <option value="AUD" {{ old('currency', $settings['currency']) == 'AUD' ? 'selected' : '' }}>AUD - Australian Dollar</option>
                                <option value="JPY" {{ old('currency', $settings['currency']) == 'JPY' ? 'selected' : '' }}>JPY - Japanese Yen</option>
                            </select>
                            @error('currency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Date Format -->
                        <div class="col-md-6 mb-3">
                            <label for="date_format" class="form-label">Date Format *</label>
                            <select name="date_format" id="date_format" class="form-select @error('date_format') is-invalid @enderror" required>
                                <option value="Y-m-d" {{ old('date_format', $settings['date_format']) == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                                <option value="m/d/Y" {{ old('date_format', $settings['date_format']) == 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                                <option value="d/m/Y" {{ old('date_format', $settings['date_format']) == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                                <option value="M d, Y" {{ old('date_format', $settings['date_format']) == 'M d, Y' ? 'selected' : '' }}>Jan 1, 2024</option>
                            </select>
                            @error('date_format')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Time Format -->
                        <div class="col-md-6 mb-3">
                            <label for="time_format" class="form-label">Time Format *</label>
                            <select name="time_format" id="time_format" class="form-select @error('time_format') is-invalid @enderror" required>
                                <option value="H:i" {{ old('time_format', $settings['time_format']) == 'H:i' ? 'selected' : '' }}>24 Hour (14:30)</option>
                                <option value="h:i A" {{ old('time_format', $settings['time_format']) == 'h:i A' ? 'selected' : '' }}>12 Hour (2:30 PM)</option>
                            </select>
                            @error('time_format')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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

    <!-- Help Sidebar -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Help & Tips</h5>
            </div>
            <div class="card-body">
                <h6>Site Configuration</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success me-2"></i>Choose a descriptive site name</li>
                    <li><i class="fas fa-check text-success me-2"></i>Upload a logo (PNG, JPG, SVG)</li>
                    <li><i class="fas fa-check text-success me-2"></i>Set appropriate keywords for SEO</li>
                </ul>

                <h6 class="mt-3">Regional Settings</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success me-2"></i>Select your local timezone</li>
                    <li><i class="fas fa-check text-success me-2"></i>Choose your preferred currency</li>
                    <li><i class="fas fa-check text-success me-2"></i>Set date and time formats</li>
                </ul>

                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Note:</strong> Changes to these settings will affect how dates, times, and currencies are displayed throughout the system.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
