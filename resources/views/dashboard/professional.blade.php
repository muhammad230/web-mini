<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pro Dashboard - FixIt</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #F5F1EA; color: #1f2937; }
        .heading-underline { position: relative; display: inline-block; }
        .heading-underline::after { content: ''; position: absolute; bottom: -6px; left: 0; width: 40px; height: 3px; background: #E8823C; border-radius: 2px; }
        .tab-active { background: #E8823C; color: white; }
        .tab-inactive { color: white; font-weight: 500; }
        .tab-inactive:hover { background: rgba(232, 130, 60, 0.2); }
        .toggle-switch { position: relative; width: 48px; height: 24px; background: #d1d5db; border-radius: 9999px; cursor: pointer; transition: background 0.3s; }
        .toggle-switch.active { background: #E8823C; }
        .toggle-switch::after { content: ''; position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background: white; border-radius: 9999px; transition: transform 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.2); }
        .toggle-switch.active::after { transform: translateX(24px); }

        /* Responsive */
        @media (max-width: 640px) {
            header nav { overflow-x: auto; -webkit-overflow-scrolling: touch; }
            header nav a { flex-shrink: 0; }
        }
        @media (max-width: 480px) {
            h1.text-3xl { font-size: 1.5rem !important; }
            h2.text-xl { font-size: 1.15rem !important; }
        }
        @media (max-width: 375px) {
            .profile-name { display: none !important; }
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
        <a href="{{ route('dashboard.professional', ['tab' => 'dashboard']) }}" class="px-2 py-2 rounded-lg {{ request('tab', 'dashboard') === 'dashboard' ? 'tab-active' : 'tab-inactive' }} text-xs sm:text-sm font-semibold whitespace-nowrap">Dashboard</a>
        <a href="{{ route('dashboard.professional', ['tab' => 'leads']) }}" class="px-2 py-2 rounded-lg {{ request('tab') === 'leads' ? 'tab-active' : 'tab-inactive' }} text-xs sm:text-sm whitespace-nowrap">Leads</a>
        <a href="{{ route('dashboard.professional', ['tab' => 'jobs']) }}" class="px-2 py-2 rounded-lg {{ request('tab') === 'jobs' ? 'tab-active' : 'tab-inactive' }} text-xs sm:text-sm whitespace-nowrap">My Jobs</a>
        <a href="{{ route('dashboard.professional', ['tab' => 'earnings']) }}" class="px-2 py-2 rounded-lg {{ request('tab') === 'earnings' ? 'tab-active' : 'tab-inactive' }} text-xs sm:text-sm whitespace-nowrap">Earnings</a>
        <a href="{{ route('messages.index') }}" class="px-2 py-2 rounded-lg tab-inactive text-xs sm:text-sm whitespace-nowrap">Messages</a>
        <a href="{{ route('dashboard.professional', ['tab' => 'profile']) }}" class="px-2 py-2 rounded-lg {{ request('tab') === 'profile' || request('tab') === 'settings' ? 'tab-active' : 'tab-inactive' }} text-xs sm:text-sm whitespace-nowrap">Profile</a>
    </nav>

    <!-- Right Side -->
    <div class="flex items-center gap-2 sm:gap-4">
        <!-- Notifications -->
        @include('partials.notification-bell')

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
                <a href="{{ route('dashboard.professional', ['tab' => 'profile']) }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profile
                </a>
                <a href="{{ route('dashboard.professional', ['tab' => 'profile']) }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426-1.756-2.924-1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
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
<main class="max-w-7xl mx-auto px-4 sm:px-6 py-8">

    @if($tab === 'dashboard')
        <!-- Welcome Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-8 gap-4">
            <div class="flex items-center gap-4 flex-wrap">
                <h1 class="text-3xl font-extrabold text-[#16302A] mb-2 heading-underline">
                    Welcome back, {{ explode(' ', $pro->name)[0] }} 👋
                </h1>
                <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">
                    <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    Verified Pro
                </span>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm font-medium text-gray-700">Available for new jobs</span>
                <form method="POST" action="{{ route('dashboard.professional.availability') }}" id="availabilityForm">
                    @csrf
                    <div class="toggle-switch {{ $pro->available ? 'active' : '' }}"
                         onclick="document.getElementById('availabilityForm').submit()"
                         title="{{ $pro->available ? 'Click to go offline' : 'Click to go online' }}"></div>
                </form>
            </div>
        </div>

        {{-- ── Profile completion banner for brand-new pros ── --}}
        @php $profileComplete = !empty($pro->trade) && !empty($pro->location); @endphp
        @if(!$profileComplete)
        <div class="mb-6 bg-amber-50 border border-amber-200 rounded-2xl px-6 py-4 flex items-start gap-4">
            <svg class="flex-shrink-0 mt-0.5 text-amber-500 w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
            <div class="flex-1">
                <p class="font-semibold text-amber-800 text-sm mb-1">Complete your profile to start receiving leads</p>
                <p class="text-amber-700 text-xs">
                    @if(empty($pro->trade))
                        Your <strong>trade/specialty</strong> is not set — leads are matched by trade, so you won't see any until you set it.
                    @elseif(empty($pro->location))
                        Your <strong>location</strong> is not set — leads are filtered by location, so set yours to start matching.
                    @endif
                    Scroll down to <strong>Profile &amp; Portfolio</strong> to complete your setup.
                </p>
            </div>
            <a href="#profile-section"
               class="flex-shrink-0 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors">
                Complete Profile
            </a>
        </div>
        @endif

        <!-- Quick Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="bg-[#16302A]/10 text-[#16302A] rounded-full w-12 h-12 flex items-center justify-center">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-[#16302A]">{{ $stats['new_leads'] }}</div>
                        <div class="text-xs text-gray-500 font-medium">New Leads</div>
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
                        <div class="text-2xl font-bold text-[#16302A]">{{ $stats['active_jobs'] }}</div>
                        <div class="text-xs text-gray-500 font-medium">Active Jobs</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="bg-[#16302A]/10 text-[#16302A] rounded-full w-12 h-12 flex items-center justify-center">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-[#16302A]">{{ $stats['jobs_completed'] }}</div>
                        <div class="text-xs text-gray-500 font-medium">Jobs Completed</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="bg-[#D9A441]/10 text-[#D9A441] rounded-full w-12 h-12 flex items-center justify-center">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-[#16302A]">Rs. {{ number_format($stats['total_earnings']) }}</div>
                        <div class="text-xs text-gray-500 font-medium">Total Earnings</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 col-span-2 md:col-span-1">
                <div class="flex items-center gap-3">
                    <div class="bg-[#16302A]/10 text-[#16302A] rounded-full w-12 h-12 flex items-center justify-center">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="text-2xl font-bold text-[#16302A]">{{ $stats['avg_rating'] > 0 ? $stats['avg_rating'] : 'N/A' }}</div>
                        <div class="flex items-center gap-0.5 text-[#D9A441]">
                            @for($i = 1; $i <= 5; $i++)
                                <svg width="12" height="12" fill="{{ $i <= round($stats['avg_rating']) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            @endfor
                        </div>
                        <div class="text-xs text-gray-500 font-medium">Avg Rating ({{ $stats['review_count'] }} reviews)</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            {{-- ── NEW LEADS (left 2/3) ── --}}
            <div class="lg:col-span-2">
                <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-[#16302A] heading-underline">New Leads</h2>
                        @if($pro->available)
                            <span class="text-xs font-semibold text-green-700 bg-green-100 px-3 py-1 rounded-full">● Online</span>
                        @else
                            <span class="text-xs font-semibold text-gray-500 bg-gray-100 px-3 py-1 rounded-full">● Offline</span>
                        @endif
                    </div>

                    @if(session('success'))
                        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">{{ session('success') }}</div>
                    @endif
                    @if(session('info'))
                        <div class="mb-4 px-4 py-3 bg-blue-50 border border-blue-200 text-blue-700 rounded-xl text-sm">{{ session('info') }}</div>
                    @endif

                    @if(!$pro->available)
                        <div class="text-center py-12 text-gray-400">
                            <svg class="mx-auto mb-3 w-12 h-12 opacity-40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                            <p class="font-semibold text-gray-500">You're offline</p>
                            <p class="text-xs mt-1">Toggle "Available for new jobs" to start receiving leads</p>
                        </div>
                    @elseif($newLeads->isEmpty())
                        <div class="text-center py-12 text-gray-400">
                            <svg class="mx-auto mb-3 w-12 h-12 opacity-40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <p class="font-semibold text-gray-500">No new leads right now</p>
                            <p class="text-xs mt-1">New jobs matching your trade will appear here automatically</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($newLeads as $lead)
                            @php
                                $tradeColors = [
                                    'Plumbing'        => ['bg'=>'#e8f4f1','color'=>'#1b3a30'],
                                    'Electrical'      => ['bg'=>'#fff8e6','color'=>'#d4900a'],
                                    'Carpentry'       => ['bg'=>'#fef3ee','color'=>'#e07b39'],
                                    'Painting'        => ['bg'=>'#fef0f0','color'=>'#e07b39'],
                                    'AC Repair'       => ['bg'=>'#eef6fb','color'=>'#3b82f6'],
                                    'Cleaning'        => ['bg'=>'#e8f4f1','color'=>'#1b3a30'],
                                    'Appliance Repair'=> ['bg'=>'#f0eef8','color'=>'#7c3aed'],
                                    'Handyman'        => ['bg'=>'#faf3e8','color'=>'#92400e'],
                                ];
                                $tc = $tradeColors[$lead->trade_category] ?? ['bg'=>'#f5f5f5','color'=>'#333'];
                            @endphp
                            <div class="border border-gray-200 rounded-xl p-4 hover:border-[#E8823C]/50 transition" id="lead-{{ $lead->id }}">
                                <div class="flex items-start justify-between gap-4 flex-wrap">
                                    <div class="flex items-start gap-3 flex-1">
                                        <div class="rounded-xl w-11 h-11 flex items-center justify-center flex-shrink-0 text-sm font-bold"
                                             style="background:{{ $tc['bg'] }}; color:{{ $tc['color'] }}">
                                            {{ strtoupper(substr($lead->trade_category, 0, 2)) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <h4 class="font-semibold text-[#16302A] text-sm">{{ $lead->customer_first_name }} needs a {{ $lead->trade_category }}</h4>
                                                <span class="text-xs px-2 py-0.5 rounded-full font-semibold" style="background:{{ $tc['bg'] }}; color:{{ $tc['color'] }}">{{ $lead->trade_category }}</span>
                                            </div>
                                            <p class="text-xs text-gray-600 mt-1 line-clamp-2">{{ $lead->description }}</p>
                                            <div class="flex items-center flex-wrap gap-3 mt-2 text-xs text-gray-500">
                                                <span>📍 {{ $lead->location }}</span>
                                                @if($lead->budget_min || $lead->budget_max)
                                                    <span>💰 Rs. {{ number_format($lead->budget_min) }} – {{ number_format($lead->budget_max) }}</span>
                                                @endif
                                                <span>⏰ {{ $lead->time_ago }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex gap-2 flex-shrink-0">
                                        {{-- Send Quote modal trigger --}}
                                        <button onclick="openQuoteModal({{ $lead->id }}, '{{ addslashes($lead->trade_category) }}')"
                                                class="bg-[#E8823C] hover:bg-[#c96a2a] text-white font-semibold px-4 py-2 rounded-lg text-xs transition">
                                            Send Quote
                                        </button>
                                        <form method="POST" action="{{ route('dashboard.professional.leads.skip', $lead->id) }}">
                                            @csrf
                                            <button type="submit" class="border border-gray-300 text-gray-600 font-semibold px-4 py-2 rounded-lg text-xs hover:bg-gray-50 transition">Skip</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </section>
            </div>

            {{-- ── RIGHT COLUMN ── --}}
            <div class="space-y-6">

                {{-- Active / Scheduled Jobs --}}
                <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-xl font-bold text-[#16302A] mb-6 heading-underline">Active Jobs</h2>
                    @if($activeJobs->isEmpty())
                        <p class="text-sm text-gray-400 text-center py-6">No active jobs right now.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($activeJobs as $job)
                            @php
                                $borderColor = $job->status === 'in_progress' ? '#22c55e' : '#E8823C';
                                $badgeBg     = $job->status === 'in_progress' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700';
                                $badgeLabel  = $job->status === 'in_progress' ? 'In Progress' : 'Scheduled';
                            @endphp
                            <div class="border-l-4 pl-4 pb-4" style="border-color:{{ $borderColor }}">
                                <h4 class="font-semibold text-[#16302A] text-sm">{{ $job->trade_category }}</h4>
                                <p class="text-xs text-gray-600 mt-1">{{ $job->customer_name }} • @php
                                    try {
                                        if (is_string($job->schedule)) {
                                            echo \Illuminate\Support\Carbon::parse($job->schedule)->format('D, M j • g:i A');
                                        } elseif (method_exists($job->schedule, 'format')) {
                                            echo $job->schedule->format('D, M j • g:i A');
                                        } else {
                                            echo 'TBD';
                                        }
                                    } catch (\Exception $e) {
                                        echo $job->schedule;
                                    }
                                @endphp</p>
                                <p class="text-xs text-gray-500">{{ $job->location }}</p>
                                <span class="inline-block mt-2 text-xs px-2 py-1 rounded-full font-medium {{ $badgeBg }}">{{ $badgeLabel }}</span>
                                <div class="flex gap-2 mt-3 flex-wrap">
                                    <a href="{{ route('messages.job', $job->id) }}" class="text-xs bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg font-medium hover:bg-gray-200">Message Customer</a>
                                    @if($job->status === 'in_progress')
                                        <form method="POST" action="{{ route('dashboard.professional.jobs.complete', $job->id) }}">
                                            @csrf
                                            <button class="text-xs bg-[#E8823C] text-white px-3 py-1.5 rounded-lg font-medium">Mark Complete</button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('dashboard.professional.jobs.reschedule', $job->id) }}" class="inline" onsubmit="return confirmReschedule(this)">
                                        @csrf
                                        <input type="hidden" name="schedule" id="reschedule_{{ $job->id }}">
                                        <button type="button" onclick="promptReschedule({{ $job->id }})" class="text-xs bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg font-medium hover:bg-gray-200">Reschedule</button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </section>

                {{-- Earnings Panel --}}
                <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-xl font-bold text-[#16302A] mb-6 heading-underline">Earnings</h2>
                    <div class="grid grid-cols-2 gap-4 mb-5">
                        <div class="bg-[#F5F1EA] rounded-xl p-4 text-center">
                            <p class="text-xs text-gray-500 font-medium mb-1">This Month (net)</p>
                            <p class="text-xl font-bold text-[#16302A]">Rs. {{ number_format($earnings['this_month']) }}</p>
                        </div>
                        <div class="bg-[#F5F1EA] rounded-xl p-4 text-center">
                            <p class="text-xs text-gray-500 font-medium mb-1">Total Earned</p>
                            <p class="text-xl font-bold text-[#D9A441]">Rs. {{ number_format($earnings['total_earned']) }}</p>
                        </div>
                    </div>
                    <div class="text-xs space-y-1.5 mb-4 px-1">
                        <div class="flex justify-between"><span class="text-gray-500">Platform Fee ({{ \App\Http\Controllers\PaymentController::PLATFORM_FEE_PERCENT }}%)</span><span class="text-gray-400">- Rs. {{ number_format($earnings['platform_fee']) }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Net Payout Amount</span><span class="font-semibold text-[#16302A]">Rs. {{ number_format($earnings['net_payout']) }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Paid Out</span><span class="text-green-700 font-medium">Rs. {{ number_format($earnings['paid_out']) }}</span></div>
                        <div class="flex justify-between border-t border-gray-100 pt-1.5"><span class="font-semibold text-gray-700">Pending Payout</span><span class="font-bold text-[#D9A441]">Rs. {{ number_format($earnings['pending_payout']) }}</span></div>
                    </div>
                    {{-- Withdraw / Payout Request --}}
                    @if($earnings['pending_payout'] > 0)
                    <form method="POST" action="{{ route('dashboard.professional.payout-request') }}">
                        @csrf
                        <button type="submit" class="w-full bg-[#16302A] text-white font-semibold py-2.5 px-4 rounded-lg text-sm mb-1 hover:bg-[#1e4238]">Withdraw Funds — Rs. {{ number_format($earnings['pending_payout']) }}</button>
                    </form>
                    @else
                    <button disabled class="w-full bg-gray-200 text-gray-500 font-semibold py-2.5 px-4 rounded-lg text-sm mb-1 cursor-not-allowed">Withdraw Funds</button>
                    @endif
                    <p class="text-xs text-center text-gray-400 mb-4">Manual tracking — admin processes payouts</p>
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Recent Payments</h4>
                    <div class="space-y-2 text-xs max-h-48 overflow-y-auto">
                        @forelse($earnings['payout_history'] as $p)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <div>
                                <p class="font-medium text-gray-800">{{ $p->date }}</p>
                                <p class="text-gray-500">{{ $p->trade_category }} — {{ $p->customer_name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-800">Rs. {{ number_format($p->amount) }}</p>
                                <span class="text-green-600 font-medium">Paid</span>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-400 text-center py-4">No payments yet.</p>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>

        {{-- ── JOB HISTORY ── --}}
        <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <h2 class="text-xl font-bold text-[#16302A] mb-6 heading-underline">Job History</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-xs sm:text-sm">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-4 text-gray-500 font-semibold uppercase tracking-wide">Customer</th>
                            <th class="text-left py-3 px-4 text-gray-500 font-semibold uppercase tracking-wide">Service</th>
                            <th class="text-left py-3 px-4 text-gray-500 font-semibold uppercase tracking-wide">Date</th>
                            <th class="text-left py-3 px-4 text-gray-500 font-semibold uppercase tracking-wide">Earned</th>
                            <th class="text-left py-3 px-4 text-gray-500 font-semibold uppercase tracking-wide">Rating</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($jobHistory as $job)
                        <tr>
                            <td class="py-3 px-4 font-medium text-gray-800">{{ $job->customer_name }}</td>
                            <td class="py-3 px-4 text-gray-700">{{ $job->trade_category }}</td>
                            <td class="py-3 px-4 text-gray-600">@php
                                    try {
                                        echo \Illuminate\Support\Carbon::parse($job->updated_at)->format('M j, Y');
                                    } catch (\Exception $e) {
                                        echo $job->updated_at;
                                    }
                                @endphp</td>
                            <td class="py-3 px-4 font-bold text-gray-800">{{ $job->earned ? 'Rs. '.number_format($job->earned) : '—' }}</td>
                            <td class="py-3 px-4">
                                @if($job->review_rating)
                                    <div class="flex items-center gap-0.5 text-[#D9A441]">
                                        @for($i=1;$i<=5;$i++)
                                            <svg width="12" height="12" fill="{{ $i<=$job->review_rating?'currentColor':'none' }}" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                        @endfor
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">Not rated yet</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="py-8 text-center text-gray-400 text-sm">No completed jobs yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        {{-- ── REVIEWS RECEIVED ── --}}
        <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <h2 class="text-xl font-bold text-[#16302A] mb-6 heading-underline">Reviews Received</h2>
            @if($reviews->isEmpty())
                <p class="text-sm text-gray-400 text-center py-8">No reviews yet — complete jobs to start earning reviews.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($reviews as $review)
                    <div class="bg-[#F5F1EA] rounded-xl p-5 border border-gray-200">
                        <div class="flex items-center gap-0.5 text-[#D9A441] mb-3">
                            @for($i=1;$i<=5;$i++)
                                <svg width="16" height="16" fill="{{ $i<=$review->rating?'currentColor':'none' }}" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            @endfor
                        </div>
                        <p class="text-sm text-gray-700 mb-3">"{{ $review->comment ?? 'No comment left.' }}"</p>
                        <div class="flex items-center justify-between">
                            <p class="text-xs font-semibold text-[#16302A]">— {{ explode(' ', $review->customer_name)[0] }}</p>
                            <p class="text-xs text-gray-500">@php
                                    try {
                                        echo \Illuminate\Support\Carbon::parse($review->created_at)->format('M j, Y');
                                    } catch (\Exception $e) {
                                        echo $review->created_at;
                                    }
                                @endphp</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </section>
    @endif

    @if($tab === 'leads')
        <!-- Leads Page -->
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-[#16302A] mb-6 heading-underline">New Leads</h1>
            
            @if(session('success'))
                <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">{{ session('success') }}</div>
            @endif
            @if(session('info'))
                <div class="mb-4 px-4 py-3 bg-blue-50 border border-blue-200 text-blue-700 rounded-xl text-sm">{{ session('info') }}</div>
            @endif

            @if(!$pro->available)
                <div class="text-center py-12 text-gray-400 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <svg class="mx-auto mb-3 w-12 h-12 opacity-40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                    <p class="font-semibold text-gray-500">You're offline</p>
                    <p class="text-xs mt-1">Toggle "Available for new jobs" to start receiving leads</p>
                </div>
            @elseif($newLeads->isEmpty())
                <div class="text-center py-12 text-gray-400 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <svg class="mx-auto mb-3 w-12 h-12 opacity-40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <p class="font-semibold text-gray-500">No new leads right now</p>
                    <p class="text-xs mt-1">New jobs matching your trade will appear here automatically</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($newLeads as $lead)
                    @php
                        $tradeColors = [
                            'Plumbing'        => ['bg'=>'#e8f4f1','color'=>'#1b3a30'],
                            'Electrical'      => ['bg'=>'#fff8e6','color'=>'#d4900a'],
                            'Carpentry'       => ['bg'=>'#fef3ee','color'=>'#e07b39'],
                            'Painting'        => ['bg'=>'#fef0f0','color'=>'#e07b39'],
                            'AC Repair'       => ['bg'=>'#eef6fb','color'=>'#3b82f6'],
                            'Cleaning'        => ['bg'=>'#e8f4f1','color'=>'#1b3a30'],
                            'Appliance Repair'=> ['bg'=>'#f0eef8','color'=>'#7c3aed'],
                            'Handyman'        => ['bg'=>'#faf3e8','color'=>'#92400e'],
                        ];
                        $tc = $tradeColors[$lead->trade_category] ?? ['bg'=>'#f5f5f5','color'=>'#333'];
                    @endphp
                    <div class="border border-gray-200 rounded-xl p-6 hover:border-[#E8823C]/50 transition bg-white shadow-sm" id="lead-{{ $lead->id }}">
                        <div class="flex items-start justify-between gap-4 flex-wrap">
                            <div class="flex items-start gap-4 flex-1">
                                <div class="rounded-xl w-14 h-14 flex items-center justify-center flex-shrink-0 text-lg font-bold"
                                     style="background:{{ $tc['bg'] }}; color:{{ $tc['color'] }}">
                                    {{ strtoupper(substr($lead->trade_category, 0, 2)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-3 flex-wrap mb-2">
                                        <h4 class="font-bold text-[#16302A] text-lg">{{ $lead->customer_first_name }} needs a {{ $lead->trade_category }}</h4>
                                        <span class="text-sm px-3 py-1 rounded-full font-semibold" style="background:{{ $tc['bg'] }}; color:{{ $tc['color'] }}">{{ $lead->trade_category }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-3">{{ $lead->description }}</p>
                                    <div class="flex items-center flex-wrap gap-4 text-sm text-gray-500">
                                        <span>📍 {{ $lead->location }}</span>
                                        @if($lead->budget_min || $lead->budget_max)
                                            <span>💰 Rs. {{ number_format($lead->budget_min) }} – {{ number_format($lead->budget_max) }}</span>
                                        @endif
                                        <span>⏰ {{ $lead->time_ago }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-3 flex-shrink-0">
                                {{-- Send Quote modal trigger --}}
                                <button onclick="openQuoteModal({{ $lead->id }}, '{{ addslashes($lead->trade_category) }}')"
                                        class="bg-[#E8823C] hover:bg-[#c96a2a] text-white font-semibold px-6 py-3 rounded-lg text-sm transition">
                                    Send Quote
                                </button>
                                <form method="POST" action="{{ route('dashboard.professional.leads.skip', $lead->id) }}">
                                    @csrf
                                    <button type="submit" class="border border-gray-300 text-gray-600 font-semibold px-6 py-3 rounded-lg text-sm hover:bg-gray-50 transition">Skip</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    @if($tab === 'jobs')
        <!-- Jobs Page -->
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-[#16302A] mb-6 heading-underline">My Jobs</h1>
            
            <!-- Active Jobs Section -->
            <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
                <h2 class="text-xl font-bold text-[#16302A] mb-6 heading-underline">Active Jobs</h2>
                @if($activeJobs->isEmpty())
                    <p class="text-sm text-gray-400 text-center py-6">No active jobs right now.</p>
                @else
                    <div class="space-y-4">
                        @foreach($activeJobs as $job)
                        @php
                            $borderColor = $job->status === 'in_progress' ? '#22c55e' : '#E8823C';
                            $badgeBg     = $job->status === 'in_progress' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700';
                            $badgeLabel  = $job->status === 'in_progress' ? 'In Progress' : 'Scheduled';
                        @endphp
                        <div class="border-l-4 pl-6 pb-6" style="border-color:{{ $borderColor }}">
                            <h4 class="font-bold text-[#16302A] text-lg">{{ $job->trade_category }}</h4>
                            <p class="text-sm text-gray-600 mt-2">{{ $job->customer_name }} • @php
                                try {
                                    if (is_string($job->schedule)) {
                                        echo \Illuminate\Support\Carbon::parse($job->schedule)->format('D, M j • g:i A');
                                    } elseif (method_exists($job->schedule, 'format')) {
                                        echo $job->schedule->format('D, M j • g:i A');
                                    } else {
                                        echo 'TBD';
                                    }
                                } catch (\Exception $e) {
                                    echo $job->schedule;
                                }
                            @endphp</p>
                            <p class="text-sm text-gray-500 mt-1">{{ $job->location }}</p>
                            <span class="inline-block mt-3 text-sm px-3 py-1 rounded-full font-medium {{ $badgeBg }}">{{ $badgeLabel }}</span>
                            <div class="flex gap-3 mt-4 flex-wrap">
                                <a href="{{ route('messages.job', $job->id) }}" class="text-sm bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-200">Message Customer</a>
                                @if($job->status === 'in_progress')
                                    <form method="POST" action="{{ route('dashboard.professional.jobs.complete', $job->id) }}">
                                        @csrf
                                        <button class="text-sm bg-[#E8823C] text-white px-4 py-2 rounded-lg font-medium">Mark Complete</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('dashboard.professional.jobs.reschedule', $job->id) }}" class="inline" onsubmit="return confirmReschedule(this)">
                                    @csrf
                                    <input type="hidden" name="schedule" id="reschedule_{{ $job->id }}">
                                    <button type="button" onclick="promptReschedule({{ $job->id }})" class="text-sm bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-200">Reschedule</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <!-- Job History Section -->
            <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-[#16302A] mb-6 heading-underline">Job History</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-4 px-4 text-gray-500 font-semibold uppercase tracking-wide">Customer</th>
                                <th class="text-left py-4 px-4 text-gray-500 font-semibold uppercase tracking-wide">Service</th>
                                <th class="text-left py-4 px-4 text-gray-500 font-semibold uppercase tracking-wide">Date</th>
                                <th class="text-left py-4 px-4 text-gray-500 font-semibold uppercase tracking-wide">Earned</th>
                                <th class="text-left py-4 px-4 text-gray-500 font-semibold uppercase tracking-wide">Rating</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($jobHistory as $job)
                            <tr>
                                <td class="py-4 px-4 font-medium text-gray-800">{{ $job->customer_name }}</td>
                                <td class="py-4 px-4 text-gray-700">{{ $job->trade_category }}</td>
                                <td class="py-4 px-4 text-gray-600">@php
                                        try {
                                            echo \Illuminate\Support\Carbon::parse($job->updated_at)->format('M j, Y');
                                        } catch (\Exception $e) {
                                            echo $job->updated_at;
                                        }
                                    @endphp</td>
                                <td class="py-4 px-4 font-bold text-gray-800">{{ $job->earned ? 'Rs. '.number_format($job->earned) : '—' }}</td>
                                <td class="py-4 px-4">
                                    @if($job->review_rating)
                                        <div class="flex items-center gap-0.5 text-[#D9A441]">
                                            @for($i=1;$i<=5;$i++)
                                                <svg width="14" height="14" fill="{{ $i<=$job->review_rating?'currentColor':'none' }}" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                            @endfor
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400 italic">Not rated yet</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="py-12 text-center text-gray-400 text-sm">No completed jobs yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    @endif

    @if($tab === 'earnings')
        <!-- Earnings Page -->
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-[#16302A] mb-6 heading-underline">Earnings</h1>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-xs font-medium text-gray-500 mb-1">Total Earned</h3>
                    <p class="text-2xl font-bold text-[#16302A]">Rs. {{ number_format($earnings['total_earned']) }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-xs font-medium text-gray-500 mb-1">Platform Fee</h3>
                    <p class="text-2xl font-bold text-gray-500">- Rs. {{ number_format($earnings['platform_fee']) }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-xs font-medium text-gray-500 mb-1">Net Payout</h3>
                    <p class="text-2xl font-bold text-[#D9A441]">Rs. {{ number_format($earnings['net_payout']) }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-xs font-medium text-gray-500 mb-1">Pending Payout</h3>
                    <p class="text-2xl font-bold text-[#E8823C]">Rs. {{ number_format($earnings['pending_payout']) }}</p>
                </div>
            </div>

            <!-- Withdraw -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-[#16302A]">Withdraw Funds</h2>
                        <p class="text-sm text-gray-500">Manual tracking — submit a payout request and admin will process it.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        @if($earnings['pending_payout'] > 0)
                        <form method="POST" action="{{ route('dashboard.professional.payout-request') }}">
                            @csrf
                            <button type="submit" class="bg-[#16302A] text-white font-bold py-3 px-6 rounded-xl text-sm hover:bg-[#1e4238]">Request Payout — Rs. {{ number_format($earnings['pending_payout']) }}</button>
                        </form>
                        @else
                        <button disabled class="bg-gray-200 text-gray-500 font-bold py-3 px-6 rounded-xl text-sm cursor-not-allowed">No payout available</button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Payment History -->
            <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
                <h2 class="text-xl font-bold text-[#16302A] mb-6 heading-underline">Payment History</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-xs sm:text-sm">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 text-gray-500 font-semibold uppercase tracking-wide">Date</th>
                                <th class="text-left py-3 px-4 text-gray-500 font-semibold uppercase tracking-wide">Job</th>
                                <th class="text-left py-3 px-4 text-gray-500 font-semibold uppercase tracking-wide">Customer</th>
                                <th class="text-right py-3 px-4 text-gray-500 font-semibold uppercase tracking-wide">Amount</th>
                                <th class="text-right py-3 px-4 text-gray-500 font-semibold uppercase tracking-wide">Fee</th>
                                <th class="text-right py-3 px-4 text-gray-500 font-semibold uppercase tracking-wide">Payout</th>
                                <th class="text-center py-3 px-4 text-gray-500 font-semibold uppercase tracking-wide">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($earnings['payout_history'] as $p)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-4 text-gray-700">{{ $p->date }}</td>
                                <td class="py-4 px-4 font-medium text-[#16302A]">{{ $p->trade_category }}</td>
                                <td class="py-4 px-4 text-gray-600">{{ $p->customer_name }}</td>
                                <td class="py-4 px-4 text-right font-semibold">Rs. {{ number_format($p->amount) }}</td>
                                <td class="py-4 px-4 text-right text-gray-500">- Rs. {{ number_format($p->fee) }}</td>
                                <td class="py-4 px-4 text-right font-semibold text-[#16302A]">Rs. {{ number_format($p->payout) }}</td>
                                <td class="py-4 px-4 text-center"><span class="text-green-700 bg-green-100 text-xs font-semibold px-2.5 py-1 rounded-full">Paid</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="py-12 text-center text-gray-400 text-sm">No payments yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Payout Requests -->
            <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-[#16302A] mb-6 heading-underline">Payout Requests</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-xs sm:text-sm">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 text-gray-500 font-semibold uppercase tracking-wide">Date</th>
                                <th class="text-right py-3 px-4 text-gray-500 font-semibold uppercase tracking-wide">Amount</th>
                                <th class="text-center py-3 px-4 text-gray-500 font-semibold uppercase tracking-wide">Status</th>
                                <th class="text-left py-3 px-4 text-gray-500 font-semibold uppercase tracking-wide">Notes</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($earnings['payout_requests'] as $pr)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-4 text-gray-700">{{ $pr->created_at->format('M j, Y') }}</td>
                                <td class="py-4 px-4 text-right font-semibold">Rs. {{ number_format($pr->amount) }}</td>
                                <td class="py-4 px-4 text-center">
                                    @if($pr->status === 'paid')
                                        <span class="text-green-700 bg-green-100 text-xs font-semibold px-2.5 py-1 rounded-full">Paid</span>
                                    @elseif($pr->status === 'approved')
                                        <span class="text-blue-700 bg-blue-100 text-xs font-semibold px-2.5 py-1 rounded-full">Approved</span>
                                    @elseif($pr->status === 'rejected')
                                        <span class="text-red-700 bg-red-100 text-xs font-semibold px-2.5 py-1 rounded-full">Rejected</span>
                                    @else
                                        <span class="text-yellow-700 bg-yellow-100 text-xs font-semibold px-2.5 py-1 rounded-full">Pending</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-gray-600 text-xs">{{ $pr->admin_notes ?? '—' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="py-12 text-center text-gray-400 text-sm">No payout requests yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    @endif

    @if($tab === 'profile' || $tab === 'settings')
        {{-- ── PROFILE &amp; PORTFOLIO SECTION ── --}}
        <section id="profile-section" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <h2 class="text-xl font-bold text-[#16302A] mb-6 heading-underline">Profile &amp; Portfolio</h2>
            <form method="POST" action="{{ route('dashboard.professional.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @if(session('success'))
                    <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">{{ session('success') }}</div>
                @endif
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <h3 class="font-semibold text-[#16302A] mb-4">Basic Information</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500 mb-2 block">Full Name</label>
                                <input type="text" value="{{ $pro->name }}" disabled class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm bg-gray-50 text-gray-500">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 mb-2 block">Email</label>
                                <input type="email" value="{{ $pro->email }}" disabled class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm bg-gray-50 text-gray-500">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 mb-2 block">Bio</label>
                                <textarea name="bio" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] outline-none">{{ $pro->bio ?? '' }}</textarea>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 mb-2 block">Trade / Specialty <span class="text-red-400">*</span> <span class="text-gray-400 font-normal">(drives lead matching)</span></label>
                                <select name="trade" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] outline-none">
                                    <option value="">Select your trade</option>
                                    @foreach(['Plumbing','Electrical','Carpentry','Painting','AC Repair','Cleaning','Appliance Repair','Handyman'] as $t)
                                        <option value="{{ $t }}" {{ $pro->trade === $t ? 'selected' : '' }}>{{ $t }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 mb-2 block">Years of Experience</label>
                                <input type="number" name="years_experience" value="{{ $pro->years_experience ?? '' }}" min="0" max="50" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] outline-none">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 mb-2 block">Starting Price (Rs.)</label>
                                <input type="number" name="starting_price" value="{{ $pro->starting_price ?? '' }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] outline-none">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 mb-2 block">Service Area / Location <span class="text-gray-400 font-normal">(drives lead matching)</span></label>
                                <input type="text" name="location" value="{{ $pro->location ?? '' }}" placeholder="e.g. Karachi, DHA" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] outline-none">
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-[#16302A] mb-4">Photo &amp; Security</h3>
                        <div class="mb-6">
                            <label class="text-sm font-medium text-gray-500 mb-2 block">Profile Photo</label>
                            @if($pro->profile_photo)
                                <img src="{{ asset('storage/' . $pro->profile_photo) }}" class="w-24 h-24 rounded-full object-cover mb-4">
                            @endif
                            <input type="file" name="profile_photo" accept="image/*" class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#E8823C] file:text-white file:font-semibold file:text-sm hover:file:bg-[#c96a2a]">
                            <p class="text-sm text-gray-400 mt-2">Max 2MB. JPG or PNG.</p>
                        </div>
                        <div class="mb-6">
                            <label class="text-sm font-medium text-gray-500 mb-2 block">Portfolio / Work Photos</label>
                            <div class="border-2 border-dashed border-gray-200 rounded-lg p-6 text-center bg-[#F5F1EA]">
                                <p class="text-sm text-gray-400">Portfolio uploads coming soon</p>
                            </div>
                        </div>

                        {{-- Change password --}}
                        <h3 class="font-semibold text-[#16302A] mb-4">Change Password</h3>
                        <form method="POST" action="{{ route('dashboard.professional.password.update') }}" class="space-y-4">
                            @csrf
                            @if($errors->has('current_password'))
                                <p class="text-red-500 text-sm">{{ $errors->first('current_password') }}</p>
                            @endif
                            <input type="password" name="current_password" placeholder="Current password" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm outline-none focus:ring-2 focus:ring-[#E8823C]">
                            <input type="password" name="password" placeholder="New password (min 8 chars)" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm outline-none focus:ring-2 focus:ring-[#E8823C]">
                            <input type="password" name="password_confirmation" placeholder="Confirm new password" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm outline-none focus:ring-2 focus:ring-[#E8823C]">
                            <button class="w-full py-3 border border-[#E8823C] text-[#E8823C] font-semibold rounded-lg text-sm hover:bg-[#E8823C] hover:text-white transition">Update Password</button>
                        </form>
                    </div>
                </div>
                <div class="flex justify-end mt-8 gap-4">
                    <button type="reset" class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg text-sm hover:bg-gray-50">Reset</button>
                    <button type="submit" class="px-6 py-3 bg-[#E8823C] hover:bg-[#c96a2a] text-white font-semibold rounded-lg text-sm transition">Save Changes</button>
                </div>
            </form>
        </section>
    @endif

{{-- ── SEND QUOTE MODAL ── --}}
<div id="quoteModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-lg font-bold text-[#16302A]">Send Quote</h3>
            <button onclick="closeQuoteModal()" class="text-gray-400 hover:text-gray-600">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="quoteForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="text-xs font-semibold text-gray-600 mb-1 block">Trade</label>
                <input type="text" id="quoteTradeDisplay" disabled class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-500">
            </div>
            <div class="mb-4">
                <label class="text-xs font-semibold text-gray-600 mb-1 block">Your Price (Rs.) <span class="text-red-500">*</span></label>
                <input type="number" name="price" min="1" required placeholder="e.g. 1500"
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] outline-none">
            </div>
            <div class="mb-5">
                <label class="text-xs font-semibold text-gray-600 mb-1 block">Message (optional)</label>
                <textarea name="message" rows="3" placeholder="Describe your approach, availability, etc."
                          class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] outline-none resize-none"></textarea>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeQuoteModal()" class="flex-1 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-lg text-sm">Cancel</button>
                <button type="submit" class="flex-1 py-2.5 bg-[#E8823C] hover:bg-[#c96a2a] text-white font-semibold rounded-lg text-sm transition">Submit Quote</button>
            </div>
        </form>
    </div>
</div>

<script>
function openQuoteModal(jobId, trade) {
    document.getElementById('quoteModal').classList.remove('hidden');
    document.getElementById('quoteTradeDisplay').value = trade;
    document.getElementById('quoteForm').action = '/dashboard/professional/leads/' + jobId + '/quote';
}
function closeQuoteModal() {
    document.getElementById('quoteModal').classList.add('hidden');
}
function promptReschedule(jobId) {
    const dt = prompt('Enter new date/time (YYYY-MM-DD HH:MM):');
    if (dt) {
        document.getElementById('reschedule_' + jobId).value = dt;
        document.getElementById('reschedule_' + jobId).closest('form').submit();
    }
}
</script>

</main>
</body>
</html>
