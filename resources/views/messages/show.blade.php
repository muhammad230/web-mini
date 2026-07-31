<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Conversation - Fixly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://js.pusher.com/8.x/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@8/dist/echo.iife.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/dark-mode.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #F5F1EA; color: #1f2937; }
        .message-sent { background-color: #E8823C; color: white; border-bottom-right-radius: 4px; }
        .message-received { background-color: white; color: #1f2937; border-bottom-left-radius: 4px; }
        @media (max-width: 480px) {
            header { padding-left: 1rem !important; padding-right: 1rem !important; }
            header h1 { font-size: 0.85rem !important; }
            main { padding: 0.75rem !important; }
            .chat-bubble { max-width: 90% !important; }
            .chat-bubble-text { font-size: 0.8rem !important; padding: 0.5rem 0.75rem !important; }
            footer { padding: 0.75rem !important; }
            .chat-input { font-size: 0.85rem !important; padding: 0.6rem 0.75rem !important; }
            .chat-send-btn { padding: 0.6rem 1rem !important; }
        }
        @media (max-width: 375px) {
            header { padding-left: 0.5rem !important; padding-right: 0.5rem !important; }
            main { padding: 0.5rem !important; }
            .chat-bubble { max-width: 95% !important; }
            header .back-btn { padding: 0.25rem !important; }
        }
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
    <div class="flex items-center gap-2 sm:gap-4" style="color:#fff;">
        @include('partials.theme-toggle')
        @include('partials.notification-bell')
    </div>
</header>

<!-- Main Chat Area -->
<main id="chat-area" class="flex-1 p-6 overflow-y-auto">
    <div class="max-w-3xl mx-auto space-y-4">
        @foreach($conversation->messages as $msg)
            <div class="flex {{ $msg->sender_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[80%] chat-bubble">
                        <div class="{{ $msg->sender_id == Auth::id() ? 'message-sent' : 'message-received' }} px-4 py-3 rounded-2xl shadow-sm chat-bubble-text">
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
                class="flex-1 px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none chat-input"
                autocomplete="off" required>
            <button type="submit" class="bg-[#E8823C] hover:bg-[#c96a2a] text-white px-5 py-3 rounded-xl font-semibold transition chat-send-btn">
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
const messagesContainer = document.querySelector('#chat-area .max-w-3xl');
chatArea.scrollTop = chatArea.scrollHeight;

// Track highest known server message id
let lastMessageId = {{ $conversation->messages->last() ? $conversation->messages->last()->id : 0 }};
const currentUserId = {{ Auth::id() }};

// Optimistic messages awaiting server confirmation (tempId -> meta)
const pending = new Map();

function buildBubble(message, isOwn) {
    const wrapper = document.createElement('div');
    wrapper.className = 'flex ' + (isOwn ? 'justify-end' : 'justify-start');

    const inner = document.createElement('div');
    inner.className = 'max-w-[80%] chat-bubble';

    const bubble = document.createElement('div');
    bubble.className = (isOwn ? 'message-sent' : 'message-received') + ' px-4 py-3 rounded-2xl shadow-sm chat-bubble-text';
    const text = document.createElement('p');
    text.className = 'text-sm';
    text.textContent = message.message_text;
    bubble.appendChild(text);

    const time = document.createElement('p');
    time.className = 'text-[10px] text-gray-500 mt-1 ' + (isOwn ? 'text-right' : 'text-left');
    time.textContent = message.created_at_human || '';

    inner.appendChild(bubble);
    inner.appendChild(time);
    wrapper.appendChild(inner);

    return { wrapper, time };
}

function isNearBottom() {
    return chatArea.scrollHeight - chatArea.scrollTop - chatArea.clientHeight < 120;
}

function scrollToBottom() {
    chatArea.scrollTop = chatArea.scrollHeight;
}

// Confirm an optimistic message with the server's real id/timestamp
function confirmMessage(tempId, serverMessage) {
    const item = pending.get(tempId);
    if (item) {
        pending.delete(tempId);
        if (serverMessage && serverMessage.created_at_human) {
            item.time.textContent = serverMessage.created_at_human;
        }
    }
    const serverId = parseInt(serverMessage && serverMessage.id, 10);
    if (!isNaN(serverId) && serverId > lastMessageId) {
        lastMessageId = serverId;
    }
}

function appendIncoming(message) {
    const id = parseInt(message.id, 10);
    if (!isNaN(id) && id <= lastMessageId) {
        return;
    }
    if (!isNaN(id)) {
        lastMessageId = id;
    }
    const el = buildBubble(message, false);
    messagesContainer.appendChild(el.wrapper);
    if (isNearBottom()) {
        scrollToBottom();
    }
}

const sendForm = document.getElementById('send-form');
const messageInput = document.getElementById('message-input');

sendForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const text = messageInput.value.trim();
    if (!text || sendForm.dataset.sending === '1') {
        return;
    }

    // Optimistic UI: show the sender's own message immediately
    const tempId = 'temp-' + Date.now();
    const el = buildBubble({ message_text: text, created_at_human: 'Just now' }, true);
    messagesContainer.appendChild(el.wrapper);
    pending.set(tempId, { text: text, time: el.time });
    scrollToBottom();

    messageInput.value = '';
    messageInput.focus();
    sendForm.dataset.sending = '1';

    fetch(sendForm.action, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: new FormData(sendForm),
    })
    .then(res => {
        if (!res.ok) {
            return res.json().then(err => Promise.reject(err));
        }
        return res.json();
    })
    .then(data => {
        confirmMessage(tempId, data && data.message);
    })
    .catch(() => {
        // Keep the optimistic bubble; the server-side broadcast is its fallback.
    })
    .finally(() => {
        delete sendForm.dataset.sending;
    });
});

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '{{ config('broadcasting.connections.pusher.key') }}',
    cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
    forceTLS: true,
    encrypted: true,
});

window.Echo.private('conversation.{{ $conversation->id }}')
    .listen('.message.sent', (e) => {
        const msg = e.message;

        // Own message: Pusher echo of an optimistic bubble (or sent from another tab)
        if (parseInt(msg.sender_id, 10) === currentUserId) {
            const id = parseInt(msg.id, 10);
            let matched = null;
            for (const [tempId, item] of pending.entries()) {
                if (item.text === msg.message_text) {
                    matched = tempId;
                    break;
                }
            }
            if (matched) {
                confirmMessage(matched, msg);
                return;
            }
            if (isNaN(id) || id <= lastMessageId) {
                return;
            }
            lastMessageId = id;
            const el = buildBubble(msg, true);
            messagesContainer.appendChild(el.wrapper);
            scrollToBottom();
            return;
        }

        // Incoming message from the other party
        appendIncoming(msg);
    });
</script>
<script src="/js/theme-toggle.js"></script>
</body>
</html>