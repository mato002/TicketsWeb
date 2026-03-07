<?php
// Script to fix Neon PostgreSQL configuration with proper URL encoding
$envFile = '.env';
$content = file_get_contents($envFile);

// Update database configuration with properly encoded Neon settings
$content = preg_replace(
    '/DB_DATABASE=.*/',
    'DB_DATABASE=neondb?options=endpoint%3Dep-super-snow-aiws7srx-pooler%26sslmode%3Drequire',
    $content
);

file_put_contents($envFile, $content);

echo "Neon PostgreSQL configuration has been updated with proper URL encoding\n";
echo "Database: neondb?options=endpoint%3Dep-super-snow-aiws7srx-pooler%26sslmode%3Drequire\n";
?>
