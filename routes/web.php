<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ConcertController;
use App\Http\Controllers\Admin\AccommodationController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminReportsController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\EventController;
use App\Http\Controllers\Public\AccommodationController as PublicAccommodationController;
use App\Http\Controllers\Public\BookingController;
use App\Http\Controllers\Public\DashboardController;
use App\Http\Controllers\Public\HelpController;
use App\Http\Controllers\Public\PagesController;
use App\Http\Controllers\PaymentController;

// Admin Login Routes (must be before admin.* middleware routes)
Route::prefix('admin')->name('admin.')->middleware('admin.guest')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'create'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'store'])->name('login.store');
});

// Admin Logout Route
Route::post('/admin/logout', [AdminLoginController::class, 'destroy'])
    ->middleware('admin')
    ->name('admin.logout');

// Public Pages
Route::get('/', [HomeController::class, 'index'])->name('public.home');
Route::get('/about', function() { return view('public.pages.about'); })->name('public.about');
Route::get('/contact', function() { return view('public.pages.contact'); })->name('public.contact');
Route::get('/refund', function() { return view('public.pages.refund'); })->name('public.refund');
Route::get('/terms', function() { return view('public.pages.terms'); })->name('public.terms');
Route::get('/faq', [HelpController::class, 'faq'])->name('public.faq');

// Event Routes
Route::prefix('events')->name('public.events.')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('index');
    Route::get('/{event}', [EventController::class, 'show'])->name('show');
});

// Accommodation Routes
Route::prefix('accommodations')->name('public.accommodations.')->group(function () {
    Route::get('/', [PublicAccommodationController::class, 'index'])->name('index');
    Route::get('/{accommodation}', [PublicAccommodationController::class, 'show'])->name('show');
});

// Cart Routes - Simple and Clean
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [BookingController::class, 'cart'])->name('index');
    Route::post('/add', [BookingController::class, 'addToCart'])->name('add');
    Route::delete('/remove/{index}', [BookingController::class, 'removeFromCart'])->name('remove');
    Route::delete('/clear', [BookingController::class, 'clearCart'])->name('clear');
});

// Booking Routes - For ticket booking flow
Route::prefix('booking')->name('public.booking.')->group(function () {
    Route::get('/accommodation', [BookingController::class, 'accommodation'])->name('accommodation');
    Route::post('/accommodation/{accommodation}', [BookingController::class, 'addAccommodation'])->name('add-accommodation');
    Route::get('/checkout', [BookingController::class, 'checkout'])->name('checkout');
    Route::post('/process', [BookingController::class, 'processBooking'])->name('process');
    Route::get('/confirmation/{booking}', [BookingController::class, 'confirmation'])->name('confirmation');
    Route::get('/confirmation', [BookingController::class, 'confirmationFromSession'])->name('confirmation.session');
    Route::get('/{event}', [BookingController::class, 'show'])->name('show');
});

// Payment Routes
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/{booking}', [PaymentController::class, 'show'])->name('show');
    Route::post('/{booking}/process', [PaymentController::class, 'process'])->name('process');
    Route::post('/calculate-fees', [PaymentController::class, 'calculateFees'])->name('calculate-fees');
    Route::post('/mpesa/callback', [PaymentController::class, 'mpesaCallback'])->name('mpesa.callback');
});

// Debug accommodation route
Route::get('/debug-accommodations', function () {
    try {
        $accommodations = \App\Models\Accommodation::active()->get();
        $allAccommodations = \App\Models\Accommodation::all();
        
        return response()->json([
            'total_accommodations' => $allAccommodations->count(),
            'active_accommodations' => $accommodations->count(),
            'all_accommodations' => $allAccommodations->map(function($acc) {
                return [
                    'id' => $acc->id,
                    'name' => $acc->name,
                    'status' => $acc->status,
                    'city' => $acc->city
                ];
            }),
            'active_accommodations_data' => $accommodations->map(function($acc) {
                return [
                    'id' => $acc->id,
                    'name' => $acc->name,
                    'status' => $acc->status,
                    'city' => $acc->city
                ];
            })
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
    }
})->name('debug.accommodations');

// Help Routes
Route::prefix('help')->name('public.help.')->group(function () {
    Route::get('/', [HelpController::class, 'index'])->name('index');
    Route::get('/contact', [HelpController::class, 'contact'])->name('contact');
    Route::post('/contact', [HelpController::class, 'submitContact'])->name('submit-contact');
});

// Support Pages Routes
Route::prefix('pages')->name('public.pages.')->group(function () {
    Route::get('/faq', [PagesController::class, 'faq'])->name('faq');
    Route::get('/terms', [PagesController::class, 'terms'])->name('terms');
    Route::get('/privacy', [PagesController::class, 'privacy'])->name('privacy');
    Route::get('/refund', [PagesController::class, 'refund'])->name('refund');
});

// User Dashboard Routes
Route::prefix('dashboard')->name('public.dashboard.')->middleware('auth:web')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/bookings', [DashboardController::class, 'bookings'])->name('bookings');
    Route::get('/bookings/{booking}', [DashboardController::class, 'bookingDetails'])->name('booking-details');
    Route::get('/bookings/{booking}/ticket', [DashboardController::class, 'downloadTicket'])->name('download-ticket');
    Route::post('/bookings/{booking}/cancel', [DashboardController::class, 'cancelBooking'])->name('cancel-booking');
    Route::get('/payments', [DashboardController::class, 'payments'])->name('payments');
    Route::get('/payments/{paymentId}/receipt', [DashboardController::class, 'paymentReceipt'])->name('payment-receipt');
    Route::get('/payments/{paymentId}/invoice', [DashboardController::class, 'paymentInvoice'])->name('payment-invoice');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('update-profile');
    Route::post('/profile/password', [DashboardController::class, 'updatePassword'])->name('update-password');
    Route::get('/support', [DashboardController::class, 'support'])->name('support');
    Route::post('/support', [DashboardController::class, 'submitSupport'])->name('submit-support');
    Route::get('/notifications', [DashboardController::class, 'notifications'])->name('notifications');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Event Routes
    Route::resource('events', ConcertController::class)->parameters([
        'events' => 'concert'
    ]);
    Route::patch('/events/{concert}/toggle-featured', [ConcertController::class, 'toggleFeatured'])->name('events.toggle-featured');
    Route::patch('/events/{concert}/status', [ConcertController::class, 'updateStatus'])->name('events.update-status');
    Route::get('/events/export', [ConcertController::class, 'export'])->name('events.export');
    
    // Accommodation Routes
    Route::resource('accommodations', AccommodationController::class);
    Route::patch('/accommodations/{accommodation}/toggle-featured', [AccommodationController::class, 'toggleFeatured'])->name('accommodations.toggle-featured');
    Route::patch('/accommodations/{accommodation}/status', [AccommodationController::class, 'updateStatus'])->name('accommodations.update-status');
    
    // Booking Routes
    Route::resource('bookings', AdminBookingController::class);
    Route::patch('/bookings/{booking}/confirm', [AdminBookingController::class, 'confirm'])->name('bookings.confirm');
    Route::patch('/bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');
    
    // User Routes
    Route::resource('users', UserController::class)->except(['create', 'store']);
    Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
    Route::patch('/users/{user}/verify-email', [UserController::class, 'verifyEmail'])->name('users.verify-email');
    Route::post('/users/{user}/send-password-reset', [UserController::class, 'sendPasswordReset'])->name('users.send-password-reset');
    Route::get('/users/statistics', [UserController::class, 'statistics'])->name('users.statistics');
    
    // Settings Routes
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [AdminSettingsController::class, 'index'])->name('index');
        Route::get('/general', [AdminSettingsController::class, 'general'])->name('general');
        Route::post('/general', [AdminSettingsController::class, 'updateGeneral'])->name('general.update');
        Route::get('/email', [AdminSettingsController::class, 'email'])->name('email');
        Route::post('/email', [AdminSettingsController::class, 'updateEmail'])->name('email.update');
        Route::get('/booking', [AdminSettingsController::class, 'booking'])->name('booking');
        Route::post('/booking', [AdminSettingsController::class, 'updateBooking'])->name('booking.update');
        Route::get('/payment', [AdminSettingsController::class, 'payment'])->name('payment');
        Route::post('/payment', [AdminSettingsController::class, 'updatePayment'])->name('payment.update');
        Route::get('/security', [AdminSettingsController::class, 'security'])->name('security');
        Route::post('/security', [AdminSettingsController::class, 'updateSecurity'])->name('security.update');
        Route::post('/test-email', [AdminSettingsController::class, 'testEmail'])->name('test-email');
    });
    
    // Reports Routes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [AdminReportsController::class, 'index'])->name('index');
        Route::get('/bookings', [AdminReportsController::class, 'bookings'])->name('bookings');
        Route::get('/events', [AdminReportsController::class, 'events'])->name('events');
        Route::get('/revenue', [AdminReportsController::class, 'revenue'])->name('revenue');
        Route::get('/users', [AdminReportsController::class, 'users'])->name('users');
        Route::get('/export-bookings', [AdminReportsController::class, 'exportBookings'])->name('export-bookings');
    });
    
    // Admin Payment Routes
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', [AdminPaymentController::class, 'index'])->name('index');
        Route::get('/{transactionId}/details', [AdminPaymentController::class, 'details'])->name('details');
        Route::get('/{transactionId}/receipt', [AdminPaymentController::class, 'receipt'])->name('receipt');
        Route::get('/{transactionId}/info', [AdminPaymentController::class, 'info'])->name('info');
        Route::post('/{transactionId}/complete', [AdminPaymentController::class, 'markAsCompleted'])->name('complete');
        Route::get('/export', [AdminPaymentController::class, 'export'])->name('export');
    });
    
    Route::post('/bookings/{booking}/refund', [PaymentController::class, 'refund'])->name('bookings.refund');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// M-Pesa Debug Routes
Route::get('/debug/mpesa', [App\Http\Controllers\MpesaDebugController::class, 'index']);
Route::post('/debug/mpesa/test', [App\Http\Controllers\MpesaDebugController::class, 'test'])->name('debug.mpesa.test');

require __DIR__.'/auth.php';
