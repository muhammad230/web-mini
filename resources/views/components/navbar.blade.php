<nav class="relative z-50 w-full flex items-center justify-between px-6 md:px-14 py-5">

    {{-- ── Logo ── --}}
    <a href="#" class="flex items-center gap-2">
        {{-- Orange house icon — no background rect, just the shape --}}
        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- house outline -->
            <path d="M15 3L2 13H5.5V27H11.5V19.5H18.5V27H24.5V13H28L15 3Z" fill="#e07b39"/>
            <!-- small wrench / tool accent at bottom-right of house -->
            <circle cx="21" cy="22" r="2.2" fill="#c96a2a"/>
        </svg>
        <span class="text-white text-[1.25rem] font-bold tracking-tight leading-none">
            Fix<span class="text-[#e07b39]">It</span>
        </span>
    </a>

    {{-- ── Nav Links ── --}}
    <ul class="hidden md:flex items-center gap-9">
        <li>
            <a href="#how-it-works"
               class="text-white text-[0.875rem] font-medium hover:text-[#e07b39] transition-colors duration-150">
                How it works
            </a>
        </li>
        <li>
            <a href="#browse"
               class="text-white text-[0.875rem] font-medium hover:text-[#e07b39] transition-colors duration-150">
                Browse services
            </a>
        </li>
        <li>
            <a href="#professionals"
               class="text-white text-[0.875rem] font-medium hover:text-[#e07b39] transition-colors duration-150">
                For professionals
            </a>
        </li>
    </ul>

    {{-- ── Auth ── --}}
    <div class="flex items-center gap-5">
        <a href="#"
           class="text-white text-[0.875rem] font-medium hover:text-[#e07b39] transition-colors duration-150">
            Log in
        </a>
        <a href="#"
           class="bg-[#e07b39] hover:bg-[#c96a2a] text-white text-[0.875rem] font-semibold
                  px-5 py-2 rounded-lg transition-colors duration-150">
            Sign up
        </a>
    </div>

</nav>
