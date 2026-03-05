@extends('admin.layouts.app')

@section('title', 'Email Settings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-envelope me-2"></i>Email Settings</h2>
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
                <h5 class="card-title mb-0">SMTP Configuration</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings.email.update') }}">
                    @csrf
                    
                    <div class="row">
                        <!-- Mail Driver -->
                        <div class="col-md-6 mb-3">
                            <label for="mail_driver" class="form-label">Mail Driver *</label>
                            <select name="mail_driver" id="mail_driver" class="form-select @error('mail_driver') is-invalid @enderror" required>
                                <option value="smtp" {{ old('mail_driver', $settings['mail_driver']) == 'smtp' ? 'selected' : '' }}>SMTP</option>
                                <option value="mailgun" {{ old('mail_driver', $settings['mail_driver']) == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                                <option value="ses" {{ old('mail_driver', $settings['mail_driver']) == 'ses' ? 'selected' : '' }}>Amazon SES</option>
                                <option value="mail" {{ old('mail_driver', $settings['mail_driver']) == 'mail' ? 'selected' : '' }}>PHP Mail</option>
                            </select>
                            @error('mail_driver')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Mail Host -->
                        <div class="col-md-6 mb-3">
                            <label for="mail_host" class="form-label">SMTP Host *</label>
                            <input type="text" 
                                   name="mail_host" 
                                   id="mail_host" 
                                   value="{{ old('mail_host', $settings['mail_host']) }}"
                                   class="form-control @error('mail_host') is-invalid @enderror" 
                                   placeholder="smtp.gmail.com"
                                   required>
                            @error('mail_host')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Mail Port -->
                        <div class="col-md-6 mb-3">
                            <label for="mail_port" class="form-label">SMTP Port *</label>
                            <input type="number" 
                                   name="mail_port" 
                                   id="mail_port" 
                                   value="{{ old('mail_port', $settings['mail_port']) }}"
                                   class="form-control @error('mail_port') is-invalid @enderror" 
                                   placeholder="587"
                                   required>
                            @error('mail_port')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Mail Encryption -->
                        <div class="col-md-6 mb-3">
                            <label for="mail_encryption" class="form-label">Encryption</label>
                            <select name="mail_encryption" id="mail_encryption" class="form-select @error('mail_encryption') is-invalid @enderror">
                                <option value="" {{ old('mail_encryption', $settings['mail_encryption']) == '' ? 'selected' : '' }}>None</option>
                                <option value="tls" {{ old('mail_encryption', $settings['mail_encryption']) == 'tls' ? 'selected' : '' }}>TLS</option>
                                <option value="ssl" {{ old('mail_encryption', $settings['mail_encryption']) == 'ssl' ? 'selected' : '' }}>SSL</option>
                            </select>
                            @error('mail_encryption')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Mail Username -->
                        <div class="col-md-6 mb-3">
                            <label for="mail_username" class="form-label">SMTP Username</label>
                            <input type="text" 
                                   name="mail_username" 
                                   id="mail_username" 
                                   value="{{ old('mail_username', $settings['mail_username']) }}"
                                   class="form-control @error('mail_username') is-invalid @enderror"
                                   placeholder="your-email@gmail.com">
                            @error('mail_username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Mail Password -->
                        <div class="col-md-6 mb-3">
                            <label for="mail_password" class="form-label">SMTP Password</label>
                            <input type="password" 
                                   name="mail_password" 
                                   id="mail_password" 
                                   value="{{ old('mail_password', $settings['mail_password']) }}"
                                   class="form-control @error('mail_password') is-invalid @enderror"
                                   placeholder="Your email password or app password">
                            @error('mail_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    <h6 class="mb-3">Email From Settings</h6>
                    
                    <div class="row">
                        <!-- From Address -->
                        <div class="col-md-6 mb-3">
                            <label for="mail_from_address" class="form-label">From Email Address *</label>
                            <input type="email" 
                                   name="mail_from_address" 
                                   id="mail_from_address" 
                                   value="{{ old('mail_from_address', $settings['mail_from_address']) }}"
                                   class="form-control @error('mail_from_address') is-invalid @enderror" 
                                   placeholder="noreply@yoursite.com"
                                   required>
                            @error('mail_from_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- From Name -->
                        <div class="col-md-6 mb-3">
                            <label for="mail_from_name" class="form-label">From Name *</label>
                            <input type="text" 
                                   name="mail_from_name" 
                                   id="mail_from_name" 
                                   value="{{ old('mail_from_name', $settings['mail_from_name']) }}"
                                   class="form-control @error('mail_from_name') is-invalid @enderror" 
                                   placeholder="Concert Booking System"
                                   required>
                            @error('mail_from_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-info" id="testEmailBtn">
                            <i class="fas fa-paper-plane me-2"></i>Test Email
                        </button>
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
                <h5 class="card-title mb-0">Email Configuration Help</h5>
            </div>
            <div class="card-body">
                <h6>Popular SMTP Settings</h6>
                <div class="accordion" id="smtpAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="gmailHeader">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#gmailCollapse">
                                Gmail
                            </button>
                        </h2>
                        <div id="gmailCollapse" class="accordion-collapse collapse" data-bs-parent="#smtpAccordion">
                            <div class="accordion-body">
                                <ul class="list-unstyled small">
                                    <li><strong>Host:</strong> smtp.gmail.com</li>
                                    <li><strong>Port:</strong> 587</li>
                                    <li><strong>Encryption:</strong> TLS</li>
                                    <li><strong>Note:</strong> Use App Password</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="outlookHeader">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#outlookCollapse">
                                Outlook/Hotmail
                            </button>
                        </h2>
                        <div id="outlookCollapse" class="accordion-collapse collapse" data-bs-parent="#smtpAccordion">
                            <div class="accordion-body">
                                <ul class="list-unstyled small">
                                    <li><strong>Host:</strong> smtp-mail.outlook.com</li>
                                    <li><strong>Port:</strong> 587</li>
                                    <li><strong>Encryption:</strong> TLS</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning mt-3">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Security Note:</strong> Never share your email credentials. Use app-specific passwords when possible.
                </div>

                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Test Email:</strong> Use the "Test Email" button to verify your configuration before saving.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Test Email Modal -->
<div class="modal fade" id="testEmailModal" tabindex="-1" aria-labelledby="testEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="testEmailModalLabel">Send Test Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="testEmailForm">
                    <div class="mb-3">
                        <label for="test_email" class="form-label">Test Email Address</label>
                        <input type="email" class="form-control" id="test_email" name="test_email" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="sendTestEmail">Send Test Email</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const testEmailBtn = document.getElementById('testEmailBtn');
    const testEmailModal = new bootstrap.Modal(document.getElementById('testEmailModal'));
    const sendTestEmailBtn = document.getElementById('sendTestEmail');
    const testEmailForm = document.getElementById('testEmailForm');

    testEmailBtn.addEventListener('click', function() {
        testEmailModal.show();
    });

    sendTestEmailBtn.addEventListener('click', function() {
        const formData = new FormData(testEmailForm);
        
        sendTestEmailBtn.disabled = true;
        sendTestEmailBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';

        fetch('{{ route("admin.settings.test-email") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                test_email: formData.get('test_email')
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Test email sent successfully!');
                testEmailModal.hide();
            } else {
                alert('Failed to send test email: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error sending test email: ' + error.message);
        })
        .finally(() => {
            sendTestEmailBtn.disabled = false;
            sendTestEmailBtn.innerHTML = 'Send Test Email';
        });
    });
});
</script>
@endpush
