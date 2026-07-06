<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

$user = User::create([
    'name' => 'Empty Pro View',
    'email' => 'emptyview_' . time() . '@fixit.com',
    'phone' => '+1234567897',
    'password' => Hash::make('password123'),
    'role' => 'professional',
    'trade' => null,
    'location' => null,
    'verification_status' => 'verified',
]);

Auth::login($user);

try {
    $request = Illuminate\Http\Request::create('/dashboard/professional', 'GET');
    $response = $app->handle($request);
    echo "HTTP Status: " . $response->getStatusCode() . "\n";
    if ($response->getStatusCode() >= 400) {
        echo substr($response->getContent(), 0, 2000) . "\n";
    } else {
        echo "View rendered OK, length=" . strlen($response->getContent()) . "\n";
    }
} catch (Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getFile() . ':' . $e->getLine() . "\n";
}

$user->delete();
