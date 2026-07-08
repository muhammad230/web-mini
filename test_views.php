<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$exists = view()->exists('partials.notification-bell');
echo 'View exists: ' . ($exists ? 'YES' : 'NO') . PHP_EOL;

$exists2 = view()->exists('notifications.index');
echo 'View exists2: ' . ($exists2 ? 'YES' : 'NO') . PHP_EOL;

// Try to render
try {
    $html = view('partials.notification-bell')->render();
    echo 'Rendered OK, length: ' . strlen($html) . PHP_EOL;
} catch (Throwable $e) {
    echo 'RENDER ERROR: ' . $e->getMessage() . PHP_EOL;
}
