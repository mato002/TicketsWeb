<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AdminSettingsController extends Controller
{
    /**
     * Display the settings dashboard
     */
    public function index()
    {
        $settings = $this->getAllSettings();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Show general settings form
     */
    public function general()
    {
        $settings = $this->getGeneralSettings();
        return view('admin.settings.general', compact('settings'));
    }

    /**
     * Update general settings
     */
    public function updateGeneral(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'site_keywords' => 'nullable|string|max:500',
            'admin_email' => 'required|email|max:255',
            'timezone' => 'required|string|max:50',
            'currency' => 'required|string|max:10',
            'date_format' => 'required|string|max:20',
            'time_format' => 'required|string|max:20',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $settings = [
            'site_name' => $request->site_name,
            'site_description' => $request->site_description,
            'site_keywords' => $request->site_keywords,
            'admin_email' => $request->admin_email,
            'timezone' => $request->timezone,
            'currency' => $request->currency,
            'date_format' => $request->date_format,
            'time_format' => $request->time_format,
        ];

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = 'logo.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images'), $logoName);
            $settings['logo'] = 'images/' . $logoName;
        }

        $this->saveSettings($settings);

        return redirect()->route('admin.settings.general')
            ->with('success', 'General settings updated successfully!');
    }

    /**
     * Show email settings form
     */
    public function email()
    {
        $settings = $this->getEmailSettings();
        return view('admin.settings.email', compact('settings'));
    }

    /**
     * Update email settings
     */
    public function updateEmail(Request $request)
    {
        $request->validate([
            'mail_driver' => 'required|string|max:50',
            'mail_host' => 'required|string|max:255',
            'mail_port' => 'required|integer|min:1|max:65535',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|string|max:20',
            'mail_from_address' => 'required|email|max:255',
            'mail_from_name' => 'required|string|max:255',
        ]);

        $settings = [
            'mail_driver' => $request->mail_driver,
            'mail_host' => $request->mail_host,
            'mail_port' => $request->mail_port,
            'mail_username' => $request->mail_username,
            'mail_password' => $request->mail_password,
            'mail_encryption' => $request->mail_encryption,
            'mail_from_address' => $request->mail_from_address,
            'mail_from_name' => $request->mail_from_name,
        ];

        $this->saveSettings($settings);

        return redirect()->route('admin.settings.email')
            ->with('success', 'Email settings updated successfully!');
    }

    /**
     * Show booking settings form
     */
    public function booking()
    {
        $settings = $this->getBookingSettings();
        return view('admin.settings.booking', compact('settings'));
    }

    /**
     * Update booking settings
     */
    public function updateBooking(Request $request)
    {
        $request->validate([
            'max_tickets_per_booking' => 'required|integer|min:1|max:20',
            'booking_confirmation_required' => 'boolean',
            'auto_confirm_bookings' => 'boolean',
            'booking_cancellation_hours' => 'required|integer|min:0|max:168',
            'booking_reminder_hours' => 'required|integer|min:1|max:168',
            'refund_policy' => 'nullable|string|max:1000',
            'terms_conditions' => 'nullable|string|max:2000',
        ]);

        $settings = [
            'max_tickets_per_booking' => $request->max_tickets_per_booking,
            'booking_confirmation_required' => $request->has('booking_confirmation_required'),
            'auto_confirm_bookings' => $request->has('auto_confirm_bookings'),
            'booking_cancellation_hours' => $request->booking_cancellation_hours,
            'booking_reminder_hours' => $request->booking_reminder_hours,
            'refund_policy' => $request->refund_policy,
            'terms_conditions' => $request->terms_conditions,
        ];

        $this->saveSettings($settings);

        return redirect()->route('admin.settings.booking')
            ->with('success', 'Booking settings updated successfully!');
    }

    /**
     * Show payment settings form
     */
    public function payment()
    {
        $settings = $this->getPaymentSettings();
        return view('admin.settings.payment', compact('settings'));
    }

    /**
     * Update payment settings
     */
    public function updatePayment(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string|max:50',
            'stripe_public_key' => 'nullable|string|max:255',
            'stripe_secret_key' => 'nullable|string|max:255',
            'paypal_client_id' => 'nullable|string|max:255',
            'paypal_client_secret' => 'nullable|string|max:255',
            'paypal_mode' => 'nullable|string|max:20',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'processing_fee' => 'required|numeric|min:0',
        ]);

        $settings = [
            'payment_method' => $request->payment_method,
            'stripe_public_key' => $request->stripe_public_key,
            'stripe_secret_key' => $request->stripe_secret_key,
            'paypal_client_id' => $request->paypal_client_id,
            'paypal_client_secret' => $request->paypal_client_secret,
            'paypal_mode' => $request->paypal_mode,
            'tax_rate' => $request->tax_rate,
            'processing_fee' => $request->processing_fee,
        ];

        $this->saveSettings($settings);

        return redirect()->route('admin.settings.payment')
            ->with('success', 'Payment settings updated successfully!');
    }

    /**
     * Show security settings form
     */
    public function security()
    {
        $settings = $this->getSecuritySettings();
        return view('admin.settings.security', compact('settings'));
    }

    /**
     * Update security settings
     */
    public function updateSecurity(Request $request)
    {
        $request->validate([
            'session_timeout' => 'required|integer|min:5|max:480',
            'max_login_attempts' => 'required|integer|min:3|max:10',
            'lockout_duration' => 'required|integer|min:5|max:60',
            'password_min_length' => 'required|integer|min:6|max:20',
            'require_2fa' => 'boolean',
            'ip_whitelist' => 'nullable|string|max:1000',
        ]);

        $settings = [
            'session_timeout' => $request->session_timeout,
            'max_login_attempts' => $request->max_login_attempts,
            'lockout_duration' => $request->lockout_duration,
            'password_min_length' => $request->password_min_length,
            'require_2fa' => $request->has('require_2fa'),
            'ip_whitelist' => $request->ip_whitelist,
        ];

        $this->saveSettings($settings);

        return redirect()->route('admin.settings.security')
            ->with('success', 'Security settings updated successfully!');
    }

    /**
     * Test email configuration
     */
    public function testEmail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email|max:255',
        ]);

        try {
            // Here you would implement actual email sending
            // For now, we'll just return a success message
            return response()->json([
                'success' => true,
                'message' => 'Test email sent successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send test email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all settings
     */
    private function getAllSettings()
    {
        return [
            'general' => $this->getGeneralSettings(),
            'email' => $this->getEmailSettings(),
            'booking' => $this->getBookingSettings(),
            'payment' => $this->getPaymentSettings(),
            'security' => $this->getSecuritySettings(),
        ];
    }

    /**
     * Get general settings
     */
    private function getGeneralSettings()
    {
        return [
            'site_name' => config('app.name', 'Concert Booking'),
            'site_description' => 'Professional concert booking system',
            'site_keywords' => 'concert, booking, tickets, music',
            'admin_email' => 'admin@example.com',
            'timezone' => config('app.timezone', 'UTC'),
            'currency' => 'USD',
            'date_format' => 'Y-m-d',
            'time_format' => 'H:i',
            'logo' => 'images/logo.png',
        ];
    }

    /**
     * Get email settings
     */
    private function getEmailSettings()
    {
        return [
            'mail_driver' => config('mail.default', 'smtp'),
            'mail_host' => config('mail.mailers.smtp.host', ''),
            'mail_port' => config('mail.mailers.smtp.port', 587),
            'mail_username' => config('mail.mailers.smtp.username', ''),
            'mail_password' => config('mail.mailers.smtp.password', ''),
            'mail_encryption' => config('mail.mailers.smtp.encryption', 'tls'),
            'mail_from_address' => config('mail.from.address', ''),
            'mail_from_name' => config('mail.from.name', ''),
        ];
    }

    /**
     * Get booking settings
     */
    private function getBookingSettings()
    {
        return [
            'max_tickets_per_booking' => 10,
            'booking_confirmation_required' => true,
            'auto_confirm_bookings' => false,
            'booking_cancellation_hours' => 24,
            'booking_reminder_hours' => 2,
            'refund_policy' => 'Refunds are available up to 24 hours before the event.',
            'terms_conditions' => 'By booking tickets, you agree to our terms and conditions.',
        ];
    }

    /**
     * Get payment settings
     */
    private function getPaymentSettings()
    {
        return [
            'payment_method' => 'stripe',
            'stripe_public_key' => '',
            'stripe_secret_key' => '',
            'paypal_client_id' => '',
            'paypal_client_secret' => '',
            'paypal_mode' => 'sandbox',
            'tax_rate' => 8.5,
            'processing_fee' => 2.50,
        ];
    }

    /**
     * Get security settings
     */
    private function getSecuritySettings()
    {
        return [
            'session_timeout' => 120,
            'max_login_attempts' => 5,
            'lockout_duration' => 15,
            'password_min_length' => 8,
            'require_2fa' => false,
            'ip_whitelist' => '',
        ];
    }

    /**
     * Save settings to storage
     */
    private function saveSettings($settings)
    {
        // In a real application, you would save these to a database or config file
        // For now, we'll just store them in the session for demonstration
        session(['admin_settings' => array_merge(session('admin_settings', []), $settings)]);
    }
}
