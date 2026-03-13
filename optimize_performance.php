<?php

/**
 * Quick Performance Optimization Script
 */

echo "🚀 === PERFORMANCE OPTIMIZATION === 🚀\n\n";

// Step 1: Clear all caches first
echo "1️⃣ Clearing all caches...\n";
passthru('php artisan config:clear');
passthru('php artisan route:clear');
passthru('php artisan view:clear');
passthru('php artisan cache:clear');

echo "\n2️⃣ Optimizing caches...\n";
passthru('php artisan config:cache');
passthru('php artisan route:cache');
passthru('php artisan view:cache');
passthru('php artisan event:cache');

echo "\n3️⃣ Running artisan optimize...\n";
passthru('php artisan optimize');

echo "\n4️⃣ Additional optimizations...\n";

// Check if OPcache is enabled
if (function_exists('opcache_get_status')) {
    $opcache = opcache_get_status();
    if ($opcache && $opcache['opcache_enabled']) {
        echo "✅ OPcache is enabled\n";
    } else {
        echo "⚠️  OPcache is not enabled (slower performance)\n";
        echo "   Enable OPcache in php.ini for better performance\n";
    }
} else {
    echo "⚠️  OPcache extension not installed\n";
}

// Check memory limit
echo "Memory Limit: " . ini_get('memory_limit') . "\n";

// Check max execution time
echo "Max Execution Time: " . ini_get('max_execution_time') . "s\n";

// Check if gzip is enabled (can't check from PHP but can suggest)
echo "\n💡 RECOMMENDATIONS:\n";
echo "═══════════════════════════════════════════════════════════════\n";
echo "1. ✅ Laravel optimizations completed\n";
echo "2. 🌐 Enable gzip compression in Apache/Nginx\n";
echo "3. 🗄️  Consider switching cache driver from database to Redis\n";
echo "4. 🔧 Turn off debug mode in production\n";
echo "5. 📦 Use CDN for static assets\n";
echo "6. 💾 Enable PHP OPcache\n";
echo "7. 🚀 Use Laravel Octane for better performance\n";

echo "\n✨ PERFORMANCE IMPROVEMENTS APPLIED! ✨\n";
echo "Your website should now load much faster!\n";
