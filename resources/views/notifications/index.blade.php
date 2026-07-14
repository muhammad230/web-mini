<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - Fixly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/dark-mode.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #F5F1EA; color: #1f2937; }
        .heading-underline { position: relative; display: inline-block; }
        .heading-underline::after { content: ''; position: absolute; bottom: -6px; left: 0; width: 40px; height: 3px; background: #E8823C; border-radius: 2px; }
        .notification-unread { background: #fef7f1; border-left: 3px solid #E8823C; }
    </style>
</head>
<body class="min-h-screen">

@php
    $user = Auth::user();
    $route = match($user->role) {
        'customer' => route('dashboard.customer'),
        'professional' => route('dashboard.professional'),
        'admin' => route('admin.dashboard'),
        default => route('home'),
    };
@endphp

<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ $route }}" class="text-sm text-[#E8823C] font-semibold hover:underline mb-2 inline-block">&larr; Back to Dashboard</a>
            <h1 class="text-3xl font-extrabold text-[#16302A] heading-underline">Notifications</h1>
        </div>
        @if($notifications->where('is_read', false)->count() > 0)
            <form method="POST" action="{{ route('notifications.read-all') }}">
                @csrf
                <button class="text-sm bg-[#E8823C] text-white px-4 py-2 rounded-lg font-semibold hover:bg-[#c96a2a]">Mark All as Read</button>
            </form>
        @endif
    </div>

    @if($notifications->isEmpty())
        <div class="text-center py-20">
            <svg class="mx-auto mb-4 w-16 h-16 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <p class="text-gray-500 font-semibold">No notifications yet</p>
            <p class="text-sm text-gray-400 mt-1">Notifications will appear here as activity happens.</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach($notifications as $notification)
                <div class="rounded-xl border border-gray-200 p-5 bg-white transition hover:shadow-sm {{ $notification->is_read ? '' : 'notification-unread' }}">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                @if(!$notification->is_read)
                                    <span class="w-2 h-2 bg-[#E8823C] rounded-full flex-shrink-0"></span>
                                @endif
                                <h3 class="font-semibold text-[#16302A] text-sm">{{ $notification->title }}</h3>
                            </div>
                            <p class="text-sm text-gray-600">{{ $notification->message }}</p>
                            <p class="text-xs text-gray-400 mt-2">{{ $notification->timeAgo() }}</p>
                        </div>
                        <div class="flex flex-col gap-2 flex-shrink-0">
                            @if(!$notification->is_read)
                                <a href="{{ route('notifications.read', $notification->id) }}"
                                   class="text-xs bg-[#E8823C] text-white px-3 py-1.5 rounded-lg font-semibold hover:bg-[#c96a2a] text-center whitespace-nowrap">
                                    View
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $notifications->links() }}
        </div>
    @endif
</div>

<div style="position:fixed;top:16px;right:16px;z-index:9999;display:flex;align-items:center;gap:8px;background:rgba(0,0,0,0.05);padding:4px 8px;border-radius:8px;">
    @include('partials.theme-toggle')
</div>
<script src="/js/theme-toggle.js"></script>
</body>
</html>
