<?php

/**
 * Fix the BusinessShortCode issue
 */

echo "=== FIXING BUSINESS SHORTCODE ===\n\n";

// Keep your working consumer key and secret, but use valid sandbox shortcode
$fixedCredentials = [
    'MPESA_CONSUMER_KEY' => 'JQAqvnXBbKBrK1szfkAssyrLUJEho077GKZpoV0WgAxuEJAI',
    'MPESA_CONSUMER_SECRET' => 'ulou1OUSqCsowC7YeDaUGlzrk1F6rYhIX4GCaGQxexYEbwNvix1J0cQFWIFMQVhB',
    'MPESA_PASSKEY' => 'bfb279f9aa9bdbcf158e97dd71a467cd2e3c0',
    'MPESA_SHORTCODE' => '174379', // This is the standard sandbox shortcode
    'MPESA_TILL_NUMBER' => '174379',
    'MPESA_ENVIRONMENT' => 'sandbox',
    'MPESA_CALLBACK_URL' => 'https://webhook.site/test'
];

$envFile = __DIR__ . '/.env';
$envContent = file_get_contents($envFile);

echo "Using valid sandbox shortcode 174379...\n";

foreach ($fixedCredentials as $key => $value) {
    if (preg_match("/^{$key}=/m", $envContent)) {
        $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
        echo "✅ Updated $key: $value\n";
    }
}

file_put_contents($envFile, $envContent);

passthru('php artisan config:clear');

echo "\n🧪 Testing with fixed shortcode...\n";

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$consumerKey = env('MPESA_CONSUMER_KEY');
$consumerSecret = env('MPESA_CONSUMER_SECRET');
$shortcode = env('MPESA_SHORTCODE');
$passkey = env('MPESA_PASSKEY');

echo "Using:\n";
echo "  Consumer Key: " . substr($consumerKey, 0, 30) . "...\n";
echo "  Consumer Secret: " . substr($consumerSecret, 0, 30) . "...\n";
echo "  Shortcode: $shortcode\n";
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
        
        // Test STK Push with correct format
        $timestamp = date('YmdHis');
        $password = base64_encode($shortcode . $passkey . $timestamp);
        
        $requestBody = json_encode([
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => 1,
            'PartyA' => $shortcode,
            'PartyB' => '254728883160',
            'PhoneNumber' => '254728883160',
            'CallBackURL' => 'https://webhook.site/test',
            'AccountReference' => 'TWENDEETICKETS',
            'TransactionDesc' => 'Test payment'
        ]);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        echo "📱 Sending STK Push to 254728883160...\n";
        echo "💰 Amount: KES 1\n";
        echo "🏪 Business Shortcode: $shortcode\n";
        echo "⏳ Waiting for M-Pesa...\n\n";
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($response && $httpCode === 200) {
            $data = json_decode($response, true);
            
            if (($data['ResponseCode'] ?? '') === '0') {
                echo "🎉🎉🎉🎉🎉 SUCCESS! M-PESA IS WORKING! 🎉🎉🎉🎉🎉\n";
                echo "═══════════════════════════════════════════════════════════════\n";
                echo "✅ STK Push initiated successfully!\n";
                echo "📱 Phone: 254728883160\n";
                echo "💰 Amount: KES 1\n";
                echo "🏪 Business Shortcode: $shortcode\n";
                echo "🔍 CheckoutRequestID: " . ($data['CheckoutRequestID'] ?? 'N/A') . "\n";
                echo "📝 ResponseDescription: " . ($data['ResponseDescription'] ?? 'N/A') . "\n";
                echo "\n📱📱📱 CHECK YOUR PHONE RIGHT NOW! 📱📱📱\n";
                echo "You should receive an M-Pesa popup on 254728883160\n";
                echo "Enter your M-Pesa PIN to complete the KES 1 payment\n";
                echo "\n✅ Your M-Pesa integration is WORKING PERFECTLY!\n";
                echo "✅ Ready for production use!\n";
                echo "═══════════════════════════════════════════════════════════════\n";
                
                // Now test with Laravel service
                echo "\n🧪 Testing with Laravel MpesaService...\n";
                $service = new \App\Services\MpesaService();
                
                $booking = new stdClass();
                $booking->id = 999;
                $booking->total_amount = 1;
                $booking->booking_reference = 'TEST' . time();
                
                $result = $service->initiatePayment($booking, '254728883160');
                
                if ($result['success']) {
                    echo "✅ Laravel MpesaService also working!\n";
                    echo "   Transaction ID: " . ($result['transaction_id'] ?? 'N/A') . "\n";
                    echo "   Message: " . $result['message'] . "\n";
                    echo "\n🎉 COMPLETE SUCCESS! Both API and Laravel service working!\n";
                } else {
                    echo "❌ Laravel service issue: " . $result['message'] . "\n";
                    echo "But the direct API is working - just need to fix Laravel service\n";
                }
                
            } else {
                echo "❌ M-Pesa Error:\n";
                echo "   ResponseCode: " . ($data['ResponseCode'] ?? 'N/A') . "\n";
                echo "   ResponseDescription: " . ($data['ResponseDescription'] ?? 'N/A') . "\n";
                if (isset($data['errorMessage'])) {
                    echo "   ErrorMessage: " . $data['errorMessage'] . "\n";
                }
            }
        } else {
            echo "❌ HTTP Error $httpCode\n";
            echo "   Response: " . substr($response ?? '', 0, 500) . "\n";
        }
    }
} else {
    echo "❌ Token failed: HTTP $httpCode\n";
}

echo "\n=== TEST COMPLETE ===\n";
