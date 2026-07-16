<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - Fixly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/dark-mode.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #F5F1EA; color: #1f2937; }
        .heading-underline { position: relative; display: inline-block; }
        .heading-underline::after { content: ''; position: absolute; bottom: -6px; left: 0; width: 40px; height: 3px; background: #E8823C; border-radius: 2px; }
        .unread-dot { width: 8px; height: 8px; background: #E8823C; border-radius: 50%; }
        @media (max-width: 480px) {
            header { padding-left: 1rem !important; padding-right: 1rem !important; }
            header h1 { font-size: 1rem !important; }
            main { padding-left: 1rem !important; padding-right: 1rem !important; }
            .msg-card { padding: 1rem !important; }
            .msg-avatar { width: 2.5rem !important; height: 2.5rem !important; }
        }
        @media (max-width: 375px) {
            header { padding-left: 0.75rem !important; padding-right: 0.75rem !important; }
            main { padding-left: 0.75rem !important; padding-right: 0.75rem !important; }
            .msg-card { padding: 0.75rem !important; }
            .msg-card-text { font-size: 0.7rem !important; }
        }
    </style>
</head>
<body class="min-h-screen">
<!-- Top Bar -->
<header class="bg-[#16302A] px-6 py-4 flex items-center justify-between sticky top-0 z-50 shadow-sm">
    <div class="flex items-center gap-4">
        <a href="@if(Auth::user()->isCustomer()) {{ route('dashboard.customer') }} @else {{ route('dashboard.professional') }} @endif" class="flex items-center gap-2">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="text-white font-bold text-lg">Messages</h1>
    </div>

    <div class="flex items-center gap-2 sm:gap-4" style="color:#fff;">
        @include('partials.theme-toggle')
        @include('partials.notification-bell')
    </div>
</header>

<!-- Main Content -->
<main class="max-w-4xl mx-auto px-6 py-8">
    @if($conversations->count() > 0)
        <div class="space-y-3">
            @foreach($conversations as $conv)
                <a href="{{ route('messages.show', $conv->id) }}" class="block bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:border-[#E8823C]/30 transition msg-card">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-[#E8823C] flex items-center justify-center text-white font-bold flex-shrink-0 msg-avatar">
                            {{ substr((Auth::user()->isCustomer() ? $conv->professional->name : $conv->customer->name), 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <h3 class="font-semibold text-[#16302A]">
                                    {{ Auth::user()->isCustomer() ? $conv->professional->name : $conv->customer->name }}
                                </h3>
                                @php
                                    $unreadCount = $conv->messages->where('sender_id', '!=', Auth::id())->where('is_read', false)->count();
                                @endphp
                                <div class="flex items-center gap-2">
                                    @if($unreadCount > 0)
                                        <div class="unread-dot"></div>
                                    @endif
                                    <span class="text-xs text-gray-500">
                                        @if($conv->lastMessage)
                                            {{ $conv->lastMessage->created_at->diffForHumans() }}
                                        @else
                                            {{ $conv->created_at->diffForHumans() }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <p class="text-sm text-[#D9A441] mb-1">{{ $conv->job->trade_category }}</p>
                            <p class="text-xs text-gray-600 truncate msg-card-text">
                                @if($conv->lastMessage)
                                    {{ $conv->lastMessage->message_text }}
                                @else
                                    No messages yet
                                @endif
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="text-center py-20">
            <svg width="64" height="64" fill="none" stroke="#9ca3af" stroke-width="1.5" viewBox="0 0 24 24" class="mx-auto mb-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <h2 class="text-xl font-semibold text-[#16302A] mb-2">No messages yet</h2>
            <p class="text-gray-500 mb-6">Once you start a conversation, it will appear here.</p>
            <a href="@if(Auth::user()->isCustomer()) {{ route('dashboard.customer') }} @else {{ route('dashboard.professional') }} @endif" class="inline-flex items-center gap-2 bg-[#E8823C] text-white px-5 py-3 rounded-lg font-semibold hover:bg-[#c96a2a] transition">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Back to Dashboard
            </a>
        </div>
    @endif
</main>
<script src="/js/theme-toggle.js"></script>
</body>
</html>