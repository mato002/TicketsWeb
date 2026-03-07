<?php
// Script to set Neon PostgreSQL using full URL format
$envFile = '.env';
$content = file_get_contents($envFile);

// Use full PostgreSQL URL format for Neon
$neonUrl = 'postgresql://neondb_owner:npg_vK2S7LmbWNwA@ep-super-snow-aiws7srx-pooler.c-4.us-east-1.aws.neon.tech:5432/neondb?options=endpoint%3Dep-super-snow-aiws7srx-pooler%26sslmode%3Drequire';

// Replace database configuration with URL
$content = preg_replace(
    '/DB_DATABASE=.*/',
    'DB_DATABASE=neondb',
    $content
);

// Add or update DATABASE_URL
if (strpos($content, 'DATABASE_URL=') === false) {
    $content .= "\nDATABASE_URL=" . $neonUrl . "\"\n";
} else {
    $content = preg_replace(
        '/DATABASE_URL=.*/',
        'DATABASE_URL=' . $neonUrl,
        $content
    );
}

file_put_contents($envFile, $content);

echo "Neon PostgreSQL configured using DATABASE_URL format\n";
echo "URL: " . $neonUrl . "\n";
?>
