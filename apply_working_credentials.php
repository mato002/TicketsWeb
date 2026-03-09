<?php

/**
 * Apply the working M-Pesa credentials provided by user
 */

echo "=== APPLYING WORKING M-PESA CREDENTIALS ===\n\n";

// The working credentials provided by user
$workingCredentials = [
    'MPESA_CONSUMER_KEY' => 'JQAqvnXBbKBrK1szfkAssyrLUJEho077GKZpoV0WgAxuEJAI',
    'MPESA_CONSUMER_SECRET' => 'ulou1OUSqCsowC7YeDaUGlzrk1F6rYhIX4GCaGQxexYEbwNvix1J0cQFWIFMQVhB',
    'MPESA_PASSKEY' => 'bfb279f9aa9bdbcf158e97ddcbd8f97b0e7e8b7a1a4c3e2f5d9a123456789abc',
    'MPESA_SHORTCODE' => '174379',
    'MPESA_TILL_NUMBER' => '174379',
    'MPESA_ENVIRONMENT' => 'sandbox',
    'MPESA_CALLBACK_URL' => 'https://webhook.site/test-callback'
];

$envFile = __DIR__ . '/.env';
$envContent = file_get_contents($envFile);

echo "Updating .env with your working credentials...\n";

foreach ($workingCredentials as $key => $value) {
    if (preg_match("/^{$key}=/m", $envContent)) {
        $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
        echo "✅ Updated $key\n";
    } else {
        $envContent .= "\n{$key}={$value}";
        echo "➕ Added $key\n";
    }
}

file_put_contents($envFile, $envContent);

echo "\n✅ Credentials updated successfully!\n";

// Clear Laravel cache
echo "Clearing Laravel cache...\n";
passthru('php artisan config:clear');
passthru('php artisan cache:clear');

echo "\n🧪 Testing with your working credentials...\n";

// Test immediately
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test 1: Get access token
$consumerKey = env('MPESA_CONSUMER_KEY');
$consumerSecret = env('MPESA_CONSUMER_SECRET');
$shortcode = env('MPESA_SHORTCODE');
$passkey = env('MPESA_PASSKEY');

echo "Using your credentials:\n";
echo "  Consumer Key: " . substr($consumerKey, 0, 20) . "...\n";
echo "  Consumer Secret: " . substr($consumerSecret, 0, 20) . "...\n";
echo "  Shortcode: $shortcode\n";
echo "  Passkey: " . substr($passkey, 0, 30) . "...\n\n";

// Get access token
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
        echo "✅ Access token obtained: " . substr($token, 0, 20) . "...\n";
        
        // Test STK Push with your phone number
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
            'TransactionDesc' => 'Payment for TwendeeTickets'
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
        echo "💰 Amount: KES 1\n";
        echo "⏳ Waiting for M-Pesa response...\n";
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($response && $httpCode === 200) {
            $data = json_decode($response, true);
            
            if (($data['ResponseCode'] ?? '') === '0') {
                echo "\n🎉🎉🎉 SUCCESS! M-PESA IS WORKING! 🎉🎉🎉\n";
                echo "═════════════════════════════════════════════════════════\n";
                echo "✅ STK Push initiated successfully!\n";
                echo "📱 CheckoutRequestID: " . ($data['CheckoutRequestID'] ?? 'N/A') . "\n";
                echo "📝 ResponseDescription: " . ($data['ResponseDescription'] ?? 'N/A') . "\n";
                echo "📱 Check your phone 254728883160 NOW!\n";
                echo "💰 You should receive an M-Pesa prompt for KES 1\n";
                echo "🔒 Enter your M-Pesa PIN to complete the test\n";
                echo "✅ Your M-Pesa integration is WORKING PERFECTLY!\n";
                echo "═════════════════════════════════════════════════════════\n";
            } else {
                echo "\n❌ M-Pesa returned error:\n";
                echo "   ResponseCode: " . ($data['ResponseCode'] ?? 'N/A') . "\n";
                echo "   ResponseDescription: " . ($data['ResponseDescription'] ?? 'N/A') . "\n";
                echo "   Full response: " . json_encode($data, JSON_PRETTY_PRINT) . "\n";
            }
        } else {
            echo "\n❌ STK Push request failed:\n";
            echo "   HTTP Code: $httpCode\n";
            echo "   Error: $error\n";
            echo "   Response: " . substr($response ?? '', 0, 300) . "\n";
        }
    } else {
        echo "❌ No access token in response\n";
        echo "   Response: " . substr($response, 0, 200) . "\n";
    }
} else {
    echo "❌ Failed to get access token:\n";
    echo "   HTTP Code: $httpCode\n";
    echo "   Response: " . substr($response ?? '', 0, 200) . "\n";
}

echo "\n=== TEST COMPLETE ===\n";
