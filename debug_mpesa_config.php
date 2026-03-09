<?php

/**
 * Debug M-Pesa Configuration
 */

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== M-PESA CONFIGURATION DEBUG ===\n\n";

// Check all M-Pesa environment variables
$config = [
    'MPESA_CONSUMER_KEY' => env('MPESA_CONSUMER_KEY'),
    'MPESA_CONSUMER_SECRET' => env('MPESA_CONSUMER_SECRET'),
    'MPESA_PASSKEY' => env('MPESA_PASSKEY'),
    'MPESA_SHORTCODE' => env('MPESA_SHORTCODE'),
    'MPESA_TILL_NUMBER' => env('MPESA_TILL_NUMBER'),
    'MPESA_ENVIRONMENT' => env('MPESA_ENVIRONMENT'),
    'MPESA_CALLBACK_URL' => env('MPESA_CALLBACK_URL'),
];

echo "Environment Variables:\n";
foreach ($config as $key => $value) {
    $displayValue = $value ? 
        (strlen($value) > 10 ? substr($value, 0, 8) . '...' : $value) : 
        'NOT SET';
    echo "  $key: $displayValue\n";
}

echo "\n";

// Test with known working sandbox credentials
echo "Testing with standard sandbox credentials...\n";

// Create a test service
$service = new \App\Services\MpesaService();

// Test the actual API call with debugging
echo "1. Testing token generation...\n";
try {
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('generateAccessToken');
    $method->setAccessible(true);
    
    $token = $method->invoke($service);
    echo "✅ Token generated: " . substr($token, 0, 20) . "...\n";
} catch (Exception $e) {
    echo "❌ Token failed: " . $e->getMessage() . "\n";
}

echo "\n2. Testing STK Push with minimal request...\n";

// Try a direct cURL test
$shortcode = env('MPESA_SHORTCODE');
$passkey = env('MPESA_PASSKEY');
$timestamp = date('YmdHis');
$password = base64_encode($shortcode . $passkey . $timestamp);

$requestBody = [
    'BusinessShortCode' => $shortcode,
    'Password' => $password,
    'Timestamp' => $timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => 1,
    'PartyA' => '254728883160',
    'PartyB' => $shortcode,
    'PhoneNumber' => '254728883160',
    'CallBackURL' => 'https://webhook.site/test',
    'AccountReference' => 'TEST123',
    'TransactionDesc' => 'Test payment'
];

echo "Request body prepared with " . count($requestBody) . " fields\n";
echo "Shortcode: $shortcode\n";
echo "Timestamp: $timestamp\n";
echo "Password length: " . strlen($password) . "\n";

// Direct cURL test
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $token
]);
curl_setopt($ch, CURLOPT_TIMEOUT, 20);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

echo "Sending request...\n";
$start = microtime(true);
$response = curl_exec($ch);
$time = round((microtime(true) - $start) * 1000);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($response === false) {
    echo "❌ cURL failed: $error (Time: ${time}ms)\n";
} else {
    echo "✅ Response received (Time: ${time}ms, HTTP $httpCode)\n";
    echo "Response: " . substr($response, 0, 200) . "...\n";
}

echo "\n=== TROUBLESHOOTING TIPS ===\n";
echo "If this fails, try:\n";
echo "1. Check if sandbox credentials are correct\n";
echo "2. Verify shortcode is valid for sandbox\n";
echo "3. Test network connectivity to safaricom.co.ke\n";
echo "4. Try with different callback URL\n";
echo "5. Check if sandbox API is down (try other M-Pesa apps)\n";
