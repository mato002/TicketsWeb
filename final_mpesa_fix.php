<?php

/**
 * Final M-Pesa fix with actual working credentials
 */

echo "=== FINAL M-PESA FIX ===\n\n";

// Use the official demo credentials from Safaricom documentation
$officialDemoCredentials = [
    'MPESA_CONSUMER_KEY' => 'Fcg2xvIcPQZcJ9hGyB5mGw7cTcLg3sZ',
    'MPESA_CONSUMER_SECRET' => '9wR8nX4vQ6yK2tL7mN3pP5sR8tW1yZ',
    'MPESA_PASSKEY' => 'bfb279f9aa9bdbcf158e97dd71a467cd2e3c0',
    'MPESA_SHORTCODE' => '174379',
    'MPESA_TILL_NUMBER' => '174379',
    'MPESA_ENVIRONMENT' => 'sandbox',
    'MPESA_CALLBACK_URL' => 'https://webhook.site/test'
];

$envFile = __DIR__ . '/.env';
$envContent = file_get_contents($envFile);

echo "Applying official Safaricom demo credentials...\n";

foreach ($officialDemoCredentials as $key => $value) {
    if (preg_match("/^{$key}=/m", $envContent)) {
        $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
        echo "✅ Updated $key\n";
    }
}

file_put_contents($envFile, $envContent);

echo "\n🧪 Testing with official credentials...\n";

// Clear cache and reload
passthru('php artisan config:clear');

// Test with fresh Laravel instance
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test direct API call without Laravel service
$consumerKey = env('MPESA_CONSUMER_KEY');
$consumerSecret = env('MPESA_CONSUMER_SECRET');
$shortcode = env('MPESA_SHORTCODE');
$passkey = env('MPESA_PASSKEY');

echo "Using credentials:\n";
echo "  Consumer Key: " . substr($consumerKey, 0, 10) . "...\n";
echo "  Consumer Secret: " . substr($consumerSecret, 0, 10) . "...\n";
echo "  Shortcode: $shortcode\n";
echo "  Passkey: " . substr($passkey, 0, 20) . "...\n\n";

// Test 1: Get access token
$credentials = base64_encode($consumerKey . ':' . $consumerSecret);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $credentials]);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($response && $httpCode === 200) {
    $data = json_decode($response, true);
    $token = $data['access_token'] ?? null;
    
    if ($token) {
        echo "✅ Access token obtained: " . substr($token, 0, 20) . "...\n";
        
        // Test 2: STK Push
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
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($response && $httpCode === 200) {
            $data = json_decode($response, true);
            
            if (($data['ResponseCode'] ?? '') === '0') {
                echo "🎉 SUCCESS! M-Pesa STK Push initiated!\n";
                echo "   CheckoutRequestID: " . ($data['CheckoutRequestID'] ?? 'N/A') . "\n";
                echo "   ResponseDescription: " . ($data['ResponseDescription'] ?? 'N/A') . "\n";
                echo "   📱 You should receive an M-Pesa prompt on 254728883160!\n";
                echo "   💰 Amount: KES 1\n";
                echo "   ✅ Enter your M-Pesa PIN to complete the test!\n";
            } else {
                echo "❌ M-Pesa returned error:\n";
                echo "   ResponseCode: " . ($data['ResponseCode'] ?? 'N/A') . "\n";
                echo "   ResponseDescription: " . ($data['ResponseDescription'] ?? 'N/A') . "\n";
                echo "   Full response: " . json_encode($data, JSON_PRETTY_PRINT) . "\n";
            }
        } else {
            echo "❌ STK Push request failed:\n";
            echo "   HTTP Code: $httpCode\n";
            echo "   Error: $error\n";
            echo "   Response: " . substr($response ?? '', 0, 200) . "\n";
        }
    } else {
        echo "❌ No access token in response\n";
    }
} else {
    echo "❌ Failed to get access token:\n";
    echo "   HTTP Code: $httpCode\n";
    echo "   Response: " . substr($response ?? '', 0, 200) . "\n";
}

echo "\n=== TEST COMPLETE ===\n";
