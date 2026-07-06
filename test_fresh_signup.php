<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// Mimics exact fields set during registration only
$user = User::create([
    'name' => 'Fresh Signup Pro',
    'email' => 'fresh_' . time() . '@fixit.com',
    'phone' => '+1234567801',
    'password' => Hash::make('password123'),
    'role' => 'professional',
    'trade' => 'Plumbing',
    'location' => 'Karachi',
    'verification_status' => 'verified', // after admin approval
]);

Auth::login($user);

// Render view to string to catch blade errors
$controller = new App\Http\Controllers\ProfessionalController();
$response = $controller->index();
$html = view($response->getName(), $response->getData())->render();
echo "Rendered " . strlen($html) . " bytes OK\n";

// Check key empty states present
$checks = ['0', 'No new leads', 'No active jobs', 'No completed jobs', 'Rs. 0'];
foreach ($checks as $c) {
    echo (str_contains($html, $c) ? 'FOUND' : 'MISSING') . ": $c\n";
}

$user->delete();
