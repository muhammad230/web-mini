<nav class="w-full px-6 md:px-12 py-6 flex items-center justify-between absolute top-0 left-0 z-50">
    {{-- Logo --}}
    <a href="{{ route('home') }}" class="flex items-center gap-2">
        <span class="text-4xl">🏠</span>
        <span class="text-white text-3xl font-bold">Fix<span class="text-[#E8823C]">It</span></span>
    </a>

    {{-- Nav Links --}}
    <ul class="hidden md:flex items-center gap-8 text-white font-medium">
        <li><a href="#how-it-works" class="hover:text-[#E8823C] transition-colors">How it works</a></li>
        <li><a href="#browse" class="hover:text-[#E8823C] transition-colors">Browse services</a></li>
        <li><a href="#professionals" class="hover:text-[#E8823C] transition-colors">For professionals</a></li>
    </ul>

    {{-- Auth Buttons --}}
    <div class="flex items-center gap-4">
        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-white font-medium hover:text-[#E8823C] transition-colors">Log out</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="text-white font-medium hover:text-[#E8823C] transition-colors">Log in</a>
            <a href="{{ route('register') }}" class="bg-[#E8823C] hover:bg-[#c96a2a] text-white font-semibold px-6 py-2 rounded-lg transition-colors">Sign up</a>
        @endauth
    </div>
</nav>
