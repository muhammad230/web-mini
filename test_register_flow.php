<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$email = 'regsignup_' . time() . '@fixit.com';

// Simulate professional registration POST
$request = Illuminate\Http\Request::create('/auth/register', 'POST', [
    '_token' => csrf_token(),
    'name' => 'Reg Test Pro',
    'email' => $email,
    'phone' => '+1234567800',
    'password' => 'password123',
    'password_confirmation' => 'password123',
    'role' => 'professional',
    'trade' => 'Plumbing',
    'location' => 'Karachi',
]);
$request->headers->set('Accept', 'text/html');

// Need session for CSRF - bootstrap session
$session = $app->make('session');
$session->start();
$request->setLaravelSession($session);

try {
    $response = $app->handle($request);
    echo "Register status: " . $response->getStatusCode() . "\n";
    echo "Redirect: " . ($response->headers->get('Location') ?? 'none') . "\n";
} catch (Throwable $e) {
    echo "Register ERROR: " . $e->getMessage() . "\n";
}

$user = User::where('email', $email)->first();
if ($user) {
    echo "User created: role={$user->role}, status={$user->verification_status}, trade={$user->trade}, location={$user->location}\n";
    
    // Approve
    $user->verification_status = 'verified';
    $user->save();
    
    // Login and hit dashboard
    Auth::login($user);
    $dashRequest = Illuminate\Http\Request::create('/dashboard/professional', 'GET');
    $dashRequest->setLaravelSession($session);
    $dashResponse = $app->handle($dashRequest);
    echo "Dashboard status: " . $dashResponse->getStatusCode() . "\n";
    
    $user->delete();
} else {
    echo "User NOT created\n";
    if ($response->getStatusCode() === 302) {
        // validation redirect - check session errors
    }
    echo substr($response->getContent(), 0, 500) . "\n";
}
