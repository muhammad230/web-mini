<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\PublicAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

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
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer');
    Route::post('/customer/jobs', [CustomerController::class, 'storeJob'])->name('customer.jobs.store');
    Route::get('/customer/jobs/{job}', [CustomerController::class, 'showJob'])->name('customer.jobs.show');
    Route::post('/customer/jobs/{job}/reschedule', [CustomerController::class, 'rescheduleJob'])->name('customer.jobs.reschedule');
    Route::post('/customer/jobs/{job}/cancel', [CustomerController::class, 'cancelJob'])->name('customer.jobs.cancel');
    Route::post('/customer/jobs/{job}/rebook', [CustomerController::class, 'rebookJob'])->name('customer.jobs.rebook');
    Route::post('/customer/jobs/{job}/review', [CustomerController::class, 'leaveReview'])->name('customer.jobs.review');
    Route::post('/customer/quotes/{quote}/accept', [CustomerController::class, 'acceptQuote'])->name('customer.quotes.accept');
    Route::post('/customer/quotes/{quote}/decline', [CustomerController::class, 'declineQuote'])->name('customer.quotes.decline');
    Route::post('/customer/profile', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');
    Route::post('/customer/password', [CustomerController::class, 'changePassword'])->name('customer.password.update');
    Route::post('/customer/addresses', [CustomerController::class, 'storeAddress'])->name('customer.addresses.store');
    Route::put('/customer/addresses/{address}', [CustomerController::class, 'updateAddress'])->name('customer.addresses.update');
    Route::delete('/customer/addresses/{address}', [CustomerController::class, 'deleteAddress'])->name('customer.addresses.delete');
    Route::post('/customer/pros/save', [CustomerController::class, 'savePro'])->name('customer.pros.save');
    Route::post('/customer/pros/remove', [CustomerController::class, 'removeSavedPro'])->name('customer.pros.remove');
});

// ── Professional Dashboard ────────────────────────────────────────────────────
Route::prefix('dashboard')->name('dashboard.')->middleware([App\Http\Middleware\ProfessionalMiddleware::class])->group(function () {
    Route::get('/professional',                        [\App\Http\Controllers\ProfessionalController::class, 'index'])->name('professional');
    Route::post('/professional/availability',          [\App\Http\Controllers\ProfessionalController::class, 'toggleAvailability'])->name('professional.availability');
    Route::post('/professional/leads/{job}/quote',     [\App\Http\Controllers\ProfessionalController::class, 'sendQuote'])->name('professional.leads.quote');
    Route::post('/professional/leads/{job}/skip',      [\App\Http\Controllers\ProfessionalController::class, 'skipLead'])->name('professional.leads.skip');
    Route::post('/professional/jobs/{job}/complete',   [\App\Http\Controllers\ProfessionalController::class, 'markComplete'])->name('professional.jobs.complete');
    Route::post('/professional/jobs/{job}/reschedule', [\App\Http\Controllers\ProfessionalController::class, 'reschedule'])->name('professional.jobs.reschedule');
    Route::post('/professional/profile',               [\App\Http\Controllers\ProfessionalController::class, 'updateProfile'])->name('professional.profile.update');
    Route::post('/professional/password',              [\App\Http\Controllers\ProfessionalController::class, 'changePassword'])->name('professional.password.update');
});

// ── Admin Auth & Dashboard ────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout')->middleware('auth');

        Route::middleware([App\Http\Middleware\AdminMiddleware::class])->group(function () {
            Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
                // Basic stats
                $verifiedPros = \App\Models\User::where('role', 'professional')->where('verification_status', 'approved')->count();
                $totalCustomers = \App\Models\User::where('role', 'customer')->count();
                $pendingPros = \App\Models\User::where('role', 'professional')->where('verification_status', 'pending')->get();
                $pendingProsCount = $pendingPros->count();
                
                $currentMonth = now()->startOfMonth();
                $lastMonth = now()->subMonth()->startOfMonth();
                $jobsThisMonth = \App\Models\CustomerJob::where('created_at', '>=', $currentMonth)->count();
                $completedJobs = \App\Models\CustomerJob::where('status', 'completed');
                $platformRevenue = $completedJobs->sum('amount_paid');
                $avgRating = \App\Models\Review::avg('rating');
                
                // Charts data
                $last12Months = collect();
                for ($i = 11; $i >= 0; $i--) {
                    $monthDate = now()->subMonths($i)->startOfMonth();
                    $monthName = $monthDate->format('M');
                    $monthJobs = \App\Models\CustomerJob::where('status', 'completed')
                        ->whereYear('created_at', $monthDate->year)
                        ->whereMonth('created_at', $monthDate->month)
                        ->count();
                    $monthRevenue = \App\Models\CustomerJob::where('status', 'completed')
                        ->whereYear('created_at', $monthDate->year)
                        ->whereMonth('created_at', $monthDate->month)
                        ->sum('amount_paid');
                    $last12Months->push([
                        'month' => $monthName,
                        'jobs' => $monthJobs,
                        'revenue' => $monthRevenue
                    ]);
                }
                
                // Bookings by trade
                $tradesBookings = \App\Models\CustomerJob::select('trade_category', \DB::raw('count(*) as total'))
                    ->groupBy('trade_category')
                    ->where('created_at', '>=', $currentMonth)
                    ->pluck('total', 'trade_category');
                
                // Recent jobs
                $recentJobs = \App\Models\CustomerJob::with('customer', 'assignedPro')
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();
                
                // Recent reviews
                $recentReviews = \App\Models\Review::with('customer', 'pro', 'job')
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
                
                // Top pros
                $topPros = \App\Models\User::where('role', 'professional')
                    ->where('verification_status', 'approved')
                    ->withCount(['assignedJobs as jobs_completed' => function ($q) {
                        $q->where('status', 'completed');
                    }])
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('jobs_completed', 'desc')
                    ->take(5)
                    ->get();
                
                // Search functionality
                $searchResults = null;
                if ($request->has('q')) {
                    $q = $request->input('q');
                    $searchResults = [
                        'users' => \App\Models\User::where('name', 'like', "%{$q}%")
                            ->orWhere('email', 'like', "%{$q}%")
                            ->take(10)
                            ->get(),
                        'jobs' => \App\Models\CustomerJob::where('id', 'like', "%{$q}%")
                            ->orWhere('trade_category', 'like', "%{$q}%")
                            ->orWhere('description', 'like', "%{$q}%")
                            ->with('customer', 'assignedPro')
                            ->take(10)
                            ->get()
                    ];
                }
                
                return view('dashboard.index', compact(
                    'verifiedPros', 'totalCustomers', 'pendingPros', 'pendingProsCount',
                    'jobsThisMonth', 'platformRevenue', 'avgRating',
                    'last12Months', 'tradesBookings', 'recentJobs',
                    'recentReviews', 'topPros', 'searchResults'
                ));
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
