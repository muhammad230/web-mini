<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Http\Controllers\ProfessionalController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// Create a fresh test pro
$email = 'testnewpro_' . time() . '@fixit.com';
$user = User::create([
    'name' => 'Test New Pro',
    'email' => $email,
    'phone' => '+1234567899',
    'password' => Hash::make('password123'),
    'role' => 'professional',
    'trade' => 'Plumbing',
    'location' => 'Karachi',
    'verification_status' => 'verified',
]);

echo "Created user: {$email}\n";
echo "role={$user->role}, status={$user->verification_status}, trade={$user->trade}\n";
echo "available=" . json_encode($user->available) . ", total_earnings=" . json_encode($user->total_earnings) . "\n";

Auth::login($user);

try {
    $controller = new ProfessionalController();
    $response = $controller->index();
    echo "Dashboard index() OK - view: " . $response->getName() . "\n";
} catch (Throwable $e) {
    echo "Dashboard ERROR: " . $e->getMessage() . "\n";
    echo $e->getFile() . ':' . $e->getLine() . "\n";
}

// Test with completely empty profile
$user2 = User::create([
    'name' => 'Empty Pro',
    'email' => 'emptypro_' . time() . '@fixit.com',
    'phone' => '+1234567898',
    'password' => Hash::make('password123'),
    'role' => 'professional',
    'trade' => null,
    'location' => null,
    'verification_status' => 'verified',
]);

Auth::login($user2);
echo "\nEmpty profile user:\n";
echo "trade=" . json_encode($user2->trade) . ", location=" . json_encode($user2->location) . "\n";

try {
    $controller = new ProfessionalController();
    $response = $controller->index();
    echo "Empty profile dashboard OK\n";
} catch (Throwable $e) {
    echo "Empty profile ERROR: " . $e->getMessage() . "\n";
    echo $e->getFile() . ':' . $e->getLine() . "\n";
}

// Cleanup
$user->delete();
$user2->delete();
echo "\nDone.\n";
