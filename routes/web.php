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
    $ctaBanner   = SiteContentHelper::get('cta_banner', \App\Http\Controllers\Admin\SiteContentController::DEFAULTS['cta_banner']);
    $footerData  = SiteContentHelper::get('footer', \App\Http\Controllers\Admin\SiteContentController::DEFAULTS['footer']);
    $navData     = SiteContentHelper::get('navigation', \App\Http\Controllers\Admin\SiteContentController::DEFAULTS['navigation']);

    return view('welcome', compact(
        'hero', 'statsBar', 'trades', 'howItWorks',
        'ctaBanner', 'footerData', 'navData'
    ));
})->name('home');

// ── Job Search & Post (from homepage CTAs) ──────────────────────────────
Route::get('/job/search', function (\Illuminate\Http\Request $request) {
    $trade = $request->query('trade', '');
    $location = $request->query('location', '');
    session(['pending_job' => ['trade' => $trade, 'location' => $location]]);

    if (!Auth::check()) {
        return redirect()->route('register', ['role' => 'customer']);
    }

    $user = Auth::user();
    if ($user->isCustomer()) {
        return redirect()->route('dashboard.customer');
    }

    return redirect()->route('home')->with('error', 'Please log in as a customer to post a job.');
})->name('job.search');

Route::get('/post-job', function () {
    if (!Auth::check()) {
        session(['pending_job' => ['intent' => 'post-job']]);
        return redirect()->route('register', ['role' => 'customer']);
    }

    $user = Auth::user();
    if ($user->isCustomer()) {
        return redirect()->route('dashboard.customer');
    }

    return redirect()->route('home')->with('error', 'Please log in as a customer to post a job.');
})->name('job.post');

// ── Standalone job create page (for customers coming from search/pre-fill) ──
Route::get('/jobs/create', function (\Illuminate\Http\Request $request) {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    $user = Auth::user();
    if (!$user->isCustomer()) {
        return redirect()->route('home')->with('error', 'Only customers can post jobs.');
    }

    $pending = session('pending_job', []);
    $trade = $request->query('trade', $pending['trade'] ?? '');
    $location = $request->query('location', $pending['location'] ?? '');

    // Clear after reading
    session()->forget('pending_job');

    $tradesData = \App\Helpers\SiteContentHelper::get('browse_trades', \App\Http\Controllers\Admin\SiteContentController::DEFAULTS['browse_trades']);
    $trades = array_filter($tradesData['trades'] ?? [], fn($t) => $t['active'] ?? true);

    return view('jobs.create', compact('trade', 'location', 'trades'));
})->name('jobs.create');

// ── Professional Info Page ────────────────────────────────────────────
Route::get('/professionals/why-join', [\App\Http\Controllers\ProfessionalInfoController::class, 'show'])->name('professionals.why-join');

// ── Contact Page ──────────────────────────────────────────────────────
Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'show'])->name('contact');
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');

// ── Public Pages ─────────────────────────────────────────────────────
Route::get('/about', fn() => view('pages.about'))->name('about');
Route::get('/careers', fn() => view('pages.careers'))->name('careers');
Route::get('/press', fn() => view('pages.press'))->name('press');
Route::get('/resources', fn() => view('pages.resources'))->name('resources');
Route::get('/privacy', fn() => view('pages.privacy'))->name('privacy');
Route::get('/terms', fn() => view('pages.terms'))->name('terms');

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
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer')->middleware(\App\Http\Middleware\RedirectPendingJob::class);
    Route::post('/customer/jobs', [CustomerController::class, 'storeJob'])->name('customer.jobs.store');
    Route::get('/customer/jobs/{job}', [CustomerController::class, 'showJob'])->name('customer.jobs.show');
    Route::post('/customer/jobs/{job}/reschedule', [CustomerController::class, 'rescheduleJob'])->name('customer.jobs.reschedule');
    Route::post('/customer/jobs/{job}/cancel', [CustomerController::class, 'cancelJob'])->name('customer.jobs.cancel');
    Route::post('/customer/jobs/{job}/rebook', [CustomerController::class, 'rebookJob'])->name('customer.jobs.rebook');
    Route::post('/customer/jobs/{job}/review', [CustomerController::class, 'leaveReview'])->name('customer.jobs.review');
    Route::get('/customer/jobs/{job}/pay', [\App\Http\Controllers\PaymentController::class, 'customerPayForm'])->name('customer.jobs.pay');
    Route::post('/customer/jobs/{job}/pay', [\App\Http\Controllers\PaymentController::class, 'customerPaySubmit'])->name('customer.jobs.pay.submit');
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
    Route::post('/professional/jobs/{job}/start',      [\App\Http\Controllers\ProfessionalController::class, 'startJob'])->name('professional.jobs.start');
    Route::post('/professional/jobs/{job}/complete',   [\App\Http\Controllers\ProfessionalController::class, 'markComplete'])->name('professional.jobs.complete');
    Route::post('/professional/jobs/{job}/reschedule', [\App\Http\Controllers\ProfessionalController::class, 'reschedule'])->name('professional.jobs.reschedule');
    Route::post('/professional/profile',               [\App\Http\Controllers\ProfessionalController::class, 'updateProfile'])->name('professional.profile.update');
    Route::post('/professional/password',              [\App\Http\Controllers\ProfessionalController::class, 'changePassword'])->name('professional.password.update');
    Route::post('/professional/payout-request',        [\App\Http\Controllers\PaymentController::class, 'requestPayout'])->name('professional.payout-request');
});

// ── Notifications ─────────────────────────────────────────────────────────────
Route::prefix('notifications')->name('notifications.')->middleware(['auth'])->group(function () {
    Route::get('/', [\App\Http\Controllers\NotificationController::class, 'index'])->name('index');
    Route::get('/api/unread-count', [\App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('unread-count');
    Route::get('/api/recent', [\App\Http\Controllers\NotificationController::class, 'recent'])->name('recent');
    Route::get('/{notification}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('read');
    Route::post('/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('read-all');
});

// ── Messages (for Customers & Pros) ───────────────────────────────────────────
Route::prefix('messages')->name('messages.')->middleware(['auth'])->group(function () {
    Route::get('/', [\App\Http\Controllers\MessageController::class, 'index'])->name('index');
    Route::get('/{id}', [\App\Http\Controllers\MessageController::class, 'show'])->name('show');
    Route::post('/{id}/send', [\App\Http\Controllers\MessageController::class, 'store'])->name('store');
    Route::get('/job/{jobId}', [\App\Http\Controllers\MessageController::class, 'getOrCreate'])->name('job');
    Route::get('/api/unread-count', [\App\Http\Controllers\MessageController::class, 'getUnreadCount'])->name('unread');
    Route::get('/api/{conversationId}/messages', [\App\Http\Controllers\MessageController::class, 'getMessages'])->name('api.messages');
});

// ── Admin Auth & Dashboard ────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout')->middleware('auth');

        Route::middleware([App\Http\Middleware\AdminMiddleware::class])->group(function () {
            Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
                // Basic stats
                $verifiedPros = \App\Models\User::where('role', 'professional')->where('verification_status', 'verified')->count();
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
                
                // Recent contact messages
                $recentMessages = \App\Models\ContactMessage::latest()->take(5)->get();

                // Top pros
                $topPros = \App\Models\User::where('role', 'professional')
                    ->where('verification_status', 'verified')
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
                    'recentReviews', 'topPros', 'searchResults', 'recentMessages'
                ));
            })->name('dashboard');

            Route::post('/pro/{user}/approve', [\App\Http\Controllers\Auth\AdminAuthController::class, 'approvePro'])->name('pro.approve');
            Route::post('/pro/{user}/reject',  [\App\Http\Controllers\Auth\AdminAuthController::class, 'rejectPro'])->name('pro.reject');

            // ── Website Content Management ──────────────────────────
            Route::get('/cms', [SiteContentController::class, 'index'])->name('cms');
            Route::post('/cms/{section}', [SiteContentController::class, 'update'])->name('cms.update');
            Route::post('/cms/{section}/reset', [SiteContentController::class, 'reset'])->name('cms.reset');
            Route::post('/cms/upload/image', [SiteContentController::class, 'uploadImage'])->name('cms.upload');

            // ── Admin Dashboard Pages ───────────────────────────────
            Route::get('/professionals', [\App\Http\Controllers\Admin\AdminController::class, 'professionals'])->name('professionals');
            Route::get('/professionals/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'professionalDetail'])->name('professionals.detail');
            Route::post('/professionals/{id}/toggle', [\App\Http\Controllers\Admin\AdminController::class, 'toggleProfessionalActive'])->name('professionals.toggle');

            Route::get('/customers', [\App\Http\Controllers\Admin\AdminController::class, 'customers'])->name('customers');
            Route::get('/customers/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'customerDetail'])->name('customers.detail');
            Route::post('/customers/{id}/toggle', [\App\Http\Controllers\Admin\AdminController::class, 'toggleCustomerActive'])->name('customers.toggle');

            Route::get('/jobs', [\App\Http\Controllers\Admin\AdminController::class, 'jobs'])->name('jobs');
            Route::get('/jobs/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'jobDetail'])->name('jobs.detail');

            Route::get('/reviews', [\App\Http\Controllers\Admin\AdminController::class, 'reviews'])->name('reviews');
            Route::delete('/reviews/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'deleteReview'])->name('reviews.delete');

            Route::get('/settings', [\App\Http\Controllers\Admin\AdminController::class, 'settings'])->name('settings');
            Route::post('/settings', [\App\Http\Controllers\Admin\AdminController::class, 'updateSettings'])->name('settings.update');

            Route::get('/reports', [\App\Http\Controllers\Admin\AdminController::class, 'reports'])->name('reports');

            // Redirect categories/trades to CMS since we already have that
            Route::get('/categories', function () {
                return redirect()->route('admin.cms');
            })->name('categories');

            // Payments & Payouts
            Route::get('/payments', [\App\Http\Controllers\PaymentController::class, 'adminPayments'])->name('payments');
            Route::post('/payments/{payment}/mark-paid', [\App\Http\Controllers\PaymentController::class, 'adminMarkPaid'])->name('payments.mark-paid');
            Route::post('/payout-requests/{payoutRequest}/process', [\App\Http\Controllers\PaymentController::class, 'adminProcessPayout'])->name('payout-requests.process');

            // Contact Messages
            Route::get('/tickets', function () {
                $messages = \App\Models\ContactMessage::latest()->paginate(20);
                return view('dashboard.admin.tickets', compact('messages'));
            })->name('tickets');
        });
});
