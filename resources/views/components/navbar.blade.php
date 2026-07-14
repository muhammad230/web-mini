<nav class="w-full px-6 md:px-12 py-6 flex items-center justify-between absolute top-0 left-0 z-50">
    {{-- Logo --}}
    <a href="{{ route('home') }}" style="display:flex; align-items:center; gap:8px; text-decoration:none;">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
            <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H15v-5h-6v5H4a1 1 0 01-1-1V9.5z" fill="#E8823C"/>
        </svg>
        <span class="text-white font-bold" style="font-size:1.25rem; line-height:1;">Fix<span style="color:#E8823C;">ly</span></span>
    </a>

    {{-- Nav Links --}}
    <ul class="hidden md:flex items-center gap-8 text-white font-medium">
        @foreach($navData['links'] ?? [] as $link)
            <li><a href="{{ $link['url'] ?? '#' }}" class="hover:text-[#E8823C] transition-colors">{{ $link['label'] ?? '' }}</a></li>
        @endforeach
    </ul>

    {{-- Auth Buttons --}}
    <div class="flex items-center gap-4" style="color:#fff;">
        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-white font-medium hover:text-[#E8823C] transition-colors">Log out</button>
            </form>
        @else
            @include('partials.theme-toggle')
            <a href="{{ route('login') }}" class="text-white font-medium hover:text-[#E8823C] transition-colors">Log in</a>
            <div class="relative group">
                <button class="bg-[#E8823C] hover:bg-[#c96a2a] text-white font-semibold px-6 py-2 rounded-lg transition-colors cursor-pointer flex items-center gap-1.5">
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
</nav>
