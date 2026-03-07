<?php
// Script to fix Neon PostgreSQL configuration
$envFile = '.env';
$content = file_get_contents($envFile);

// Extract endpoint ID from hostname
$host = 'ep-super-snow-aiws7srx-pooler.c-4.us-east-1.aws.neon.tech';
$endpointId = explode('.', $host)[0]; // ep-super-snow-aiws7srx-pooler

// Update database configuration with proper Neon settings
$content = preg_replace(
    '/DB_HOST=.*/',
    'DB_HOST=' . $host,
    $content
);

$content = preg_replace(
    '/DB_DATABASE=.*/',
    'DB_DATABASE=neondb?options=endpoint%3D' . $endpointId . '&sslmode=require',
    $content
);

file_put_contents($envFile, $content);

echo "Neon PostgreSQL configuration has been updated\n";
echo "Endpoint ID: " . $endpointId . "\n";
echo "SSL Mode: require\n";
?>
