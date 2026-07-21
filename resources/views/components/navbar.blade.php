<nav class="w-full px-4 md:px-12 py-4 md:py-6 flex items-center justify-between absolute top-0 left-0 z-50">
    {{-- Logo --}}
    <a href="{{ route('home') }}" style="display:flex; align-items:center; gap:8px; text-decoration:none;">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" class="md:w-[28px] md:h-[28px]">
            <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H15v-5h-6v5H4a1 1 0 01-1-1V9.5z" fill="#E8823C"/>
        </svg>
        <span class="text-white font-bold" style="font-size:1.1rem;line-height:1;">Fix<span style="color:#E8823C;">ly</span></span>
    </a>

    {{-- Nav Links (desktop) --}}
    <ul class="hidden lg:flex items-center gap-8 text-white font-medium">
        @foreach($navData['links'] ?? [] as $link)
            <li><a href="{{ $link['url'] ?? '#' }}" class="hover:text-[#E8823C] transition-colors whitespace-nowrap">{{ $link['label'] ?? '' }}</a></li>
        @endforeach
        <li><a href="{{ route('contact') }}" class="hover:text-[#E8823C] transition-colors whitespace-nowrap">Contact</a></li>
    </ul>

    {{-- Right side: desktop auth + hamburger (all screens) --}}
    <div style="display:flex; align-items:center; gap:12px;">
        {{-- Desktop auth buttons --}}
        <div class="hidden lg:flex items-center gap-4" style="color:#fff;">
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-white font-medium hover:text-[#E8823C] transition-colors whitespace-nowrap">Log out</button>
                </form>
            @else
                @include('partials.theme-toggle')
                <a href="{{ route('login') }}" class="text-white font-medium hover:text-[#E8823C] transition-colors whitespace-nowrap">Log in</a>
                <div class="relative group">
                    <button class="bg-[#E8823C] hover:bg-[#c96a2a] text-white font-semibold px-5 py-2 rounded-lg transition-colors cursor-pointer flex items-center gap-1.5 text-sm">
                        Sign up
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 overflow-hidden">
                        <a href="{{ route('register') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#E8823C] font-medium border-b border-gray-100">Sign up as Customer</a>
                        <a href="{{ route('professionals.why-join') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#E8823C] font-medium">Sign up as Professional</a>
                    </div>
                </div>
            @endauth
        </div>

        {{-- Theme toggle (mobile/tablet) --}}
        <div class="lg:hidden" style="display:flex; align-items:center;">
            @include('partials.theme-toggle')
        </div>

        {{-- Hamburger (mobile/tablet only) --}}
        <div id="hamburger-wrapper" style="position:relative; display:flex;">
            <button id="hamburger-btn" onclick="toggleHamburger(event)" style="width:40px; height:40px; border-radius:8px; background:transparent; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; color:#fff;" aria-label="Menu">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>

            <div id="hamburger-menu" class="hm-menu" style="display:none; position:fixed; top:70px; right:16px; background:#F5F1EA; border-radius:14px; box-shadow:0 8px 32px rgba(0,0,0,0.15); z-index:9999; padding:8px 0; opacity:0; transform:translateY(-6px); transition:opacity 0.2s ease, transform 0.2s ease;">
                <div style="display:flex; justify-content:flex-end; padding:0 10px 0 0;">
                    <button onclick="closeHamburger()" class="hm-close-btn" aria-label="Close menu">✕</button>
                </div>
                <div style="display:flex; flex-direction:column;">
                    @foreach($navData['links'] ?? [] as $link)
                        <a href="{{ $link['url'] ?? '#' }}" onclick="closeHamburger()" style="display:block; padding:12px 20px; font-size:0.9rem; font-weight:500; color:#1f2937; text-decoration:none; transition:background 0.1s;" onmouseover="this.style.background='#ece8df'" onmouseout="this.style.background='transparent'">{{ $link['label'] ?? '' }}</a>
                    @endforeach
                    <a href="{{ route('contact') }}" onclick="closeHamburger()" style="display:block; padding:12px 20px; font-size:0.9rem; font-weight:500; color:#1f2937; text-decoration:none; transition:background 0.1s;" onmouseover="this.style.background='#ece8df'" onmouseout="this.style.background='transparent'">Contact</a>
                </div>

                <div class="hm-divider" style="height:1px; background:#e0dcd3; margin:6px 0;"></div>

                <div style="display:flex; flex-direction:column;">
                    @auth
                        <form method="POST" action="{{ route('logout') }}" style="margin:0; padding:0;">
                            @csrf
                            <button type="submit" onclick="closeHamburger()" style="width:100%; padding:12px 20px; font-size:0.9rem; font-weight:500; color:#1f2937; background:none; border:none; cursor:pointer; text-align:left; transition:background 0.1s;" onmouseover="this.style.background='#ece8df'" onmouseout="this.style.background='transparent'">Log out</button>
                        </form>
                    @else
                        <div style="display:flex; flex-direction:column; gap:8px; padding:12px 16px 16px;">
                            <a href="{{ route('login') }}" onclick="closeHamburger()" style="display:block; padding:10px 0; font-size:0.9rem; font-weight:500; color:#1f2937; text-decoration:none; border-bottom:1px solid #e0dcd3;">Log in</a>
                            <a href="{{ route('register') }}" onclick="closeHamburger()" style="display:block; text-align:center; background:#E8823C; color:#fff; font-weight:600; font-size:0.9rem; padding:11px 0; border-radius:8px; text-decoration:none; width:100%;">Sign up</a>
                            <a href="{{ route('professionals.why-join') }}" onclick="closeHamburger()" style="display:block; text-align:center; font-size:0.85rem; font-weight:500; color:#E8823C; text-decoration:none; padding:2px 0;">I'm a professional</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
@media (min-width: 1024px) {
    #hamburger-wrapper { display: none !important; }
}
.hm-menu {
    max-height: 420px;
    overflow-y: auto;
}
@media (max-width: 399px) {
    .hm-menu { width: 285px !important; right: 12px !important; left: auto !important; }
}
@media (min-width: 400px) and (max-width: 767px) {
    .hm-menu { width: 300px !important; right: 14px !important; }
}
@media (min-width: 768px) and (max-width: 1023px) {
    .hm-menu { width: 360px !important; right: 16px !important; }
}
.hm-close-btn {
    width: 28px;
    height: 28px;
    border: none;
    background: rgba(0,0,0,0.06);
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    color: #1f2937;
    transition: background 0.15s;
}
.hm-close-btn:hover {
    background: rgba(0,0,0,0.12);
}
#hamburger-menu a,
#hamburger-menu button {
    color: #1f2937;
}
#hamburger-menu .hm-divider {
    background: #e0dcd3 !important;
}
[data-theme="dark"] #hamburger-menu {
    background: #1a2422 !important;
    box-shadow: 0 8px 32px rgba(0,0,0,0.5) !important;
}
[data-theme="dark"] #hamburger-menu a,
[data-theme="dark"] #hamburger-menu button {
    color: #e2e8f0 !important;
}
[data-theme="dark"] #hamburger-menu .hm-divider {
    background: #2d4a3a !important;
}
[data-theme="dark"] #hamburger-menu [style*="color:#E8823C"] {
    color: #E8823C !important;
}
[data-theme="dark"] #hamburger-menu [style*="background:#ece8df"] {
    background: rgba(255,255,255,0.06) !important;
}
[data-theme="dark"] #hamburger-menu [style*="background:#E8823C"] {
    background: #E8823C !important;
}
[data-theme="dark"] #hamburger-menu [style*="border-bottom:1px solid #e0dcd3"] {
    border-bottom-color: #2d4a3a !important;
}
[data-theme="dark"] .hm-close-btn {
    background: rgba(255,255,255,0.08) !important;
    color: #e2e8f0 !important;
}
[data-theme="dark"] .hm-close-btn:hover {
    background: rgba(255,255,255,0.15) !important;
}
</style>

<script>
var hamburgerOpen = false;

function toggleHamburger(e) {
    e.stopPropagation();
    var menu = document.getElementById('hamburger-menu');
    if (hamburgerOpen) {
        closeHamburger();
    } else {
        hamburgerOpen = true;
        menu.style.display = 'block';
        requestAnimationFrame(function() {
            menu.style.opacity = '1';
            menu.style.transform = 'translateY(0)';
        });
    }
}

function closeHamburger() {
    var menu = document.getElementById('hamburger-menu');
    if (!hamburgerOpen) return;
    hamburgerOpen = false;
    menu.style.opacity = '0';
    menu.style.transform = 'translateY(-6px)';
    setTimeout(function() {
        menu.style.display = 'none';
    }, 200);
}

document.addEventListener('click', function(e) {
    if (hamburgerOpen) {
        var menu = document.getElementById('hamburger-menu');
        var btn = document.getElementById('hamburger-btn');
        if (!menu.contains(e.target) && !btn.contains(e.target)) {
            closeHamburger();
        }
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && hamburgerOpen) {
        closeHamburger();
    }
});

window.addEventListener('scroll', function() {
    if (hamburgerOpen) {
        closeHamburger();
    }
}, { passive: true });
</script>
