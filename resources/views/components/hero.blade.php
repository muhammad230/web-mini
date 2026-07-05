<section class="relative overflow-hidden" style="background-color:#1c3a32;">

    {{-- Full background image — fills entire section --}}
    <img
        src="{{ asset('images/ChatGPT Image Jul 5, 2026, 05_16_55 PM.png') }}"
        alt=""
        aria-hidden="true"
        class="absolute inset-0 w-full h-full object-cover object-right"
        style="opacity:1;"
    />

    {{-- Left-to-right dark overlay: opaque dark green on left, fades out toward right --}}
    <div class="absolute inset-0" style="background: linear-gradient(90deg, #1c3a32 0%, #1c3a32 32%, rgba(28,58,50,0.88) 50%, rgba(28,58,50,0.3) 72%, rgba(28,58,50,0.05) 100%);"></div>

    {{-- Content wrapper --}}
    <div class="relative z-10 max-w-6xl mx-auto px-6 md:px-16">

        {{-- Hero text — left half only --}}
        <div class="pt-16 pb-56" style="max-width:520px;">
            <h1 class="font-extrabold text-white leading-snug mb-5" style="font-size:2.75rem; line-height:1.15;">
                Get Your Home<br>
                Jobs Done <span style="color:#e8a84c;">Fast &amp;<br>Reliably</span>
            </h1>
            <p class="text-gray-300 leading-relaxed" style="font-size:0.9rem; max-width:340px;">
                Connect with vetted local professionals for plumbing,<br>
                electrical, carpentry, and more. Book in minutes,<br>
                get the job done right.
            </p>
        </div>

    </div>

    {{-- ── SEARCH CARD ── sits at bottom, bleeds 50% below section --}}
    <div class="absolute left-0 right-0 z-20 px-6 md:px-16" style="bottom:-88px;">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl" style="padding:28px 32px 24px;">

            {{-- Row 1: service + location + button --}}
            <div class="flex flex-col md:flex-row gap-4 items-end mb-5">

                {{-- Service --}}
                <div class="flex-1 min-w-0">
                    <p class="text-gray-800 text-xs font-semibold mb-2">What do you need done?</p>
                    <div class="flex items-center border border-gray-200 rounded-lg px-3 bg-white" style="height:46px;">
                        <svg class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <select class="flex-1 bg-transparent text-gray-500 text-sm outline-none appearance-none cursor-pointer pr-2">
                            <option value="">Select a service</option>
                            <option>Plumbing</option>
                            <option>Electrical</option>
                            <option>Carpentry</option>
                            <option>Painting</option>
                            <option>AC Repair</option>
                            <option>Cleaning</option>
                            <option>Appliance Repair</option>
                            <option>Handyman</option>
                        </select>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                {{-- Location --}}
                <div class="flex-1 min-w-0">
                    <p class="text-gray-800 text-xs font-semibold mb-2">Your location</p>
                    <div class="flex items-center border border-gray-200 rounded-lg px-3 bg-white" style="height:46px;">
                        <svg class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <input type="text" placeholder="Enter your city or zip code"
                            class="flex-1 bg-transparent text-gray-700 text-sm outline-none placeholder-gray-400">
                    </div>
                </div>

                {{-- Search button --}}
                <button
                    class="flex-shrink-0 bg-[#e07b39] hover:bg-[#c96a2a] text-white font-semibold text-sm rounded-lg transition-colors"
                    style="height:46px; padding:0 28px;">
                    Search
                </button>
            </div>

            {{-- Row 2: Post a job --}}
            <div class="flex justify-center">
                <button class="inline-flex items-center gap-2 text-gray-700 text-sm font-medium border border-gray-300 rounded-lg px-7 py-2.5 hover:border-[#e07b39] hover:text-[#e07b39] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Post a job for free
                </button>
            </div>

        </div>
    </div>

</section>

{{-- Spacer = search card height (≈175px) + some breathing room --}}
<div style="height:110px; background:#f5f4ef;"></div>
