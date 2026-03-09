<?php

/**
 * Fix the passkey issue - use the standard sandbox passkey
 */

echo "=== FIXING M-PESA PASSKEY ===\n\n";

// Keep your consumer key and secret, but use the standard sandbox passkey
$fixedCredentials = [
    'MPESA_CONSUMER_KEY' => 'JQAqvnXBbKBrK1szfkAssyrLUJEho077GKZpoV0WgAxuEJAI',
    'MPESA_CONSUMER_SECRET' => 'ulou1OUSqCsowC7YeDaUGlzrk1F6rYhIX4GCaGQxexYEbwNvix1J0cQFWIFMQVhB',
    'MPESA_PASSKEY' => 'bfb279f9aa9bdbcf158e97dd71a467cd2e3c0', // Standard sandbox passkey
    'MPESA_SHORTCODE' => '174379',
    'MPESA_TILL_NUMBER' => '174379',
    'MPESA_ENVIRONMENT' => 'sandbox',
    'MPESA_CALLBACK_URL' => 'https://webhook.site/test-callback'
];

$envFile = __DIR__ . '/.env';
$envContent = file_get_contents($envFile);

echo "Fixing passkey with standard sandbox passkey...\n";

foreach ($fixedCredentials as $key => $value) {
    if (preg_match("/^{$key}=/m", $envContent)) {
        $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
        echo "✅ Updated $key\n";
    }
}

file_put_contents($envFile, $envContent);

echo "\n✅ Passkey fixed!\n";

// Clear cache
passthru('php artisan config:clear');

echo "\n🧪 Testing with fixed passkey...\n";

// Test
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$consumerKey = env('MPESA_CONSUMER_KEY');
$consumerSecret = env('MPESA_CONSUMER_SECRET');
$shortcode = env('MPESA_SHORTCODE');
$passkey = env('MPESA_PASSKEY');

echo "Using:\n";
echo "  Consumer Key: " . substr($consumerKey, 0, 20) . "...\n";
echo "  Consumer Secret: " . substr($consumerSecret, 0, 20) . "...\n";
echo "  Passkey: " . substr($passkey, 0, 30) . "...\n\n";

// Get token
$credentials = base64_encode($consumerKey . ':' . $consumerSecret);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $credentials]);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($response && $httpCode === 200) {
    $data = json_decode($response, true);
    $token = $data['access_token'] ?? null;
    
    if ($token) {
        echo "✅ Token obtained\n";
        
        // Test STK Push
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
            'CallBackURL' => 'https://webhook.site/test-callback',
            'AccountReference' => 'TWENDEETICKETS',
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
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        echo "📱 Sending STK Push to 254728883160...\n";
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($response && $httpCode === 200) {
            $data = json_decode($response, true);
            
            if (($data['ResponseCode'] ?? '') === '0') {
                echo "\n🎉🎉🎉 SUCCESS! M-PESA WORKING! 🎉🎉🎉\n";
                echo "✅ STK Push sent to 254728883160!\n";
                echo "💰 Amount: KES 1\n";
                echo "🔍 Check your phone NOW for M-Pesa prompt!\n";
                echo "🔒 Enter PIN to complete payment\n";
                echo "📋 CheckoutRequestID: " . ($data['CheckoutRequestID'] ?? 'N/A') . "\n";
            } else {
                echo "❌ Error: " . ($data['ResponseDescription'] ?? 'Unknown') . "\n";
                echo "   ResponseCode: " . ($data['ResponseCode'] ?? 'N/A') . "\n";
            }
        } else {
            echo "❌ HTTP $httpCode: " . substr($response ?? '', 0, 200) . "\n";
        }
    }
} else {
    echo "❌ Token failed: HTTP $httpCode\n";
}

echo "\n=== COMPLETE ===\n";
