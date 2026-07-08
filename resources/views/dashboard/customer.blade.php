<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - FixIt</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #F5F1EA; color: #1f2937; }
        .heading-underline { position: relative; display: inline-block; }
        .heading-underline::after { content: ''; position: absolute; bottom: -6px; left: 0; width: 40px; height: 3px; background: #E8823C; border-radius: 2px; }
        .tab-active { background: #E8823C; color: white; }
        .tab-inactive { color: white; font-weight: 500; }
        .tab-inactive:hover { background: rgba(232,130,60,0.2); }

        /* Responsive */
        @media (max-width: 640px) {
            header nav { overflow-x: auto; -webkit-overflow-scrolling: touch; }
            header nav a { flex-shrink: 0; }
            .main-content { padding-left: 1rem !important; padding-right: 1rem !important; }
            .post-job-btn { width: 100%; justify-content: center; }
            .modal-inner { padding: 1.25rem !important; margin: 0.5rem; }
            .modal-inner h3 { font-size: 1.25rem !important; }
        }
        @media (max-width: 480px) {
            h1.text-3xl { font-size: 1.5rem !important; }
            h2.text-xl { font-size: 1.15rem !important; }
            .grid.gap-4 > div { padding: 1rem !important; }
            .grid.gap-4 > div .text-2xl { font-size: 1.25rem !important; }
        }
        @media (max-width: 375px) {
            .profile-dropdown-text { display: none !important; }
        }
    </style>
</head>
<body class="min-h-screen">

<!-- Top Bar -->
<header class="bg-[#16302A] px-4 py-4 flex items-center justify-between sticky top-0 z-50 shadow-md">
    <div class="flex items-center gap-2">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H15v-5h-6v5H4a1 1 0 01-1-1V9.5z" fill="#E8823C"/>
                <path d="M9 21v-5h6v5" stroke="#fff" stroke-width="1.2" stroke-linejoin="round"/>
            </svg>
            <span class="text-white text-lg font-bold hidden sm:block">Fix<span class="text-[#E8823C]">It</span></span>
        </a>
    </div>

    <!-- Navigation Tabs -->
    <nav class="flex items-center gap-1 overflow-x-auto">
        <a href="#dashboard" class="tab-link px-2 py-2 rounded-lg tab-active text-xs sm:text-sm font-semibold whitespace-nowrap" data-tab="dashboard">Dashboard</a>
        <a href="#my-jobs" class="tab-link px-2 py-2 rounded-lg tab-inactive text-xs sm:text-sm whitespace-nowrap" data-tab="my-jobs">My Jobs</a>
        <a href="#find-pro" class="tab-link px-2 py-2 rounded-lg tab-inactive text-xs sm:text-sm whitespace-nowrap" data-tab="find-pro">Find a Pro</a>
        <a href="{{ route('messages.index') }}" class="tab-link px-2 py-2 rounded-lg tab-inactive text-xs sm:text-sm whitespace-nowrap">Messages</a>
        <a href="#payments" class="tab-link px-2 py-2 rounded-lg tab-inactive text-xs sm:text-sm whitespace-nowrap" data-tab="payments">Payments</a>
        <a href="#profile" class="tab-link px-2 py-2 rounded-lg tab-inactive text-xs sm:text-sm whitespace-nowrap" data-tab="profile">Profile</a>
    </nav>

    <!-- Right Side -->
    <div class="flex items-center gap-2 sm:gap-4">
        <!-- Notifications -->
        <button class="relative p-2 text-white hover:bg-white/10 rounded-lg transition">
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            @if(Auth::user()->unreadMessagesCount() > 0)
                <span class="absolute -top-1 -right-1 bg-[#E8823C] text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ Auth::user()->unreadMessagesCount() }}</span>
            @endif
        </button>

        <!-- Profile Dropdown -->
        <div class="relative group">
            <div class="flex items-center gap-2 cursor-pointer">
                <div class="w-10 h-10 rounded-full bg-[#E8823C] flex items-center justify-center text-white font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <span class="text-white text-sm font-medium hidden lg:block">{{ Auth::user()->name }}</span>
                <svg width="16" height="16" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
            
            <!-- Dropdown Menu -->
            <div class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-2xl border border-gray-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profile
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426-1.756-2.924-1.756-3.35 0a1.724 1.724 0 001.066-2.573c-1.543.94-3.31-.826-2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    Settings
                </a>
                <div class="border-t border-gray-100 my-2"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-500 hover:bg-red-50 transition">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<!-- Main Content -->
<main class="max-w-7xl mx-auto px-6 py-8">
    @if(session('success'))
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg">{{ session('success') }}</div>
    @endif

    <!-- Dashboard Tab -->
    <div id="dashboard" class="tab-content">
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-[#16302A] mb-2 heading-underline">
                Welcome back, {{ explode(' ', Auth::user()->name)[0] }} 👋
            </h1>
            <p class="text-gray-600 text-sm mt-4">Here's what's happening with your FixIt jobs</p>
        </div>
        <button onclick="document.getElementById('post-job-modal').classList.remove('hidden')" class="mt-4 md:mt-0 bg-[#E8823C] hover:bg-[#c96a2a] text-white font-semibold px-6 py-3 rounded-xl transition flex items-center gap-2">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Post a New Job
        </button>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="bg-[#16302A]/10 text-[#16302A] rounded-full w-12 h-12 flex items-center justify-center">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-[#16302A]">{{ count($activeJobs) }}</div>
                    <div class="text-xs text-gray-500 font-medium">Active Jobs</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="bg-[#E8823C]/10 text-[#E8823C] rounded-full w-12 h-12 flex items-center justify-center">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-[#16302A]">{{ count($completedJobs) }}</div>
                    <div class="text-xs text-gray-500 font-medium">Completed Jobs</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="bg-[#D9A441]/10 text-[#D9A441] rounded-full w-12 h-12 flex items-center justify-center">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-[#16302A]">Rs. {{ number_format($totalSpent, 0) }}</div>
                    <div class="text-xs text-gray-500 font-medium">Total Spent</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="bg-[#16302A]/10 text-[#16302A] rounded-full w-12 h-12 flex items-center justify-center">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-[#16302A]">{{ count($savedPros) }}</div>
                    <div class="text-xs text-gray-500 font-medium">Saved Pros</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Active Job Requests -->
            <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-[#16302A] mb-6 heading-underline">Active Job Requests</h2>
                
                <div class="space-y-4">
                    @if(count($activeJobs) > 0)
                        @foreach($activeJobs as $job)
                        <div class="border border-gray-200 rounded-xl p-4 hover:border-[#E8823C]/50 transition">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start gap-4">
                                    <div class="bg-[#e8f4f1] text-[#16302A] rounded-xl w-12 h-12 flex items-center justify-center flex-shrink-0">
                                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l7-7 3 3-7 7-3-3z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2 2l7.586 7.586"/>
                                            <circle cx="11" cy="11" r="2"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <h3 class="font-semibold text-[#16302A]">{{ $job->trade_category }}</h3>
                                            <span class="text-xs px-2 py-0.5 rounded-full 
                                                @if($job->status == 'pending_match') bg-gray-100 text-gray-700 
                                                @elseif($job->status == 'quotes_received') bg-blue-100 text-blue-700 
                                                @elseif($job->status == 'scheduled') bg-yellow-100 text-yellow-700 
                                                @elseif($job->status == 'in_progress') bg-purple-100 text-purple-700 
                                                @endif
                                                font-medium">
                                                {{ ucwords(str_replace('_', ' ', $job->status)) }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 mb-2">Posted on {{ $job->created_at->format('M d, Y') }}</p>
                                        <p class="text-xs text-gray-600">{{ $job->description }}</p>
                                    </div>
                                </div>
                                <button class="text-[#E8823C] text-xs font-semibold hover:text-[#c96a2a]">View Details</button>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <p class="mb-2">No active jobs yet</p>
                            <button onclick="document.getElementById('post-job-modal').classList.remove('hidden')" class="text-[#E8823C] text-sm font-semibold">Post your first job</button>
                        </div>
                    @endif
                </div>
            </section>

            <!-- Quotes Received -->
            <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-[#16302A] mb-6 heading-underline">Quotes Received</h2>
                
                <div class="space-y-4">
                    @if(count($quotesReceived) > 0)
                        @foreach($quotesReceived as $quote)
                        <div class="border border-gray-200 rounded-xl p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-full bg-[#E8823C] flex items-center justify-center text-white font-bold">
                                        {{ substr($quote->pro->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-[#16302A]">{{ $quote->pro->name }}</h4>
                                        <p class="text-xs text-gray-500">{{ $quote->pro->trade }} • 4.8 ★</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-[#16302A]">Rs. {{ number_format($quote->amount, 0) }}</p>
                                    <p class="text-xs text-gray-500">Quote</p>
                                </div>
                            </div>
                            @if($quote->message)
                                <p class="text-xs text-gray-600 mt-3">{{ $quote->message }}</p>
                            @endif
                            <div class="flex gap-3 mt-4">
                                <form method="POST" action="{{ route('dashboard.customer.quotes.accept', $quote) }}" style="display: inline-block; flex: 1;">
                                    @csrf
                                    <button type="submit" class="w-full bg-[#E8823C] hover:bg-[#c96a2a] text-white font-semibold py-2 px-4 rounded-lg text-sm transition">Accept</button>
                                </form>
                                <form method="POST" action="{{ route('dashboard.customer.quotes.decline', $quote) }}" style="display: inline-block; flex: 1;">
                                    @csrf
                                    <button type="submit" class="w-full border border-gray-300 text-gray-600 font-semibold py-2 px-4 rounded-lg text-sm hover:bg-gray-50 transition">Decline</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <p>No quotes received yet</p>
                        </div>
                    @endif
                </div>
            </section>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Upcoming Bookings -->
            <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-[#16302A] mb-6 heading-underline">Upcoming Bookings</h2>
                
                <div class="space-y-4">
                    @php
                        $bookings = $activeJobs->filter(fn($j) => in_array($j->status, ['scheduled', 'in_progress']));
                    @endphp
                    @if($bookings->count() > 0)
                        @foreach($bookings as $booking)
                            <div class="border-l-4 border-[#E8823C] pl-4 pb-4">
                                <p class="text-xs text-gray-500 mb-1">@php
                                    try {
                                        if (is_string($booking->schedule)) {
                                            echo \Illuminate\Support\Carbon::parse($booking->schedule)->format('D, M j • g:i A');
                                        } elseif (method_exists($booking->schedule, 'format')) {
                                            echo $booking->schedule->format('D, M j • g:i A');
                                        } else {
                                            echo $booking->schedule;
                                        }
                                    } catch (\Exception $e) {
                                        echo $booking->schedule;
                                    }
                                @endphp</p>
                                <h4 class="font-semibold text-[#16302A]">{{ $booking->trade_category }}</h4>
                                @if($booking->assignedPro)
                                    <p class="text-xs text-gray-600 mt-1">with {{ $booking->assignedPro->name }}</p>
                                @endif
                                <p class="text-xs text-gray-500 mt-1">{{ $booking->location }}</p>
                                <div class="flex gap-2 mt-3">
                                    <a href="{{ route('messages.job', $booking->id) }}" class="text-xs bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg font-medium hover:bg-gray-200">Message Pro</a>
                                    <button class="text-xs bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg font-medium hover:bg-gray-200">Reschedule</button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4 text-gray-500">
                            <p>No upcoming bookings</p>
                        </div>
                    @endif
                </div>
            </section>

            <!-- Saved Pros -->
            <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-[#16302A] mb-6 heading-underline">Saved Professionals</h2>
                
                <div class="space-y-3">
                    @if(count($savedPros) > 0)
                        @foreach($savedPros as $pro)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#16302A] flex items-center justify-center text-white font-bold">
                                {{ substr($pro->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-[#16302A] text-sm">{{ $pro->name }}</h4>
                                <p class="text-xs text-[#D9A441]">★ 4.8 • {{ $pro->trade }}</p>
                            </div>
                            <button class="text-[#E8823C] text-xs font-semibold">Hire</button>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4 text-gray-500">
                            <p>No saved pros yet</p>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>

    <!-- Job History -->
    <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
        <h2 class="text-xl font-bold text-[#16302A] mb-6 heading-underline">Job History</h2>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Job</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Professional</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Rating</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @if(count($completedJobs) > 0)
                        @foreach($completedJobs as $job)
                            <tr>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2">
                                        <div class="bg-[#e8f4f1] text-[#16302A] rounded-lg w-8 h-8 flex items-center justify-center">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l7-7 3 3-7 7-3-3z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/>
                                            </svg>
                                        </div>
                                        <span class="font-medium text-[#16302A] text-sm">{{ $job->trade_category }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-sm text-gray-700">
                                    @if($job->assignedPro)
                                        {{ $job->assignedPro->name }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-sm text-gray-600">
                                    @if($job->completed_at)
                                        {{ $job->completed_at->format('M d, Y') }}
                                    @else
                                        {{ $job->created_at->format('M d, Y') }}
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-sm font-semibold text-[#16302A]">
                                    @if($job->amount_paid)
                                        Rs. {{ number_format($job->amount_paid, 0) }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    @if($job->review)
                                        <div class="flex items-center gap-0.5 text-[#D9A441]">
                                            @for ($i = 0; $i < $job->review->rating; $i++)
                                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                            @endfor
                                        </div>
                                    @else
                                        <button class="text-xs bg-[#E8823C] text-white px-3 py-1.5 rounded-lg font-semibold">Leave a Review</button>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <form method="POST" action="{{ route('dashboard.customer.jobs.rebook', $job) }}" class="inline-block">
                                        @csrf
                                        <button type="submit" class="text-xs text-[#E8823C] font-semibold hover:text-[#c96a2a]">Rebook</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500">No completed jobs yet</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </section>

    <!-- Reviews Given -->
    <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
        <h2 class="text-xl font-bold text-[#16302A] mb-6 heading-underline">Your Reviews</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @if(count($reviewsGiven) > 0)
                @foreach($reviewsGiven as $review)
                <div class="bg-[#F5F1EA] rounded-xl p-5 border border-gray-200">
                    <div class="flex items-center gap-0.5 text-[#D9A441] mb-3">
                        @for ($i = 0; $i < $review->rating; $i++)
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        @endfor
                        @for ($i = $review->rating; $i < 5; $i++)
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        @endfor
                    </div>
                    @if($review->comment)
                        <p class="text-sm text-gray-700 mb-3">"{{ $review->comment }}"</p>
                    @endif
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold text-[#16302A]">for {{ $review->pro->name }}</p>
                        <p class="text-xs text-gray-500">{{ $review->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-span-2 text-center py-8 text-gray-500">
                    <p>No reviews yet</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Profile Section -->
    <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-xl font-bold text-[#16302A] mb-6 heading-underline">Profile & Settings</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="font-semibold text-[#16302A] mb-4">Personal Information</h3>
                <form method="POST" action="{{ route('dashboard.customer.profile.update') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-medium text-gray-500 mb-1 block">Full Name</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none">
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 mb-1 block">Email Address</label>
                            <input type="email" name="email" value="{{ Auth::user()->email }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none">
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 mb-1 block">Phone Number</label>
                            <input type="tel" name="phone" value="{{ Auth::user()->phone }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none">
                        </div>
                        <div class="flex justify-end gap-3 mt-4">
                            <button type="submit" class="px-5 py-2.5 bg-[#E8823C] hover:bg-[#c96a2a] text-white font-semibold rounded-lg text-sm transition">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>

            <div>
                <h3 class="font-semibold text-[#16302A] mb-4">Saved Addresses</h3>
                
                <div class="space-y-3 mb-4">
                    @if(count($addresses) > 0)
                        @foreach($addresses as $address)
                        <div class="border border-gray-200 rounded-lg p-3 flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-[#16302A]">{{ $address->label }}</p>
                                <p class="text-xs text-gray-600">{{ $address->address }}</p>
                            </div>
                            <button class="text-xs text-gray-500 hover:text-[#E8823C]">Edit</button>
                        </div>
                        @endforeach
                    @endif
                </div>
                
                <button onclick="document.getElementById('add-address-modal').classList.remove('hidden')" class="text-sm text-[#E8823C] font-semibold flex items-center gap-1">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add New Address
                </button>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="font-semibold text-[#16302A] mb-4">Change Password</h3>
                    <form method="POST" action="{{ route('dashboard.customer.password.update') }}">
                        @csrf
                        <div class="space-y-3">
                            <div>
                                <label class="text-xs font-medium text-gray-500 mb-1 block">Current Password</label>
                                <input type="password" name="current_password" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none">
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 mb-1 block">New Password</label>
                                <input type="password" name="new_password" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none">
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 mb-1 block">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none">
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="text-sm text-[#E8823C] font-semibold">Update Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    </div>

    <!-- My Jobs Tab -->
    <div id="my-jobs" class="tab-content hidden">
        <h1 class="text-3xl font-extrabold text-[#16302A] mb-8 heading-underline">My Jobs</h1>
        <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <h2 class="text-xl font-bold text-[#16302A] mb-6 heading-underline">All Jobs</h2>
            <div class="space-y-4">
                @php
                    $allJobs = $activeJobs->merge($completedJobs);
                @endphp
                @if(count($allJobs) > 0)
                    @foreach($allJobs as $job)
                    <div class="border border-gray-200 rounded-xl p-4 hover:border-[#E8823C]/50 transition">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start gap-4">
                                <div class="bg-[#e8f4f1] text-[#16302A] rounded-xl w-12 h-12 flex items-center justify-center flex-shrink-0">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l7-7 3 3-7 7-3-3z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2 2l7.586 7.586"/>
                                        <circle cx="11" cy="11" r="2"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="font-semibold text-[#16302A]">{{ $job->trade_category }}</h3>
                                        <span class="text-xs px-2 py-0.5 rounded-full 
                                            @if($job->status == 'pending_match') bg-gray-100 text-gray-700 
                                            @elseif($job->status == 'quotes_received') bg-blue-100 text-blue-700 
                                            @elseif($job->status == 'scheduled') bg-yellow-100 text-yellow-700 
                                            @elseif($job->status == 'in_progress') bg-purple-100 text-purple-700 
                                            @elseif($job->status == 'completed') bg-green-100 text-green-700 
                                            @else bg-red-100 text-red-700 
                                            @endif
                                            font-medium">
                                            {{ ucwords(str_replace('_', ' ', $job->status)) }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500 mb-2">Posted on {{ $job->created_at->format('M d, Y') }}</p>
                                    <p class="text-xs text-gray-600">{{ $job->description }}</p>
                                </div>
                            </div>
                            <button class="text-[#E8823C] text-xs font-semibold hover:text-[#c96a2a]">View Details</button>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-8 text-gray-500">
                        <p class="mb-2">No jobs yet</p>
                        <button onclick="document.getElementById('post-job-modal').classList.remove('hidden')" class="text-[#E8823C] text-sm font-semibold">Post your first job</button>
                    </div>
                @endif
            </div>
        </section>
    </div>

    <!-- Find a Pro Tab -->
    <div id="find-pro" class="tab-content hidden">
        <h1 class="text-3xl font-extrabold text-[#16302A] mb-8 heading-underline">Find a Professional</h1>
        <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <p class="text-gray-600">Find a Pro feature coming soon!</p>
        </section>
    </div>

    <!-- Messages Tab: link to dedicated messages page -->
    <div id="messages" class="tab-content hidden">
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <svg width="64" height="64" fill="none" stroke="#9ca3af" stroke-width="1.5" viewBox="0 0 24 24" class="mb-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <h2 class="text-xl font-semibold text-[#16302A] mb-2">Messages</h2>
            <p class="text-gray-500 mb-6">View and manage all your conversations with professionals.</p>
            <a href="{{ route('messages.index') }}" class="inline-flex items-center gap-2 bg-[#E8823C] text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#c96a2a] transition">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                Open Messages
            </a>
        </div>
    </div>

    <!-- Payments Tab -->
    <div id="payments" class="tab-content hidden">
        <h1 class="text-3xl font-extrabold text-[#16302A] mb-8 heading-underline">Payments</h1>
        <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <p class="text-gray-600">Payments feature coming soon!</p>
        </section>
    </div>

    <!-- Profile Tab -->
    <div id="profile" class="tab-content hidden">
        <h1 class="text-3xl font-extrabold text-[#16302A] mb-8 heading-underline">Profile & Settings</h1>
        <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="font-semibold text-[#16302A] mb-4">Personal Information</h3>
                    <form method="POST" action="{{ route('dashboard.customer.profile.update') }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="text-xs font-medium text-gray-500 mb-1 block">Full Name</label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none">
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 mb-1 block">Email Address</label>
                                <input type="email" name="email" value="{{ Auth::user()->email }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none">
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 mb-1 block">Phone Number</label>
                                <input type="tel" name="phone" value="{{ Auth::user()->phone }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none">
                            </div>
                            <div class="flex justify-end gap-3 mt-4">
                                <button type="submit" class="px-5 py-2.5 bg-[#E8823C] hover:bg-[#c96a2a] text-white font-semibold rounded-lg text-sm transition">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div>
                    <h3 class="font-semibold text-[#16302A] mb-4">Saved Addresses</h3>
                    
                    <div class="space-y-3 mb-4">
                        @if(count($addresses) > 0)
                            @foreach($addresses as $address)
                            <div class="border border-gray-200 rounded-lg p-3 flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-semibold text-[#16302A]">{{ $address->label }}</p>
                                    <p class="text-xs text-gray-600">{{ $address->address }}</p>
                                </div>
                                <button class="text-xs text-gray-500 hover:text-[#E8823C]">Edit</button>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    
                    <button onclick="document.getElementById('add-address-modal').classList.remove('hidden')" class="text-sm text-[#E8823C] font-semibold flex items-center gap-1">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add New Address
                    </button>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="font-semibold text-[#16302A] mb-4">Change Password</h3>
                        <form method="POST" action="{{ route('dashboard.customer.password.update') }}">
                            @csrf
                            <div class="space-y-3">
                                <div>
                                    <label class="text-xs font-medium text-gray-500 mb-1 block">Current Password</label>
                                    <input type="password" name="current_password" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none">
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500 mb-1 block">New Password</label>
                                    <input type="password" name="new_password" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none">
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500 mb-1 block">Confirm New Password</label>
                                    <input type="password" name="new_password_confirmation" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none">
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="text-sm text-[#E8823C] font-semibold">Update Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Post Job Modal -->
    <div id="post-job-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[1000]">
        <div class="bg-white rounded-2xl p-8 w-full max-w-md modal-inner">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-[#16302A]">Post a New Job</h3>
                <button onclick="document.getElementById('post-job-modal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('dashboard.customer.jobs.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Trade / Category</label>
                        <select name="trade_category" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none" required>
                            <option value="">Select a trade</option>
                            @foreach($trades as $trade)
                                <option value="{{ $trade['name'] }}">{{ $trade['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Description</label>
                        <textarea name="description" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none" required placeholder="Describe the job you need done..."></textarea>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Location</label>
                        <input type="text" name="location" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none" placeholder="Enter the job location" required>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Budget Type</label>
                        <select name="budget_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none" onchange="toggleBudgetFields(this.value)">
                            <option value="fixed">Fixed Budget</option>
                            <option value="flexible">Flexible</option>
                        </select>
                    </div>
                    <div id="fixed-budget-fields">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-sm font-medium text-gray-700 mb-2 block">Min Budget</label>
                                <input type="number" name="budget_min" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none" placeholder="Min">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-700 mb-2 block">Max Budget</label>
                                <input type="number" name="budget_max" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none" placeholder="Max">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Preferred Schedule</label>
                        <input type="text" name="schedule" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none" placeholder="ASAP or specific date/time" required>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="document.getElementById('post-job-modal').classList.add('hidden')" class="px-5 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-lg text-sm hover:bg-gray-50">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#E8823C] hover:bg-[#c96a2a] text-white font-semibold rounded-lg text-sm transition">Post Job</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Address Modal -->
    <div id="add-address-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[1000]">
        <div class="bg-white rounded-2xl p-8 w-full max-w-md modal-inner">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-[#16302A]">Add New Address</h3>
                <button onclick="document.getElementById('add-address-modal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('dashboard.customer.addresses.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Label (e.g. Home, Work)</label>
                        <input type="text" name="label" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none" required>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Address</label>
                        <textarea name="address" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none" required placeholder="Enter your full address"></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="document.getElementById('add-address-modal').classList.add('hidden')" class="px-5 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-lg text-sm hover:bg-gray-50">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#E8823C] hover:bg-[#c96a2a] text-white font-semibold rounded-lg text-sm transition">Add Address</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleBudgetFields(type) {
            const fixedFields = document.getElementById('fixed-budget-fields');
            if (type === 'flexible') {
                fixedFields.style.display = 'none';
            } else {
                fixedFields.style.display = 'block';
            }
        }

        // Tab switching functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabLinks = document.querySelectorAll('.tab-link');
            const tabContents = document.querySelectorAll('.tab-content');

            tabLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const targetTab = this.getAttribute('data-tab');
                    if (!targetTab) return; // external link, allow normal navigation
                    e.preventDefault();

                    // Update active tab styling
                    tabLinks.forEach(l => {
                        l.classList.remove('tab-active');
                        l.classList.add('tab-inactive');
                    });
                    this.classList.add('tab-active');
                    this.classList.remove('tab-inactive');

                    // Show target tab content, hide others
                    tabContents.forEach(content => {
                        if (content.id === targetTab) {
                            content.classList.remove('hidden');
                        } else {
                            content.classList.add('hidden');
                        }
                    });
                });
            });
        });
    </script>
</main>

</body>
</html>