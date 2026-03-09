<?php

/**
 * Update .env with correct M-Pesa sandbox credentials
 */

echo "=== UPDATING M-PESA CREDENTIALS ===\n\n";

// Correct M-Pesa sandbox credentials
$correctCredentials = [
    'MPESA_CONSUMER_KEY' => 'JQAqvnXB3yLbGZhM91M5FQXYcVYSWHFR',
    'MPESA_CONSUMER_SECRET' => 'ulou1OUSgASmK7rmP9Tmz3aOqG3tHEVn',
    'MPESA_PASSKEY' => 'bfb279f9aa9bdbcf158e97dd71a467cd2e3c0',
    'MPESA_SHORTCODE' => '174379',
    'MPESA_TILL_NUMBER' => '174379',
    'MPESA_ENVIRONMENT' => 'sandbox',
    'MPESA_CALLBACK_URL' => 'https://webhook.site/test-callback'
];

$envFile = __DIR__ . '/.env';

echo "Current .env file backup created as .env.backup\n";
copy($envFile, $envFile . '.backup');

// Read current .env
$envContent = file_get_contents($envFile);

// Update credentials
foreach ($correctCredentials as $key => $value) {
    // Check if key exists
    if (preg_match("/^{$key}=/m", $envContent)) {
        // Update existing
        $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
        echo "✅ Updated $key\n";
    } else {
        // Add new
        $envContent .= "\n{$key}={$value}";
        echo "➕ Added $key\n";
    }
}

// Write back to .env
file_put_contents($envFile, $envContent);

echo "\n✅ M-Pesa credentials updated successfully!\n";
echo "📱 These are the official Safaricom sandbox credentials\n";
echo "🔄 Please restart your Laravel server for changes to take effect\n";
echo "🧪 Then test again with: php debug_mpesa_config.php\n\n";

echo "New credentials:\n";
foreach ($correctCredentials as $key => $value) {
    $display = $key === 'MPESA_PASSKEY' ? substr($value, 0, 20) . '...' : $value;
    echo "  $key: $display\n";
}
