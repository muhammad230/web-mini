<div id="fixly-chat-widget" style="position:fixed;bottom:20px;right:20px;z-index:9999;font-family:'Inter',sans-serif;">
    <button id="chat-fab" onclick="toggleChat()" style="width:56px;height:56px;border-radius:50%;background:#E8823C;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 16px rgba(232,130,60,0.4);transition:transform .2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
        <svg id="chat-icon-open" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
        <svg id="chat-icon-close" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>

    <div id="chat-window" style="display:none;position:absolute;bottom:70px;right:0;width:380px;max-width:calc(100vw - 40px);height:520px;max-height:calc(100vh - 120px);background:#fff;border-radius:16px;box-shadow:0 8px 32px rgba(0,0,0,0.18);display:none;flex-direction:column;overflow:hidden;" data-theme-aware>
        <div style="background:#E8823C;padding:16px 20px;display:flex;align-items:center;justify-content:space-between;flex-shrink:0;">
            <div style="display:flex;align-items:center;gap:10px;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                <span style="color:#fff;font-weight:700;font-size:15px;">Fixly Assistant</span>
            </div>
            <button onclick="toggleChat()" style="background:transparent;border:none;cursor:pointer;padding:2px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <div id="chat-messages" style="flex:1;overflow-y:auto;padding:16px;display:flex;flex-direction:column;gap:10px;background:#F5F1EA;">

        </div>

        <div id="chat-footer" style="padding:12px 16px;flex-shrink:0;border-top:1px solid #e5e7eb;">
            <div id="question-list" style="display:flex;flex-direction:column;gap:6px;">
                <button class="chat-q-btn" data-q="0" style="width:100%;padding:10px 14px;border:1.5px solid #E8823C;border-radius:10px;background:transparent;color:#E8823C;font-size:13px;font-weight:600;cursor:pointer;text-align:left;transition:all .15s;" onmouseover="this.style.background='#E8823C';this.style.color='#fff'" onmouseout="this.style.background='transparent';this.style.color='#E8823C'">How do I post a job?</button>
                <button class="chat-q-btn" data-q="1" style="width:100%;padding:10px 14px;border:1.5px solid #E8823C;border-radius:10px;background:transparent;color:#E8823C;font-size:13px;font-weight:600;cursor:pointer;text-align:left;transition:all .15s;" onmouseover="this.style.background='#E8823C';this.style.color='#fff'" onmouseout="this.style.background='transparent';this.style.color='#E8823C'">How are professionals verified?</button>
                <button class="chat-q-btn" data-q="2" style="width:100%;padding:10px 14px;border:1.5px solid #E8823C;border-radius:10px;background:transparent;color:#E8823C;font-size:13px;font-weight:600;cursor:pointer;text-align:left;transition:all .15s;" onmouseover="this.style.background='#E8823C';this.style.color='#fff'" onmouseout="this.style.background='transparent';this.style.color='#E8823C'">How does payment work?</button>
                <button class="chat-q-btn" data-q="3" style="width:100%;padding:10px 14px;border:1.5px solid #E8823C;border-radius:10px;background:transparent;color:#E8823C;font-size:13px;font-weight:600;cursor:pointer;text-align:left;transition:all .15s;" onmouseover="this.style.background='#E8823C';this.style.color='#fff'" onmouseout="this.style.background='transparent';this.style.color='#E8823C'">How do I become a professional?</button>
                <button class="chat-q-btn" data-q="4" style="width:100%;padding:10px 14px;border:1.5px solid #E8823C;border-radius:10px;background:transparent;color:#E8823C;font-size:13px;font-weight:600;cursor:pointer;text-align:left;transition:all .15s;" onmouseover="this.style.background='#E8823C';this.style.color='#fff'" onmouseout="this.style.background='transparent';this.style.color='#E8823C'">Is my personal information safe?</button>
                <button class="chat-q-btn" data-q="5" style="width:100%;padding:10px 14px;border:1.5px solid #E8823C;border-radius:10px;background:transparent;color:#E8823C;font-size:13px;font-weight:600;cursor:pointer;text-align:left;transition:all .15s;" onmouseover="this.style.background='#E8823C';this.style.color='#fff'" onmouseout="this.style.background='transparent';this.style.color='#E8823C'">How do I contact support?</button>
            </div>
        </div>
    </div>
</div>

<style>
#fixly-chat-widget * { box-sizing: border-box; }

#chat-messages::-webkit-scrollbar { width: 4px; }
#chat-messages::-webkit-scrollbar-track { background: transparent; }
#chat-messages::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }

.chat-bubble-user {
    align-self: flex-end;
    max-width: 80%;
    background: #E8823C;
    color: #fff;
    padding: 10px 16px;
    border-radius: 16px 16px 4px 16px;
    font-size: 13px;
    line-height: 1.5;
    word-wrap: break-word;
}

.chat-bubble-bot {
    align-self: flex-start;
    max-width: 80%;
    background: #fff;
    color: #1f2937;
    padding: 10px 16px;
    border-radius: 16px 16px 16px 4px;
    font-size: 13px;
    line-height: 1.5;
    word-wrap: break-word;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
}

.chat-bubble-bot a {
    color: #E8823C;
    font-weight: 600;
    text-decoration: none;
}
.chat-bubble-bot a:hover { text-decoration: underline; }

.chat-typing {
    align-self: flex-start;
    display: flex;
    gap: 4px;
    padding: 12px 16px;
    background: #fff;
    border-radius: 16px 16px 16px 4px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
}
.chat-typing span {
    width: 8px; height: 8px; border-radius: 50%;
    background: #d1d5db; animation: chatBounce 1.4s infinite ease-in-out;
}
.chat-typing span:nth-child(1) { animation-delay: 0s; }
.chat-typing span:nth-child(2) { animation-delay: 0.2s; }
.chat-typing span:nth-child(3) { animation-delay: 0.4s; }

@keyframes chatBounce {
    0%, 80%, 100% { transform: scale(0.6); opacity: 0.4; }
    40% { transform: scale(1); opacity: 1; }
}

/* Dark mode */
[data-theme="dark"] #chat-window {
    background: var(--dm-bg-card, #1E2A28);
    box-shadow: 0 8px 32px rgba(0,0,0,0.4);
}
[data-theme="dark"] #chat-messages {
    background: var(--dm-bg-page, #12181A);
}
[data-theme="dark"] .chat-bubble-bot {
    background: var(--dm-bg-card, #1E2A28);
    color: var(--dm-text-primary, #f3f4f6);
}
[data-theme="dark"] .chat-bubble-bot a { color: var(--dm-accent, #E8823C); }
[data-theme="dark"] .chat-typing {
    background: var(--dm-bg-card, #1E2A28);
}
[data-theme="dark"] .chat-typing span { background: var(--dm-text-muted, #6b7280); }
[data-theme="dark"] #chat-footer {
    border-top-color: var(--dm-border, #374151);
    background: var(--dm-bg-card, #1E2A28);
}
[data-theme="dark"] #chat-window .chat-q-btn {
    border-color: var(--dm-accent, #E8823C);
    color: var(--dm-accent, #E8823C);
}

/* Mobile responsive */
@media (max-width: 640px) {
    #fixly-chat-widget { bottom: 12px; right: 12px; }
    #chat-window {
        position: fixed !important;
        bottom: 0 !important;
        right: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        max-width: 100vw !important;
        max-height: 100vh !important;
        border-radius: 0 !important;
    }
    #chat-fab { width: 50px; height: 50px; }
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
    if (chatOpen) {
        w.style.display = 'flex';
        o.style.display = 'none';
        c.style.display = 'block';
        if (document.getElementById('chat-messages').children.length === 0) {
            showGreeting();
        }
    } else {
        w.style.display = 'none';
        o.style.display = 'block';
        c.style.display = 'none';
    }
}

function showGreeting() {
    var m = document.getElementById('chat-messages');
    m.innerHTML = '';
    addBotBubble('Hi! 👋 How can I help you today?');
    showQuestionList();
}

function addUserBubble(text) {
    var m = document.getElementById('chat-messages');
    var b = document.createElement('div');
    b.className = 'chat-bubble-user';
    b.textContent = text;
    m.appendChild(b);
    m.scrollTop = m.scrollHeight;
}

function addBotBubble(html) {
    var m = document.getElementById('chat-messages');
    var b = document.createElement('div');
    b.className = 'chat-bubble-bot';
    b.innerHTML = html;
    m.appendChild(b);
    m.scrollTop = m.scrollHeight;
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
    d.style.cssText = 'display:flex;flex-direction:column;gap:8px;';
    d.innerHTML = '<button onclick="askAnother()" style="width:100%;padding:10px 14px;border:1.5px solid #E8823C;border-radius:10px;background:transparent;color:#E8823C;font-size:13px;font-weight:600;cursor:pointer;text-align:center;transition:all .15s;" onmouseover="this.style.background=\'#E8823C\';this.style.color=\'#fff\'" onmouseout="this.style.background=\'transparent\';this.style.color=\'#E8823C\'" id="ask-another-btn">Ask another question</button>' +
        '<a href="/contact" style="display:block;text-align:center;padding:8px;font-size:12px;color:#6b7280;text-decoration:none;font-weight:500;" onmouseover="this.style.color=\'#E8823C\'" onmouseout="this.style.color=\'#6b7280\'">Still need help? Contact Support</a>';
    f.appendChild(d);
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
})();
</script>
