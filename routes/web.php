<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\PublicAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// ── Public Auth (Login, Register, Logout) ─────────────────────────────────
Route::prefix('auth')->name('')->group(function () {
    Route::get('/login', [PublicAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [PublicAuthController::class, 'login'])->name('login.submit');

    Route::get('/register', [PublicAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [PublicAuthController::class, 'register'])->name('register.submit');

    Route::post('/logout', [PublicAuthController::class, 'logout'])->name('logout')->middleware('auth');

    Route::get('/welcome', [PublicAuthController::class, 'pending'])->name('welcome.pending')->middleware('auth');
});

// ── Customer Dashboard ────────────────────────────────────────────────────
Route::prefix('dashboard')->name('dashboard.')->middleware([App\Http\Middleware\CustomerMiddleware::class])->group(function () {
    Route::get('/customer', function () {
        return view('dashboard.customer');
    })->name('customer');
});

// ── Professional Dashboard ────────────────────────────────────────────────────
Route::prefix('dashboard')->name('dashboard.')->middleware([App\Http\Middleware\ProfessionalMiddleware::class])->group(function () {
    Route::get('/professional', function () {
        return view('dashboard.professional');
    })->name('professional');
});

// ── Admin Auth & Dashboard ────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout')->middleware('auth');

    Route::middleware([App\Http\Middleware\AdminMiddleware::class])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.index');
        })->name('dashboard');
    });
});
