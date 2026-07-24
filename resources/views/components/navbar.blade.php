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
                <a href="{{ Auth::user()->isCustomer() ? route('dashboard.customer') : (Auth::user()->isProfessional() ? route('dashboard.professional') : route('admin.dashboard')) }}" class="flex items-center gap-2 text-white hover:text-[#E8823C] transition-colors whitespace-nowrap">
                    @if(Auth::user()->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" class="w-8 h-8 rounded-full object-cover" alt="{{ Auth::user()->name }}">
                    @else
                        <div class="w-8 h-8 rounded-full bg-[#E8823C] flex items-center justify-center text-white font-bold text-xs">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    @endif
                    <span class="font-medium">{{ Auth::user()->name }}</span>
                </a>
                <a href="{{ Auth::user()->isCustomer() ? route('dashboard.customer') : (Auth::user()->isProfessional() ? route('dashboard.professional') : route('admin.dashboard')) }}" class="bg-[#E8823C] hover:bg-[#c96a2a] text-white font-semibold px-4 py-2 rounded-lg transition-colors whitespace-nowrap text-sm">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-white font-medium hover:text-[#E8823C] transition-colors whitespace-nowrap">Log out</button>
                </form>
            @else
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

            <!-- Dimmed Backdrop Overlay -->
            <div id="hamburger-backdrop" onclick="closeHamburger()" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.25); backdrop-filter:blur(1px); z-index:9998; opacity:0; transition:opacity 0.2s ease;"></div>

            <!-- Compact Card Dropdown Menu -->
            <div id="hamburger-menu" class="hm-card-menu" style="display:none; position:fixed; top:64px; right:16px; width:220px; max-width:85vw; background:#ffffff; border-radius:18px; box-shadow:0 12px 36px -4px rgba(0,0,0,0.18), 0 4px 14px rgba(0,0,0,0.08); border:1px solid rgba(0,0,0,0.06); z-index:9999; padding:8px 0; opacity:0; transform:scale(0.95) translateY(-8px); transform-origin:top right; transition:opacity 0.2s ease, transform 0.2s ease;">
                <!-- Close Button Top Right -->
                <div style="display:flex; justify-content:flex-end; padding:2px 10px 4px 10px;">
                    <button onclick="closeHamburger()" class="hm-close-btn" aria-label="Close menu">✕</button>
                </div>

                <!-- Clean Menu List Rows -->
                <div class="hm-menu-rows" style="display:flex; flex-direction:column;">
                    @auth
                        <form method="POST" action="{{ route('logout') }}" style="margin:0; padding:0;">
                            @csrf
                            <button type="submit" onclick="closeHamburger()" class="hm-row-item" style="width:100%; border:none; background:none; text-align:left; cursor:pointer;">Log out</button>
                        </form>
                        <a href="{{ Auth::user()->isCustomer() ? route('dashboard.customer') : (Auth::user()->isProfessional() ? route('dashboard.professional') : route('admin.dashboard')) }}" onclick="closeHamburger()" class="hm-row-item">Dashboard</a>
                        <a href="{{ route('home') }}#how-it-works" onclick="closeHamburger()" class="hm-row-item">How it works</a>
                        <a href="{{ route('home') }}#browse" onclick="closeHamburger()" class="hm-row-item">Browse services</a>
                        <a href="{{ route('professionals.why-join') }}" onclick="closeHamburger()" class="hm-row-item">For professionals</a>
                        <a href="{{ route('contact') }}" onclick="closeHamburger()" class="hm-row-item">Contact</a>
                    @else
                        <a href="{{ route('register') }}" onclick="closeHamburger()" class="hm-row-item">Sign up</a>
                        <a href="{{ route('login') }}" onclick="closeHamburger()" class="hm-row-item">Log in</a>
                        <a href="{{ route('home') }}#how-it-works" onclick="closeHamburger()" class="hm-row-item">How it works</a>
                        <a href="{{ route('home') }}#browse" onclick="closeHamburger()" class="hm-row-item">Browse services</a>
                        <a href="{{ route('professionals.why-join') }}" onclick="closeHamburger()" class="hm-row-item">For professionals</a>
                        <a href="{{ route('contact') }}" onclick="closeHamburger()" class="hm-row-item">Contact</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
@media (min-width: 1024px) {
    #hamburger-wrapper,
    #hamburger-backdrop {
        display: none !important;
    }
}
.hm-row-item {
    display: block;
    padding: 12px 20px;
    font-size: 0.95rem;
    font-weight: 500;
    color: #1f2937;
    text-decoration: none;
    transition: background 0.15s ease, color 0.15s ease;
    box-sizing: border-box;
}
.hm-row-item:hover {
    background: #f8fafc;
    color: #E8823C;
}
.hm-menu-rows > :not(:last-child) {
    border-bottom: 1px solid #f1f5f9;
}
.hm-close-btn {
    width: 26px;
    height: 26px;
    border: none;
    background: rgba(0, 0, 0, 0.05);
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 600;
    color: #4b5563;
    transition: background 0.15s ease, color 0.15s ease;
}
.hm-close-btn:hover {
    background: rgba(0, 0, 0, 0.1);
    color: #111827;
}

/* Dark Mode Support */
[data-theme="dark"] #hamburger-menu {
    background: #1e293b !important;
    border-color: rgba(255, 255, 255, 0.1) !important;
    box-shadow: 0 12px 36px rgba(0, 0, 0, 0.6), 0 4px 14px rgba(0, 0, 0, 0.4) !important;
}
[data-theme="dark"] .hm-row-item {
    color: #f3f4f6 !important;
}
[data-theme="dark"] .hm-row-item:hover {
    background: rgba(255, 255, 255, 0.06) !important;
    color: #E8823C !important;
}
[data-theme="dark"] .hm-menu-rows > :not(:last-child) {
    border-bottom-color: rgba(255, 255, 255, 0.08) !important;
}
[data-theme="dark"] .hm-close-btn {
    background: rgba(255, 255, 255, 0.1) !important;
    color: #e2e8f0 !important;
}
[data-theme="dark"] .hm-close-btn:hover {
    background: rgba(255, 255, 255, 0.2) !important;
    color: #ffffff !important;
}
</style>

<script>
var hamburgerOpen = false;

function toggleHamburger(e) {
    if (e) e.stopPropagation();
    var menu = document.getElementById('hamburger-menu');
    var backdrop = document.getElementById('hamburger-backdrop');
    if (hamburgerOpen) {
        closeHamburger();
    } else {
        hamburgerOpen = true;
        if (backdrop) {
            backdrop.style.display = 'block';
            requestAnimationFrame(function() {
                backdrop.style.opacity = '1';
            });
        }
        if (menu) {
            menu.style.display = 'block';
            requestAnimationFrame(function() {
                menu.style.opacity = '1';
                menu.style.transform = 'scale(1) translateY(0)';
            });
        }
    }
}

function closeHamburger() {
    var menu = document.getElementById('hamburger-menu');
    var backdrop = document.getElementById('hamburger-backdrop');
    if (!hamburgerOpen) return;
    hamburgerOpen = false;
    if (backdrop) {
        backdrop.style.opacity = '0';
    }
    if (menu) {
        menu.style.opacity = '0';
        menu.style.transform = 'scale(0.95) translateY(-8px)';
    }
    setTimeout(function() {
        if (backdrop) backdrop.style.display = 'none';
        if (menu) menu.style.display = 'none';
    }, 200);
}

document.addEventListener('click', function(e) {
    if (hamburgerOpen) {
        var menu = document.getElementById('hamburger-menu');
        var btn = document.getElementById('hamburger-btn');
        if (menu && btn && !menu.contains(e.target) && !btn.contains(e.target)) {
            closeHamburger();
        }
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && hamburgerOpen) {
        closeHamburger();
    }
});

window.addEventListener('resize', function() {
    if (window.innerWidth >= 1024 && hamburgerOpen) {
        closeHamburger();
    }
});
</script>
