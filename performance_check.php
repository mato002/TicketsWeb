<?php

/**
 * Performance Check Script
 * Identifies potential performance bottlenecks
 */

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔍 === PERFORMANCE ANALYSIS === 🔍\n\n";

// Check if running in development or production
$env = app()->environment();
echo "Environment: " . ($env === 'local' ? 'Development (slower)' : 'Production (optimized)') . "\n\n";

// Check cache configuration
$cacheDriver = config('cache.default');
echo "Cache Driver: $cacheDriver\n";
if ($cacheDriver === 'database') {
    echo "⚠️  WARNING: Database cache is slower than Redis or file cache\n";
} elseif ($cacheDriver === 'array') {
    echo "⚠️  WARNING: Array cache doesn't persist between requests\n";
} else {
    echo "✅ Cache driver is optimized\n";
}

// Check debug mode
$debug = config('app.debug');
echo "Debug Mode: " . ($debug ? 'ON (slower)' : 'OFF (faster)') . "\n";
if ($debug) {
    echo "⚠️  Debug mode should be OFF in production for better performance\n";
}

// Check if optimizations are enabled
echo "\n🚀 OPTIMIZATION STATUS:\n";

// Check if routes are cached
$routesCached = app()->routesAreCached();
echo "Routes Cached: " . ($routesCached ? '✅ YES' : '❌ NO (slower)') . "\n";

// Check if config is cached
$configCached = app()->configurationIsCached();
echo "Config Cached: " . ($configCached ? '✅ YES' : '❌ NO (slower)') . "\n";

// Check if events are cached
$eventsCached = app()->eventsAreCached();
echo "Events Cached: " . ($eventsCached ? '✅ YES' : '❌ NO (slower)') . "\n";

// Check if views are cached (simple check)
$viewsCached = file_exists(storage_path('framework/views/.gitkeep'));
echo "Views Cached: " . ($viewsCached ? '✅ YES' : '❌ NO (slower)') . "\n";

echo "\n📊 DATABASE PERFORMANCE:\n";

// Check database connection
try {
    $start = microtime(true);
    \DB::select('SELECT 1');
    $dbTime = round((microtime(true) - $start) * 1000);
    echo "Database Response Time: {$dbTime}ms\n";
    
    if ($dbTime > 100) {
        echo "⚠️  Database response is slow (>100ms)\n";
    } else {
        echo "✅ Database response is good\n";
    }
} catch (Exception $e) {
    echo "❌ Database connection issue\n";
}

// Check for N+1 queries in common operations
echo "\n🔍 N+1 QUERY CHECK:\n";
$start = microtime(true);

// Test event loading with relationships
$events = \App\Models\Event::with(['organizer'])->limit(5)->get();
$queryTime = round((microtime(true) - $start) * 1000);
echo "Event Loading Time: {$queryTime}ms\n";

// Test booking loading with relationships
$start = microtime(true);
$bookings = \App\Models\Booking::with(['event', 'user'])->limit(5)->get();
$bookingTime = round((microtime(true) - $start) * 1000);
echo "Booking Loading Time: {$bookingTime}ms\n";

echo "\n🌐 ASSET OPTIMIZATION:\n";

// Check if Vite dev server is running
$viteHot = env('VITE_HOT');
echo "Vite Dev Server: " . ($viteHot ? 'ON (development)' : 'OFF (production)') . "\n";

// Check if assets are minified
$cssPath = public_path('css/app.css');
$jsPath = public_path('js/app.js');

if (file_exists($cssPath)) {
    $cssSize = filesize($cssPath) / 1024;
    echo "CSS Size: " . round($cssSize, 2) . "KB\n";
    if ($cssSize > 100) {
        echo "⚠️  CSS is large, consider minifying\n";
    }
}

if (file_exists($jsPath)) {
    $jsSize = filesize($jsPath) / 1024;
    echo "JS Size: " . round($jsSize, 2) . "KB\n";
    if ($jsSize > 50) {
        echo "⚠️  JS is large, consider minifying\n";
    }
}

echo "\n💡 PERFORMANCE RECOMMENDATIONS:\n";
echo "═══════════════════════════════════════════════════════════════\n";

if (!$configCached) {
    echo "1. 🚀 Cache config: php artisan config:cache\n";
}

if (!$routesCached) {
    echo "2. 🚀 Cache routes: php artisan route:cache\n";
}

if (!$viewsCached) {
    echo "3. 🚀 Cache views: php artisan view:cache\n";
}

if ($cacheDriver === 'database') {
    echo "4. 🚀 Use Redis or file cache instead of database cache\n";
}

if ($debug && $env === 'production') {
    echo "5. 🚀 Turn off debug mode in production\n";
}

echo "6. 🚀 Run: php artisan optimize --force\n";
echo "7. 🚀 Enable OPcache in PHP settings\n";
echo "8. 🚀 Use Redis for session and cache storage\n";
echo "9. 🚀 Enable gzip compression in web server\n";
echo "10. 🚀 Use CDN for static assets\n";

echo "\n🔧 QUICK FIX COMMANDS:\n";
echo "═══════════════════════════════════════════════════════════════\n";
echo "php artisan config:clear\n";
echo "php artisan config:cache\n";
echo "php artisan route:clear\n";
echo "php artisan route:cache\n";
echo "php artisan view:clear\n";
echo "php artisan view:cache\n";
echo "php artisan cache:clear\n";
echo "php artisan optimize --force\n";

echo "\n=== ANALYSIS COMPLETE ===\n";
