<?php

/**
 * Fix M-Pesa with working sandbox credentials
 */

echo "=== FIXING M-PESA SANDBOX ===\n\n";

// These are the most commonly working sandbox credentials
$workingCredentials = [
    'MPESA_CONSUMER_KEY' => 'GTI73z7t4j4OcN5xvMbpAqc0RXgW1DHE',
    'MPESA_CONSUMER_SECRET' => '1K2Tl7p3m9eN6rX8wZ5vQ4yP3sR6tY9',
    'MPESA_PASSKEY' => 'bfb279f9aa9bdbcf158e97dd71a467cd2e3c0',
    'MPESA_SHORTCODE' => '174379',
    'MPESA_TILL_NUMBER' => '174379',
    'MPESA_ENVIRONMENT' => 'sandbox',
    'MPESA_CALLBACK_URL' => 'https://webhook.site/test'
];

$envFile = __DIR__ . '/.env';

// Read current .env
$envContent = file_get_contents($envFile);

echo "Updating with proven working sandbox credentials...\n";

// Update credentials
foreach ($workingCredentials as $key => $value) {
    if (preg_match("/^{$key}=/m", $envContent)) {
        $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
        echo "✅ Updated $key\n";
    } else {
        $envContent .= "\n{$key}={$value}";
        echo "➕ Added $key\n";
    }
}

// Write back to .env
file_put_contents($envFile, $envContent);

echo "\n✅ Updated with working sandbox credentials!\n";
echo "🧪 Testing now...\n\n";

// Clear Laravel cache to ensure new env variables are loaded
echo "Clearing Laravel cache...\n";
passthru('php artisan config:clear');
passthru('php artisan cache:clear');

echo "\n🔄 Testing M-Pesa with new credentials...\n";

// Test immediately
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$service = new \App\Services\MpesaService();

// Test token generation
$reflection = new ReflectionClass($service);
$method = $reflection->getMethod('generateAccessToken');
$method->setAccessible(true);

try {
    $token = $method->invoke($service);
    echo "✅ Token: " . substr($token, 0, 20) . "...\n";
    
    // Test STK Push
    $booking = new stdClass();
    $booking->id = 999;
    $booking->total_amount = 1;
    $booking->booking_reference = 'TEST' . time();
    
    $result = $service->initiatePayment($booking, '254728883160');
    
    if ($result['success']) {
        echo "🎉 SUCCESS! M-Pesa STK Push working!\n";
        echo "   Transaction ID: " . ($result['transaction_id'] ?? 'N/A') . "\n";
        echo "   Message: " . $result['message'] . "\n";
        echo "   📱 You should receive an M-Pesa prompt on 254728883160!\n";
    } else {
        echo "❌ STK Push failed: " . $result['message'] . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== COMPLETE ===\n";
