<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Detail - FixIt</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #F5F1EA; color: #1f2937; }
        .status-badge { padding: 3px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 600; display: inline-block; }
        .status-completed { background: #dcfce7; color: #15803d; }
        .status-in_progress { background: #fff7ed; color: #c2410c; }
        .status-scheduled { background: #fff7ed; color: #c2410c; }
        .status-pending_match { background: #f3f4f6; color: #6b7280; }
        .status-quotes_received { background: #eff6ff; color: #1d4ed8; }
        .status-cancelled { background: #fee2e2; color: #b91c1c; }
        .card { background: #fff; border-radius: 14px; padding: 24px; border: 1px solid #ece8df; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 20px; }
        .info-label { font-weight: 600; color: #6b7280; min-width: 130px; }
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        @media (max-width: 640px) { .detail-grid { grid-template-columns: 1fr; } .card { padding: 16px; } }
    </style>
</head>
<body class="min-h-screen">
    <header class="bg-[#16302A] px-4 py-4 flex items-center justify-between sticky top-0 z-50 shadow-md">
        <div class="flex items-center gap-2">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                    <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H15v-5h-6v5H4a1 1 0 01-1-1V9.5z" fill="#E8823C"/>
                    <path d="M9 21v-5h6v5" stroke="#fff" stroke-width="1.2" stroke-linejoin="round"/>
                </svg>
                <span class="text-white text-lg font-bold">Fix<span class="text-[#E8823C]">It</span></span>
            </a>
        </div>
        <div class="flex items-center gap-3">
            @include('partials.notification-bell')
            <a href="{{ route('dashboard.customer') }}" class="text-xs bg-[#E8823C] text-white px-4 py-2 rounded-lg font-semibold hover:bg-[#c96a2a]">Dashboard</a>
        </div>
    </header>

    <div style="max-width:960px;margin:0 auto;padding:24px 16px;">
        <a href="{{ route('dashboard.customer') }}" class="inline-flex items-center gap-1 text-[#E8823C] font-semibold text-sm mb-4 hover:text-[#c96a2a]">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Back to Dashboard
        </a>

        <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-[#16302A]">Job #JB-{{ $job->id }}</h1>
                <p class="text-sm text-gray-500">{{ $job->trade_category ?: 'General' }}</p>
            </div>
            <span class="status-badge status-{{ $job->status }}">{{ ucwords(str_replace('_', ' ', $job->status)) }}</span>
        </div>

        <div class="card">
            <h2 class="font-bold text-[#16302A] mb-4">Job Details</h2>
            <div class="detail-grid">
                <div><span class="info-label">Description:</span><p class="mt-0.5">{{ $job->description ?: 'N/A' }}</p></div>
                <div><span class="info-label">Location:</span><p class="mt-0.5">{{ $job->location ?: 'N/A' }}</p></div>
                <div><span class="info-label">Budget:</span><p class="mt-0.5">@if($job->budget_min && $job->budget_max)Rs. {{ number_format($job->budget_min) }} - Rs. {{ number_format($job->budget_max) }}@elseif($job->budget_min)Rs. {{ number_format($job->budget_min) }}+@else N/A @endif</p></div>
                <div><span class="info-label">Schedule:</span><p class="mt-0.5">{{ $job->schedule ?: 'N/A' }}</p></div>
                <div><span class="info-label">Status:</span><p class="mt-0.5">{{ ucwords(str_replace('_', ' ', $job->status)) }}</p></div>
                <div><span class="info-label">Created:</span><p class="mt-0.5">{{ $job->created_at->format('M d, Y') }}</p></div>
            </div>
        </div>

        @if($job->assignedPro)
        <div class="card">
            <h2 class="font-bold text-[#16302A] mb-4">Assigned Professional</h2>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-[#16302A] flex items-center justify-center text-white font-bold text-lg">{{ substr($job->assignedPro->name, 0, 1) }}</div>
                <div>
                    <p class="font-semibold">{{ $job->assignedPro->name }}</p>
                    <p class="text-sm text-gray-500">{{ $job->assignedPro->trade ?: 'Professional' }}</p>
                    @if($job->assignedPro->phone)<p class="text-sm text-gray-500">{{ $job->assignedPro->phone }}</p>@endif
                </div>
            </div>
        </div>
        @endif

        @if($job->quotes && $job->quotes->count() > 0)
        <div class="card">
            <h2 class="font-bold text-[#16302A] mb-4">Quotes Received</h2>
            @foreach($job->quotes as $quote)
            <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                <div>
                    <p class="font-semibold">{{ $quote->pro ? $quote->pro->name : 'Professional' }}</p>
                    <p class="text-sm text-gray-500">{{ $quote->message ?: 'No message' }}</p>
                </div>
                <div class="text-right">
                    <p class="font-bold text-[#16302A]">Rs. {{ number_format($quote->amount) }}</p>
                    <p class="text-xs text-gray-400">{{ $quote->created_at->format('M d, Y') }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if(isset($conversation) && $conversation && $conversation->messages->count() > 0)
        <div class="card">
            <h2 class="font-bold text-[#16302A] mb-4">Messages</h2>
            <div class="space-y-3 max-h-80 overflow-y-auto">
                @foreach($conversation->messages as $msg)
                <div class="flex {{ $msg->sender_role === 'customer' ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[75%] p-3 rounded-xl {{ $msg->sender_role === 'customer' ? 'bg-[#E8823C] text-white' : 'bg-gray-100' }}">
                        <div class="text-xs font-semibold mb-1 opacity-80">{{ $msg->sender->name ?? ($msg->sender_role === 'customer' ? 'You' : $msg->sender_role) }}</div>
                        <div class="text-sm">{{ $msg->message_text }}</div>
                        <div class="text-xs mt-1 opacity-70">{{ $msg->created_at->format('M d, Y h:i A') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($job->review)
        <div class="card">
            <h2 class="font-bold text-[#16302A] mb-4">Your Review</h2>
            <div class="flex items-center gap-1 mb-2">
                @for($i = 1; $i <= 5; $i++)
                    <svg class="w-5 h-5 {{ $i <= $job->review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                @endfor
            </div>
            @if($job->review->comment)<p class="text-gray-700">{{ $job->review->comment }}</p>@endif
            <p class="text-xs text-gray-400 mt-2">{{ $job->review->created_at->format('M d, Y') }}</p>
        </div>
        @endif

        @if($job->status === 'completed' && !$job->review)
        <div class="card text-center">
            <p class="text-gray-500 mb-3">Have you completed this job? Leave a review!</p>
            <a href="{{ route('dashboard.customer') }}#reviews" class="inline-block bg-[#E8823C] text-white px-6 py-2 rounded-lg font-semibold text-sm hover:bg-[#c96a2a]">Leave a Review</a>
        </div>
        @endif
    </div>
</body>
</html>