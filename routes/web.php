<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\PublicAuthController;
use Illuminate\Support\Facades\Route;

use App\Helpers\SiteContentHelper;
use App\Http\Controllers\Admin\SiteContentController;

Route::get('/', function () {
    $hero        = SiteContentHelper::get('hero', \App\Http\Controllers\Admin\SiteContentController::DEFAULTS['hero']);
    $statsBar    = SiteContentHelper::get('stats_bar', \App\Http\Controllers\Admin\SiteContentController::DEFAULTS['stats_bar']);
    $trades      = SiteContentHelper::get('browse_trades', \App\Http\Controllers\Admin\SiteContentController::DEFAULTS['browse_trades']);
    $howItWorks  = SiteContentHelper::get('how_it_works', \App\Http\Controllers\Admin\SiteContentController::DEFAULTS['how_it_works']);
    $featuredPros = SiteContentHelper::get('featured_pros', \App\Http\Controllers\Admin\SiteContentController::DEFAULTS['featured_pros']);
    $testimonials = SiteContentHelper::get('testimonials', \App\Http\Controllers\Admin\SiteContentController::DEFAULTS['testimonials']);
    $ctaBanner   = SiteContentHelper::get('cta_banner', \App\Http\Controllers\Admin\SiteContentController::DEFAULTS['cta_banner']);
    $footerData  = SiteContentHelper::get('footer', \App\Http\Controllers\Admin\SiteContentController::DEFAULTS['footer']);
    $navData     = SiteContentHelper::get('navigation', \App\Http\Controllers\Admin\SiteContentController::DEFAULTS['navigation']);

    return view('welcome', compact(
        'hero', 'statsBar', 'trades', 'howItWorks',
        'featuredPros', 'testimonials', 'ctaBanner',
        'footerData', 'navData'
    ));
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
                $pendingPros = \App\Models\User::where('role', 'professional')
                    ->where('verification_status', 'pending')
                    ->get();
                return view('dashboard.index', compact('pendingPros'));
            })->name('dashboard');

            Route::post('/pro/{user}/approve', [\App\Http\Controllers\Auth\AdminAuthController::class, 'approvePro'])->name('pro.approve');
            Route::post('/pro/{user}/reject',  [\App\Http\Controllers\Auth\AdminAuthController::class, 'rejectPro'])->name('pro.reject');

            // ── Website Content Management ──────────────────────────
            Route::get('/cms', [SiteContentController::class, 'index'])->name('cms');
            Route::post('/cms/{section}', [SiteContentController::class, 'update'])->name('cms.update');
            Route::post('/cms/{section}/reset', [SiteContentController::class, 'reset'])->name('cms.reset');
            Route::post('/cms/upload/image', [SiteContentController::class, 'uploadImage'])->name('cms.upload');
        });
});
