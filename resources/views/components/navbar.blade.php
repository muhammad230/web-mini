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

        {{-- Hamburger (all screens) --}}
        <div style="position:relative; display:flex;">
            <button id="hamburger-btn" onclick="toggleHamburger(event)" style="width:40px; height:40px; border-radius:8px; background:transparent; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; color:#fff;" aria-label="Menu">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>

            <div id="hamburger-menu" style="display:none; position:absolute; top:100%; right:0; margin-top:8px; width:260px; background:#fff; border-radius:14px; box-shadow:0 8px 32px rgba(0,0,0,0.2); z-index:9999; padding:8px 0; opacity:0; transform:translateY(-6px); transition:opacity 0.2s ease, transform 0.2s ease;" data-hamburger>
                <div style="display:flex; flex-direction:column;">
                    @foreach($navData['links'] ?? [] as $link)
                        <a href="{{ $link['url'] ?? '#' }}" onclick="closeHamburger()" style="padding:12px 20px; font-size:0.9rem; font-weight:500; color:#374151; text-decoration:none; transition:background 0.1s;" onmouseover="this.style.background='#F5F1EA'" onmouseout="this.style.background='transparent'">{{ $link['label'] ?? '' }}</a>
                    @endforeach
                    <a href="{{ route('contact') }}" onclick="closeHamburger()" style="padding:12px 20px; font-size:0.9rem; font-weight:500; color:#374151; text-decoration:none; transition:background 0.1s;" onmouseover="this.style.background='#F5F1EA'" onmouseout="this.style.background='transparent'">Contact</a>
                </div>

                <div style="height:1px; background:#e5e7eb; margin:4px 0;"></div>

                <div style="padding:8px 14px;">
                    @include('partials.theme-toggle')
                </div>

                <div style="height:1px; background:#e5e7eb; margin:4px 0;"></div>

                <div style="display:flex; flex-direction:column;">
                    @auth
                        <form method="POST" action="{{ route('logout') }}" style="margin:0; padding:0;">
                            @csrf
                            <button type="submit" onclick="closeHamburger()" style="width:100%; padding:12px 20px; font-size:0.9rem; font-weight:500; color:#374151; background:none; border:none; cursor:pointer; text-align:left; text-decoration:none; transition:background 0.1s;" onmouseover="this.style.background='#F5F1EA'" onmouseout="this.style.background='transparent'">Log out</button>
                        </form>
                    @else
                        <div style="display:flex; flex-direction:column;">
                            <a href="{{ route('login') }}" onclick="closeHamburger()" style="padding:12px 20px; font-size:0.9rem; font-weight:500; color:#374151; text-decoration:none; transition:background 0.1s;" onmouseover="this.style.background='#F5F1EA'" onmouseout="this.style.background='transparent'">Log in</a>
                            <a href="{{ route('register') }}" onclick="closeHamburger()" style="padding:12px 20px; font-size:0.9rem; font-weight:600; color:#E8823C; text-decoration:none; transition:background 0.1s;" onmouseover="this.style.background='#F5F1EA'" onmouseout="this.style.background='transparent'">Sign up as Customer</a>
                            <a href="{{ route('professionals.why-join') }}" onclick="closeHamburger()" style="padding:12px 20px; font-size:0.9rem; font-weight:600; color:#E8823C; text-decoration:none; transition:background 0.1s;" onmouseover="this.style.background='#F5F1EA'" onmouseout="this.style.background='transparent'">Sign up as Professional</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
#hamburger-menu {
    max-width: calc(100vw - 32px);
}
[data-theme="dark"] #hamburger-menu {
    background: #1E2A28 !important;
    box-shadow: 0 8px 32px rgba(0,0,0,0.5) !important;
}
[data-theme="dark"] #hamburger-menu a,
[data-theme="dark"] #hamburger-menu button {
    color: #d1d5db !important;
}
[data-theme="dark"] #hamburger-menu a[style*="color:#E8823C"],
[data-theme="dark"] #hamburger-menu [style*="color:#E8823C"] {
    color: #E8823C !important;
}
[data-theme="dark"] #hamburger-menu [style*="background:#F5F1EA"] {
    background: rgba(255,255,255,0.05) !important;
}
[data-theme="dark"] #hamburger-menu [style*="background:#e5e7eb"] {
    background: #374151 !important;
}
#hamburger-menu .theme-toggle-btn {
    width: 34px;
    height: 34px;
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
</script>
