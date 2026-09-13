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
        .msg-menu-btn {
            opacity: 0; transition: opacity .15s; color: #9ca3af; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            width: 28px; height: 28px; border-radius: 9999px; flex-shrink: 0; padding: 0;
        }
        .msg-wrap:hover .msg-menu-btn, .msg-menu-btn.force-show { opacity: 1; }
        .msg-menu-btn:hover { background: rgba(0,0,0,.06); color: #4b5563; }
        @media (pointer: coarse) { .msg-menu-btn { opacity: .55; } }
        [data-theme="dark"] .msg-menu-btn { color: #9ca3af; }
        [data-theme="dark"] .msg-menu-btn:hover { background: rgba(255,255,255,.1); color: #e2e8f0; }
        .msg-menu {
            position: absolute; z-index: 50; top: calc(100% + 6px); min-width: 190px; padding: 4px;
            background: #fff; border: 1px solid #e5e7eb; border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,.15);
        }
        .msg-menu-left { left: 0; }
        .msg-menu-right { right: 0; }
        .msg-menu button {
            display: flex; width: 100%; align-items: center; gap: 8px;
            padding: 8px 12px; font-size: 13px; text-align: left; color: #1f2937; border-radius: 8px; cursor: pointer;
        }
        .msg-menu button:hover { background: #f3f4f6; }
        .msg-menu button.danger { color: #dc2626; }
        [data-theme="dark"] .msg-menu { background: #1E2A28; border-color: #374151; }
        [data-theme="dark"] .msg-menu button { color: #e2e8f0; }
        [data-theme="dark"] .msg-menu button:hover { background: #243330; }
        #delete-toast {
            position: fixed; bottom: 80px; left: 50%; transform: translateX(-50%); z-index: 60;
            background: #111827; color: #fff; padding: 10px 16px; border-radius: 10px; font-size: 13px;
            box-shadow: 0 10px 25px rgba(0,0,0,.25); opacity: 0; transition: opacity .2s; pointer-events: none; white-space: nowrap;
        }
        #delete-toast.show { opacity: 1; }
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
        @foreach($messages as $msg)
            @php
                $isOwn = (int) $msg->sender_id === (int) Auth::id();
            @endphp
            <div class="msg-wrap flex items-end gap-2 group {{ $isOwn ? 'flex-row-reverse justify-start' : 'flex-row justify-start' }}"
                 data-message-id="{{ $msg->id }}"
                 data-is-own="{{ $isOwn ? '1' : '0' }}"
                 data-created-at="{{ $msg->created_at->toIso8601ZuluString() }}">
                <button type="button" class="msg-menu-btn" aria-label="Message options">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><circle cx="5" cy="12" r="1.6"/><circle cx="12" cy="12" r="1.6"/><circle cx="19" cy="12" r="1.6"/></svg>
                </button>
                <div class="relative max-w-[80%] chat-bubble chat-bubble-box">
                    <div class="{{ $isOwn ? 'message-sent' : 'message-received' }} px-4 py-3 rounded-2xl shadow-sm chat-bubble-text">
                        <p class="text-sm">{{ $msg->display_text }}</p>
                    </div>
                    <p class="text-[10px] text-gray-500 mt-1 {{ $isOwn ? 'text-right' : 'text-left' }}">
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
let lastMessageId = {{ $conversation->messages->max('id') ?? 0 }};
const currentUserId = {{ Auth::id() }};

// Delete-for-everyone window & placeholder (must match the server)
const DELETE_EVERYONE_WINDOW_MS = {{ \App\Models\Message::DELETE_EVERYONE_WINDOW_MINUTES * 60 * 1000 }};
const DELETED_PLACEHOLDER = 'This message was deleted';

// Optimistic messages awaiting server confirmation (tempId -> meta)
const pending = new Map();

function parseServerDate(s) {
    if (!s) return null;
    // Server timestamps are UTC. If they carry no explicit zone marker
    // (e.g. an old 'YYYY-MM-DD HH:MM:SS' value), treat them as UTC so the
    // comparison with Date.now() is timezone-independent on every browser.
    let str = String(s).trim();
    if (!/Z$|[+-]\d{2}:?\d{2}$/.test(str)) {
        str = str.replace(' ', 'T') + 'Z';
    }
    const d = new Date(str);
    return isNaN(d.getTime()) ? null : d;
}

function messageMeta(wrap) {
    return {
        id: wrap.dataset.messageId || '',
        isOwn: wrap.dataset.isOwn === '1' || wrap.dataset.isOwn === 'true',
        createdAt: wrap.dataset.createdAt || null,
    };
}

function canDeleteEveryone(createdAt) {
    const t = parseServerDate(createdAt);
    if (!t) return false;
    return (Date.now() - t.getTime()) < DELETE_EVERYONE_WINDOW_MS;
}

function buildBubble(message, isOwn) {
    const wrapper = document.createElement('div');
    wrapper.className = 'msg-wrap flex items-end gap-2 group ' + (isOwn ? 'flex-row-reverse justify-start' : 'flex-row justify-start');
    wrapper.dataset.messageId = message.id || '';

    const menuBtn = document.createElement('button');
    menuBtn.type = 'button';
    menuBtn.className = 'msg-menu-btn';
    menuBtn.setAttribute('aria-label', 'Message options');
    menuBtn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><circle cx="5" cy="12" r="1.6"/><circle cx="12" cy="12" r="1.6"/><circle cx="19" cy="12" r="1.6"/></svg>';
    wrapper.appendChild(menuBtn);

    const inner = document.createElement('div');
    inner.className = 'relative max-w-[80%] chat-bubble chat-bubble-box';

    const bubble = document.createElement('div');
    bubble.className = (isOwn ? 'message-sent' : 'message-received') + ' px-4 py-3 rounded-2xl shadow-sm chat-bubble-text';
    const text = document.createElement('p');
    text.className = 'text-sm';
    text.textContent = message.message_text;
    bubble.appendChild(text);

    const time = document.createElement('p');
    time.className = 'text-[10px] text-gray-500 mt-1 ' + (isOwn ? 'text-right' : 'text-left');
    time.textContent = message.created_at_human || (message.created_at ? new Date(parseServerDate(message.created_at) || Date.now()).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : 'Just now');

    inner.appendChild(bubble);
    inner.appendChild(time);
    wrapper.appendChild(inner);

    wrapper.dataset.isOwn = isOwn ? '1' : '0';
    wrapper.dataset.createdAt = message.created_at || new Date().toISOString();

    return { wrapper, time };
}

function scrollToBottom() {
    chatArea.scrollTop = chatArea.scrollHeight;
}

// Confirm an optimistic message with the server's real id/timestamp
function confirmMessage(tempId, serverMessage) {
    const item = pending.get(tempId);
    if (item) {
        pending.delete(tempId);
        if (serverMessage && serverMessage.id) {
            item.wrapper.dataset.messageId = serverMessage.id;
        }
        if (serverMessage && serverMessage.created_at) {
            item.wrapper.dataset.createdAt = serverMessage.created_at;
        }
        if (serverMessage && serverMessage.created_at_human) {
            item.time.textContent = serverMessage.created_at_human;
        }
    }
    const serverId = parseInt(serverMessage && serverMessage.id, 10);
    if (!isNaN(serverId) && serverId > lastMessageId) {
        lastMessageId = serverId;
    }
}

function findWrap(id) {
    if (!id) return null;
    return messagesContainer.querySelector('.msg-wrap[data-message-id="' + id + '"]');
}

function setPlaceholder(id) {
    const wrap = findWrap(id);
    if (!wrap) return;
    wrap.dataset.deleted = 'everyone';
    const p = wrap.querySelector('.chat-bubble p.text-sm');
    if (p) p.textContent = DELETED_PLACEHOLDER;
    const btn = wrap.querySelector('.msg-menu-btn');
    if (btn) btn.remove();
    closeAllMenus();
}

function appendIncoming(message) {
    if (!message || !message.id) return;
    const id = parseInt(message.id, 10);
    if (!isNaN(id) && id <= lastMessageId) {
        return;
    }
    if (messagesContainer.querySelector('.msg-wrap[data-message-id="' + message.id + '"]')) {
        return;
    }
    if (!isNaN(id)) {
        lastMessageId = id;
    }
    const isOwn = parseInt(message.sender_id, 10) === currentUserId;

    // Check if matching an optimistic pending item
    if (isOwn) {
        let matched = null;
        for (const [tempId, item] of pending.entries()) {
            if (item.text === message.message_text) {
                matched = tempId;
                break;
            }
        }
        if (matched) {
            confirmMessage(matched, message);
            return;
        }
    }

    const el = buildBubble(message, isOwn);
    messagesContainer.appendChild(el.wrapper);
    scrollToBottom();
}

function closeAllMenus() {
    messagesContainer.querySelectorAll('.msg-menu').forEach(menu => {
        const wrap = menu.closest('.msg-wrap');
        if (wrap) {
            const btn = wrap.querySelector('.msg-menu-btn');
            if (btn) btn.classList.remove('force-show');
        }
        menu.remove();
    });
}

function openMenu(wrap) {
    closeAllMenus();
    const meta = messageMeta(wrap);
    const btn = wrap.querySelector('.msg-menu-btn');
    if (btn) btn.classList.add('force-show');

    const menu = document.createElement('div');
    menu.className = 'msg-menu ' + (meta.isOwn ? 'msg-menu-right' : 'msg-menu-left');

    const delMe = document.createElement('button');
    delMe.type = 'button';
    delMe.dataset.delAction = 'me';
    delMe.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg><span>Delete for me</span>';
    menu.appendChild(delMe);

    if (meta.isOwn && canDeleteEveryone(meta.createdAt)) {
        const delEveryone = document.createElement('button');
        delEveryone.type = 'button';
        delEveryone.dataset.delAction = 'everyone';
        delEveryone.classList.add('danger');
        delEveryone.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg><span>Delete for everyone</span>';
        menu.appendChild(delEveryone);
    }

    const innerBox = wrap.querySelector('.chat-bubble-box') || wrap;
    innerBox.appendChild(menu);
}

function performDelete(id, mode) {
    if (!id || String(id).indexOf('temp-') === 0) {
        // Unconfirmed optimistic message – only "delete for me" makes sense locally
        if (mode === 'me') {
            const wrap = findWrap(id);
            if (wrap) wrap.remove();
            pending.delete(id);
        }
        return;
    }

    const form = new URLSearchParams();
    form.set('mode', mode);

    fetch(`/messages/${id}/delete`, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: form,
    })
    .then(res => res.ok ? res.json() : res.json().then(err => Promise.reject(err)))
    .then(() => {
        if (mode === 'me') {
            const wrap = findWrap(id);
            if (wrap) wrap.remove();
        } else {
            setPlaceholder(id);
        }
    })
    .catch(err => {
        showToast((err && err.message) || 'Could not delete the message.');
    });
}

let toastTimer = null;
function showToast(message) {
    let toast = document.getElementById('delete-toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'delete-toast';
        document.body.appendChild(toast);
    }
    toast.textContent = message;
    toast.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => toast.classList.remove('show'), 3000);
}

// Click delegation for message menus & actions
messagesContainer.addEventListener('click', (e) => {
    const menuBtn = e.target.closest('.msg-menu-btn');
    if (menuBtn) {
        e.preventDefault();
        e.stopPropagation();
        const wrap = menuBtn.closest('.msg-wrap');
        if (wrap) openMenu(wrap);
        return;
    }
    const actionBtn = e.target.closest('[data-del-action]');
    if (actionBtn) {
        e.preventDefault();
        e.stopPropagation();
        const menu = actionBtn.closest('.msg-menu');
        const wrap = menu ? menu.closest('.msg-wrap') : null;
        const meta = wrap ? messageMeta(wrap) : { id: null };
        closeAllMenus();
        if (meta.id) performDelete(meta.id, actionBtn.dataset.delAction);
        return;
    }
    closeAllMenus();
});

// Long-press (mobile) opens the message menu
let longPressTimer = null;
messagesContainer.addEventListener('touchstart', (e) => {
    const wrap = e.target.closest('.msg-wrap');
    if (!wrap) return;
    clearTimeout(longPressTimer);
    longPressTimer = setTimeout(() => {
        const btn = wrap.querySelector('.msg-menu-btn');
        if (btn) btn.click();
    }, 500);
}, { passive: true });
['touchmove', 'touchend', 'touchcancel'].forEach(evt => {
    messagesContainer.addEventListener(evt, () => clearTimeout(longPressTimer), { passive: true });
});

const sendForm = document.getElementById('send-form');
const messageInput = document.getElementById('message-input');

sendForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const text = messageInput.value.trim();
    if (!text || sendForm.dataset.sending === '1') {
        return;
    }

    // Capture form data BEFORE clearing messageInput!
    const formData = new FormData(sendForm);

    // Optimistic UI: show the sender's own message immediately
    const tempId = 'temp-' + Date.now();
    const el = buildBubble({ message_text: text, created_at_human: 'Just now', created_at: new Date().toISOString() }, true);
    messagesContainer.appendChild(el.wrapper);
    pending.set(tempId, { text: text, time: el.time, wrapper: el.wrapper });
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
        body: formData,
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
    .catch(() => {})
    .finally(() => {
        delete sendForm.dataset.sending;
    });
});

// Setup Echo WebSockets listener
if (typeof Echo !== 'undefined') {
    try {
        const echoClient = new Echo({
            broadcaster: 'pusher',
            key: '{{ config('broadcasting.connections.pusher.key') }}',
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            forceTLS: true,
            encrypted: true,
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }
        });

        echoClient.private('conversation.{{ $conversation->id }}')
            .listen('.message.sent', (e) => {
                if (e && e.message) appendIncoming(e.message);
            })
            .listen('MessageSent', (e) => {
                if (e && e.message) appendIncoming(e.message);
            })
            .listen('.message.deleted', (e) => {
                if (e && e.id) setPlaceholder(e.id);
            })
            .listen('MessageDeleted', (e) => {
                if (e && e.id) setPlaceholder(e.id);
            });
    } catch (err) {
        console.warn('Echo initialization error:', err);
    }
}

// Live polling check every 1 second
function checkNewMessages() {
    fetch(`/messages/api/{{ $conversation->id }}/messages?after_id=${lastMessageId}`, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    })
    .then(res => res.ok ? res.json() : [])
    .then(messages => {
        if (Array.isArray(messages)) {
            messages.forEach(msg => {
                appendIncoming(msg);
            });
        }
    })
    .catch(() => {});
}

setInterval(checkNewMessages, 1000);
</script>
<script src="/js/theme-toggle.js"></script>
</body>
</html>