<div id="fixly-chat-widget" style="position:fixed;bottom:20px;right:20px;z-index:9999;font-family:'Inter',sans-serif;">
    <button id="chat-fab" onclick="toggleChat()" style="width:56px;height:56px;border-radius:50%;background:#E8823C;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 16px rgba(232,130,60,0.4);transition:transform .2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
        <svg id="chat-icon-open" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
        <svg id="chat-icon-close" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>

    <div id="chat-window" style="display:none;position:absolute;bottom:70px;right:0;width:380px;max-width:calc(100vw - 40px);height:520px;max-height:calc(100vh - 120px);border-radius:16px;box-shadow:0 8px 32px rgba(0,0,0,0.18);display:none;flex-direction:column;overflow:hidden;" data-theme-aware>
        {{-- Header --}}
        <div class="chat-header">
            <div class="chat-header-left">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                    <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H15v-5h-6v5H4a1 1 0 01-1-1V9.5z" fill="#E8823C"/>
                </svg>
                <div>
                    <div class="chat-header-title">Fixly Assistant</div>
                    <div class="chat-header-status"><span class="chat-online-dot"></span><span class="chat-online-text">Online</span></div>
                </div>
            </div>
            <button onclick="toggleChat()" class="chat-minimize-btn">—</button>
        </div>

        {{-- Messages --}}
        <div id="chat-messages" class="chat-messages"></div>

        {{-- Footer --}}
        <div id="chat-footer" class="chat-footer">
            <div id="question-list" class="chat-quick-replies">
                <button class="chat-q-btn" data-q="0">How do I post a job?</button>
                <button class="chat-q-btn" data-q="1">Are pros verified?</button>
                <button class="chat-q-btn" data-q="2">How does payment work?</button>
                <button class="chat-q-btn" data-q="3">Become a pro?</button>
                <button class="chat-q-btn" data-q="4">Is my info safe?</button>
                <button class="chat-q-btn" data-q="5">Contact support</button>
            </div>
            <div class="chat-input-row">
                <input type="text" id="chat-input" placeholder="Type your question..." autocomplete="off" />
                <button onclick="sendMessage()" class="chat-send-btn" aria-label="Send">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
#fixly-chat-widget * { box-sizing: border-box; }

/* Window background */
#chat-window { background: #fff; }

/* Dotted pattern background for messages area */
#chat-messages {
    flex: 1;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    gap: 10px;
    padding: 16px;
    background-color: #F5F1EA;
    background-image: radial-gradient(circle, rgba(0,0,0,0.08) 1px, transparent 1px);
    background-size: 20px 20px;
}

#chat-messages::-webkit-scrollbar { width: 4px; }
#chat-messages::-webkit-scrollbar-track { background: transparent; }
#chat-messages::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }

/* Header */
.chat-header {
    background: #16302A;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
}
.chat-header-left {
    display: flex;
    align-items: center;
    gap: 10px;
}
.chat-header-title {
    color: #fff;
    font-weight: 700;
    font-size: 14px;
    line-height: 1.2;
}
.chat-header-status {
    display: flex;
    align-items: center;
    gap: 4px;
    margin-top: 1px;
}
.chat-online-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #22c55e;
    display: inline-block;
}
.chat-online-text {
    font-size: 11px;
    color: rgba(255,255,255,0.7);
}
.chat-minimize-btn {
    background: transparent;
    border: none;
    cursor: pointer;
    color: #fff;
    font-size: 18px;
    line-height: 1;
    padding: 2px 6px;
    opacity: 0.8;
}
.chat-minimize-btn:hover { opacity: 1; }

/* User bubbles */
.chat-bubble-user {
    align-self: flex-end;
    max-width: 80%;
    background: #E8823C;
    color: #fff;
    padding: 10px 14px;
    border-radius: 14px 14px 4px 14px;
    font-size: 13px;
    line-height: 1.5;
    word-wrap: break-word;
}
.chat-bubble-user .chat-time {
    font-size: 10px;
    color: rgba(255,255,255,0.7);
    margin-top: 4px;
    display: block;
    text-align: right;
}

/* Bot bubbles */
.chat-bubble-bot {
    align-self: flex-start;
    max-width: 80%;
    background: #fff;
    color: #1f2937;
    padding: 10px 14px;
    border-radius: 14px 14px 14px 4px;
    font-size: 13px;
    line-height: 1.5;
    word-wrap: break-word;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
}
.chat-bubble-bot .chat-time {
    font-size: 10px;
    color: #9ca3af;
    margin-top: 4px;
    display: block;
}

.chat-bubble-bot a {
    color: #E8823C;
    font-weight: 600;
    text-decoration: none;
}
.chat-bubble-bot a:hover { text-decoration: underline; }

/* Typing indicator */
.chat-typing {
    align-self: flex-start;
    display: flex;
    gap: 4px;
    padding: 12px 16px;
    background: #fff;
    border-radius: 14px 14px 14px 4px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
}
.chat-typing span {
    width: 7px; height: 7px; border-radius: 50%;
    background: #d1d5db; animation: chatBounce 1.4s infinite ease-in-out;
}
.chat-typing span:nth-child(1) { animation-delay: 0s; }
.chat-typing span:nth-child(2) { animation-delay: 0.2s; }
.chat-typing span:nth-child(3) { animation-delay: 0.4s; }

@keyframes chatBounce {
    0%, 80%, 100% { transform: scale(0.6); opacity: 0.4; }
    40% { transform: scale(1); opacity: 1; }
}

/* Footer */
.chat-footer {
    padding: 10px 12px 12px;
    flex-shrink: 0;
    border-top: 1px solid #e5e7eb;
    background: #fff;
}
.chat-quick-replies {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 10px;
}
.chat-q-btn {
    padding: 6px 12px;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    background: #fff;
    color: #374151;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.15s;
    white-space: nowrap;
}
.chat-q-btn:hover {
    border-color: #E8823C;
    color: #E8823C;
    background: #fff7f0;
}
.chat-input-row {
    display: flex;
    gap: 8px;
    align-items: center;
}
.chat-input-row input {
    flex: 1;
    border: 1.5px solid #e5e7eb;
    border-radius: 20px;
    padding: 10px 16px;
    font-size: 13px;
    outline: none;
    color: #1f2937;
    background: #F5F1EA;
    transition: border-color 0.15s;
}
.chat-input-row input:focus {
    border-color: #E8823C;
}
.chat-input-row input::placeholder {
    color: #9ca3af;
}
.chat-send-btn {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #E8823C;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: background 0.15s;
}
.chat-send-btn:hover {
    background: #c96a2a;
}

/* After-answer buttons */
#chat-footer .chat-after-answer {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
#chat-footer .chat-after-answer button {
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid #E8823C;
    border-radius: 10px;
    background: transparent;
    color: #E8823C;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    text-align: center;
    transition: all 0.15s;
}
#chat-footer .chat-after-answer button:hover {
    background: #E8823C;
    color: #fff;
}
#chat-footer .chat-after-answer a {
    display: block;
    text-align: center;
    padding: 8px;
    font-size: 12px;
    color: #6b7280;
    text-decoration: none;
    font-weight: 500;
}
#chat-footer .chat-after-answer a:hover {
    color: #E8823C;
}

/* ── Dark mode ── */
[data-theme="dark"] #chat-window {
    background: var(--dm-bg-card, #1E2A28) !important;
    box-shadow: 0 8px 32px rgba(0,0,0,0.4) !important;
}
[data-theme="dark"] #chat-messages {
    background-color: var(--dm-bg-page, #12181A) !important;
    background-image: radial-gradient(circle, rgba(255,255,255,0.04) 1px, transparent 1px) !important;
}
[data-theme="dark"] .chat-header {
    background: #16302A !important;
}
[data-theme="dark"] .chat-bubble-bot {
    background: var(--dm-bg-card, #1E2A28) !important;
    color: var(--dm-text-primary, #f3f4f6) !important;
}
[data-theme="dark"] .chat-bubble-bot .chat-time {
    color: var(--dm-text-muted, #6b7280) !important;
}
[data-theme="dark"] .chat-bubble-bot a { color: var(--dm-accent, #E8823C) !important; }
[data-theme="dark"] .chat-typing {
    background: var(--dm-bg-card, #1E2A28) !important;
}
[data-theme="dark"] .chat-typing span { background: var(--dm-text-muted, #6b7280) !important; }
[data-theme="dark"] #chat-footer {
    border-top-color: var(--dm-border, #374151) !important;
    background: var(--dm-bg-card, #1E2A28) !important;
}
[data-theme="dark"] .chat-q-btn {
    border-color: var(--dm-border, #374151) !important;
    color: var(--dm-text-primary, #f3f4f6) !important;
    background: transparent !important;
}
[data-theme="dark"] .chat-q-btn:hover {
    border-color: var(--dm-accent, #E8823C) !important;
    color: var(--dm-accent, #E8823C) !important;
    background: rgba(232,130,60,0.1) !important;
}
[data-theme="dark"] .chat-input-row input {
    background: var(--dm-bg-page, #12181A) !important;
    border-color: var(--dm-border, #374151) !important;
    color: var(--dm-text-primary, #f3f4f6) !important;
}
[data-theme="dark"] .chat-input-row input:focus {
    border-color: var(--dm-accent, #E8823C) !important;
}
[data-theme="dark"] .chat-after-answer button {
    border-color: var(--dm-accent, #E8823C) !important;
    color: var(--dm-accent, #E8823C) !important;
    background: transparent !important;
}
[data-theme="dark"] .chat-after-answer button:hover {
    background: var(--dm-accent, #E8823C) !important;
    color: #fff !important;
}
[data-theme="dark"] .chat-after-answer a {
    color: var(--dm-text-muted, #6b7280) !important;
}
[data-theme="dark"] .chat-after-answer a:hover {
    color: var(--dm-accent, #E8823C) !important;
}

/* Mobile: <480px — full-screen overlay only when chat is open */
@media (max-width: 479px) {
    #fixly-chat-widget.chat-open {
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100% !important;
        height: 100% !important;
    }
    #fixly-chat-widget.chat-open #chat-window {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100% !important;
        height: 100% !important;
        max-width: none !important;
        max-height: none !important;
        border-radius: 0 !important;
    }
    #fixly-chat-widget.chat-open #chat-fab { display: none !important; }
}

/* Tablet: 480–1023px — floating panel, never full-screen */
@media (min-width: 480px) and (max-width: 1023px) {
    #chat-window {
        width: 380px !important;
        max-width: calc(100vw - 40px) !important;
        height: 520px !important;
        max-height: calc(100vh - 120px) !important;
        border-radius: 16px !important;
        position: absolute !important;
    }
}
</style>

<script>
var chatFAQs = [
    {
        q: "How do I post a job?",
        a: 'Posting a job is easy! Sign up for a free customer account, describe the service you need, set your budget and location, and we\'ll match you with top-rated professionals in your area. You\'ll receive quotes and can choose the best fit.'
    },
    {
        q: "How are professionals verified?",
        a: 'Every professional on Fixly goes through a verification process including identity verification, trade license validation, and experience review. We also check customer ratings and reviews to maintain quality standards.'
    },
    {
        q: "How does payment work?",
        a: 'Fixly uses a secure pay-on-satisfaction model. Funds are held securely until you confirm the job is complete. Only then is the professional paid. This protects both customers and professionals.'
    },
    {
        q: "How do I become a professional?",
        a: 'Sign up for a professional account, complete your profile with your trade, experience, and location, and pass our verification process. Once approved, you\'ll start receiving leads for jobs in your area that match your skills.'
    },
    {
        q: "Is my personal information safe?",
        a: 'Absolutely. Fixly uses industry-standard encryption to protect your data. We never share your personal information with third parties without your explicit consent. Your privacy and security are our top priority.'
    },
    {
        q: "How do I contact support?",
        a: 'You can reach our support team through our Contact Us page. We\'re here to help with any questions or concerns. <a href="/contact">Contact Us →</a>'
    }
];

var chatOpen = false;

function toggleChat() {
    chatOpen = !chatOpen;
    var w = document.getElementById('chat-window');
    var o = document.getElementById('chat-icon-open');
    var c = document.getElementById('chat-icon-close');
    var container = document.getElementById('fixly-chat-widget');
    if (chatOpen) {
        w.style.display = 'flex';
        o.style.display = 'none';
        c.style.display = 'block';
        container.classList.add('chat-open');
        if (window.innerWidth < 480) {
            document.body.style.overflow = 'hidden';
        }
        if (document.getElementById('chat-messages').children.length === 0) {
            showGreeting();
        }
    } else {
        w.style.display = 'none';
        o.style.display = 'block';
        c.style.display = 'none';
        container.classList.remove('chat-open');
        document.body.style.overflow = '';
    }
}

function getTimeStr() {
    var d = new Date();
    var h = d.getHours(), m = d.getMinutes();
    var ampm = h >= 12 ? 'PM' : 'AM';
    h = h % 12 || 12;
    return h + ':' + (m < 10 ? '0' : '') + m + ' ' + ampm;
}

function addBubble(className, content, isHtml) {
    var m = document.getElementById('chat-messages');
    var b = document.createElement('div');
    b.className = className;
    if (isHtml) { b.innerHTML = content; } else { b.textContent = content; }
    var t = document.createElement('div');
    t.className = 'chat-time';
    t.textContent = getTimeStr();
    b.appendChild(t);
    m.appendChild(b);
    m.scrollTop = m.scrollHeight;
}

function addUserBubble(text) { addBubble('chat-bubble-user', text, false); }
function addBotBubble(html) { addBubble('chat-bubble-bot', html, true); }

function showGreeting() {
    var m = document.getElementById('chat-messages');
    m.innerHTML = '';
    addBotBubble('Hi! 👋 How can I help you today?');
    showQuestionList();
}

function showTyping() {
    var m = document.getElementById('chat-messages');
    var t = document.createElement('div');
    t.className = 'chat-typing';
    t.id = 'chat-typing-indicator';
    t.innerHTML = '<span></span><span></span><span></span>';
    m.appendChild(t);
    m.scrollTop = m.scrollHeight;
}

function removeTyping() {
    var t = document.getElementById('chat-typing-indicator');
    if (t) t.remove();
}

function showQuestionList() {
    document.getElementById('question-list').style.display = 'flex';
}

function hideQuestionList() {
    document.getElementById('question-list').style.display = 'none';
}

function showAfterAnswer() {
    var f = document.getElementById('chat-footer');
    var existing = f.querySelector('.chat-after-answer');
    if (existing) return;
    var d = document.createElement('div');
    d.className = 'chat-after-answer';
    d.innerHTML = '<button onclick="askAnother()" id="ask-another-btn">Ask another question</button>' +
        '<a href="/contact">Still need help? Contact Support</a>';
    f.appendChild(d);
}

function findMatchingFAQ(input) {
    var text = input.toLowerCase();
    for (var i = 0; i < chatFAQs.length; i++) {
        if (chatFAQs[i].q.toLowerCase().includes(text) || text.includes(chatFAQs[i].q.toLowerCase().substring(0, 10))) {
            return i;
        }
    }
    return -1;
}

function sendMessage() {
    var input = document.getElementById('chat-input');
    var text = input.value.trim();
    if (!text) return;
    input.value = '';
    hideQuestionList();
    var after = document.querySelector('.chat-after-answer');
    if (after) after.remove();
    addUserBubble(text);
    var match = findMatchingFAQ(text);
    if (match >= 0) {
        showTyping();
        setTimeout(function() {
            removeTyping();
            addBotBubble(chatFAQs[match].a);
            showAfterAnswer();
        }, 500);
    } else {
        showTyping();
        setTimeout(function() {
            removeTyping();
            addBotBubble("I'm not sure about that. Try one of the questions below or <a href='/contact'>contact support</a> for more help.");
            showQuestionList();
        }, 500);
    }
}

function askAnother() {
    var after = document.querySelector('.chat-after-answer');
    if (after) after.remove();
    showQuestionList();
}

function answerQuestion(idx) {
    var faq = chatFAQs[idx];
    hideQuestionList();
    var after = document.querySelector('.chat-after-answer');
    if (after) after.remove();
    addUserBubble(faq.q);
    showTyping();
    setTimeout(function() {
        removeTyping();
        addBotBubble(faq.a);
        showAfterAnswer();
    }, 500);
}

(function() {
    var btns = document.querySelectorAll('.chat-q-btn');
    btns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            answerQuestion(parseInt(this.getAttribute('data-q')));
        });
    });
    document.getElementById('chat-input').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') sendMessage();
    });
})();
</script>
