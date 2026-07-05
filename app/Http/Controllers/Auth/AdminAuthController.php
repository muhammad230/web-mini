<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Rate limiting — 5 attempts per minute per IP+email
        $key = 'admin-login:' . Str::lower($request->email) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ])->withInput($request->only('email'));
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            if (!Auth::user()->isAdmin()) {
                Auth::logout();
                RateLimiter::hit($key);
                return back()->withErrors(['email' => 'Access denied. Admin accounts only.'])->withInput($request->only('email'));
            }
            RateLimiter::clear($key);
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        RateLimiter::hit($key);
        return back()->withErrors(['email' => 'Invalid credentials. Please try again.'])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    public function approvePro($userId)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login');
        }

        $user = User::findOrFail($userId);
        if ($user->role === 'professional') {
            $user->verification_status = 'verified';
            $user->save();
        }

        return back()->with('success', 'Professional approved successfully!');
    }

    public function rejectPro($userId)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login');
        }

        $user = User::findOrFail($userId);
        // Optionally delete or just mark as rejected
        $user->verification_status = 'rejected';
        $user->save();

        return back()->with('success', 'Professional rejected!');
    }
}
