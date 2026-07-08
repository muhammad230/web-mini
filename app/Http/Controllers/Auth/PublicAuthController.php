<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class PublicAuthController extends Controller
{
    // ── Login page ──────────────────────────────────────────────────
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectAfterLogin(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $key = 'login:' . Str::lower($request->email) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => "Too many attempts. Try again in {$seconds}s.",
            ])->withInput($request->only('email'));
        }

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            RateLimiter::clear($key);
            $request->session()->regenerate();
            return $this->redirectAfterLogin(Auth::user());
        }

        RateLimiter::hit($key);
        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput($request->only('email'));
    }

    // ── Register page ────────────────────────────────────────────────
    public function showRegister(Request $request)
    {
        if (Auth::check()) {
            return $this->redirectAfterLogin(Auth::user());
        }
        $tab = $request->query('role', 'customer');
        return view('auth.register', compact('tab'));
    }

    public function register(Request $request)
    {
        $role = $request->input('role', 'customer');

        $rules = [
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|string|max:20',
            'password' => ['required', 'confirmed', Password::min(8)],
            'role'     => 'required|in:customer,professional',
        ];

        if ($role === 'professional') {
            $rules['trade']    = 'required|string|max:100';
            $rules['location'] = 'required|string|max:150';
            $rules['id_document'] = 'nullable|image|max:10240'; // 10MB max, optional
            $rules['selfie_document'] = 'nullable|image|max:10240';
            $rules['certification_document'] = 'nullable|image|max:10240';
        }

        $request->validate($rules);

        $userData = [
            'name'                => $request->name,
            'email'               => $request->email,
            'phone'               => $request->phone,
            'password'            => Hash::make($request->password),
            'role'                => $role,
            'trade'               => $role === 'professional' ? $request->trade : null,
            'location'            => $role === 'professional' ? $request->location : null,
            'verification_status' => $role === 'professional' ? 'verified' : 'verified',
        ];

        if ($role === 'professional') {
            // Store documents if provided
            if ($request->hasFile('id_document')) {
                $userData['id_document_path'] = $request->file('id_document')->store('verification-docs', 'private');
            }
            if ($request->hasFile('selfie_document')) {
                $userData['selfie_document_path'] = $request->file('selfie_document')->store('verification-docs', 'private');
            }
            if ($request->hasFile('certification_document')) {
                $userData['certification_document_path'] = $request->file('certification_document')->store('verification-docs', 'private');
            }
        }

        $user = User::create($userData);

        // Notify admin about new professional signup
        if ($role === 'professional') {
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'type'    => 'new_professional_signup',
                    'title'   => 'New professional signed up',
                    'message' => $user->name . ' registered as a ' . ($user->trade ?? 'professional') . '.',
                ]);
            }
        }

        Auth::login($user);
        $request->session()->regenerate();

        // Customers go directly to customer dashboard, pros go straight to professional dashboard
        if ($user->isCustomer()) {
            return redirect()->route('dashboard.customer');
        }
        return redirect()->route('dashboard.professional');
    }

    // ── Logout ───────────────────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    // ── Pending screen ───────────────────────────────────────────────
    public function pending()
    {
        if (!Auth::check()) return redirect()->route('login');
        return view('auth.pending', ['user' => Auth::user()]);
    }

    // ── Helpers ──────────────────────────────────────────────────────
    private function redirectAfterLogin(User $user): \Illuminate\Http\RedirectResponse
    {
        return match ($user->role) {
            'admin'        => redirect()->route('admin.dashboard'),
            'customer'     => redirect()->route('dashboard.customer'),
            'professional' => $user->verification_status === 'verified' 
                ? redirect()->route('dashboard.professional')
                : redirect()->route('welcome.pending'),
            default        => redirect()->route('home'),
        };
    }
}
