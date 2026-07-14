<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversation - Fixly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #F5F1EA; color: #1f2937; }
        .message-sent { background-color: #E8823C; color: white; border-bottom-right-radius: 4px; }
        .message-received { background-color: white; color: #1f2937; border-bottom-left-radius: 4px; }
    </style>
</head>
<body class="min-h-screen flex flex-col">
<!-- Top Bar -->
<header class="bg-[#16302A] px-6 py-4 flex items-center justify-between sticky top-0 z-50 shadow-sm">
    <div class="flex items-center gap-4">
        <a href="{{ route('messages.index') }}" class="p-2 text-white hover:bg-white/10 rounded-lg transition">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-[#E8823C] flex items-center justify-center text-white font-bold">
                {{ substr((Auth::user()->isCustomer() ? $conversation->professional->name : $conversation->customer->name), 0, 1) }}
            </div>
            <div>
                <h1 class="text-white font-semibold text-sm">
                    {{ Auth::user()->isCustomer() ? $conversation->professional->name : $conversation->customer->name }}
                </h1>
                <p class="text-xs text-gray-400">{{ $conversation->job->trade_category }}</p>
            </div>
        </div>
    </div>
</header>

<!-- Main Chat Area -->
<main id="chat-area" class="flex-1 p-6 overflow-y-auto">
    <div class="max-w-3xl mx-auto space-y-4">
        @foreach($conversation->messages as $msg)
            <div class="flex {{ $msg->sender_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[80%]">
                    <div class="{{ $msg->sender_id == Auth::id() ? 'message-sent' : 'message-received' }} px-4 py-3 rounded-2xl shadow-sm">
                        <p class="text-sm">{{ $msg->message_text }}</p>
                    </div>
                    <p class="text-[10px] text-gray-500 mt-1 {{ $msg->sender_id == Auth::id() ? 'text-right' : 'text-left' }}">
                        {{ $msg->created_at->format('g:i A • M j') }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</main>

<!-- Message Input -->
<footer class="bg-white border-t border-gray-200 p-4">
    <div class="max-w-3xl mx-auto">
        <form id="send-form" method="POST" action="{{ route('messages.store', $conversation->id) }}" class="flex gap-3">
            @csrf
            <input type="text" name="message_text" id="message-input" placeholder="Type a message..." 
                class="flex-1 px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none"
                autocomplete="off" required>
            <button type="submit" class="bg-[#E8823C] hover:bg-[#c96a2a] text-white px-5 py-3 rounded-xl font-semibold transition">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="rotate-[-90deg]">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
            </button>
        </form>
    </div>
</footer>

<script>
// Scroll to bottom of chat on load
const chatArea = document.getElementById('chat-area');
chatArea.scrollTop = chatArea.scrollHeight;

// Auto-scroll when new message added
document.getElementById('send-form').addEventListener('submit', () => {
    setTimeout(() => {
        chatArea.scrollTop = chatArea.scrollHeight;
    }, 100);
});

// Poll for new messages every 5 seconds
let lastMessageId = {{ $conversation->messages->last() ? $conversation->messages->last()->id : 0 }};
setInterval(async () => {
    try {
        const response = await fetch('{{ route('messages.api.messages', $conversation->id) }}');
        const messages = await response.json();
        if (messages.length > 0) {
            const newMessages = messages.filter(m => m.id > lastMessageId);
            if (newMessages.length > 0) {
                location.reload();
            }
        }
    } catch (e) {
        console.log('Poll error:', e);
    }
}, 5000);
</script>
</body>
</html>