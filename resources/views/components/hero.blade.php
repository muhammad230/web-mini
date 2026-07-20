<div style="position:relative;">

    {{-- ══ HERO SECTION ══ --}}
    <section class="hero-section" style="position:relative; overflow:hidden; background:#1b3a30; min-height:400px;">

        {{-- Transparent navbar overlaid on dark green --}}
        @include('components.navbar')

        {{-- Room photo fills the right side --}}
        <img src="{{ asset($hero['hero_image'] ?? 'images/slider.png') }}"
             alt="" aria-hidden="true"
             class="hero-overlay-img" style="position:absolute; top:0; right:0; width:75%; height:100%;
                     object-fit:cover; object-position:center center;" />

        {{-- Dark green overlay fades left-to-right so text is readable --}}
        <div style="position:absolute; inset:0;
             background:linear-gradient(to right,
                 #1b3a30 0%,
                 #1b3a30 30%,
                 rgba(27,58,48,0.93) 48%,
                 rgba(27,58,48,0.38) 65%,
                 rgba(27,58,48,0.0) 100%
             );"></div>

        {{-- Hero text content --}}
        <div class="hero-text-wrap" style="position:relative; z-index:10; padding:100px 56px 160px; max-width:560px;">
            <h1 style="margin:0 0 20px 0; font-size:3.1rem; font-weight:800;
                       color:#ffffff; line-height:1.13; letter-spacing:-0.5px;">
                {!! $hero['heading_prefix'] ?? 'Get Your Home<br>Jobs Done&nbsp;' !!}<span style="color:#e8a84c;">{!! $hero['highlight_word'] ?? 'Fast&nbsp;&amp;<br>Reliably' !!}</span>
            </h1>
            <p style="margin:0; font-size:0.88rem; color:#c8d8d2; line-height:1.8; max-width:340px;">
                {!! $hero['subheading'] ?? 'Connect with vetted local professionals for plumbing,<br>electrical, carpentry, and more. Book in minutes,<br>get the job done right.' !!}
            </p>
        </div>

    </section>

    {{-- ══ SEARCH CARD — absolute, centered, overlaps hero bottom ══ --}}
    <div class="search-card-wrap" style="position:absolute; bottom:-100px; left:0; right:0; z-index:30; padding:0 56px;">
        <div class="search-card-inner" style="max-width:920px; margin:0 auto; background:#ffffff;
                    border-radius:18px; box-shadow:0 10px 50px rgba(0,0,0,0.16);
                    padding:26px 30px 22px;">

            <form method="GET" action="{{ route('job.search') }}">

            {{-- Row 1: two inputs + button --}}
            <div class="search-row" style="display:flex; gap:16px; align-items:flex-end; margin-bottom:18px;">

                {{-- Service selector --}}
                <div style="flex:1;">
                    <p style="margin:0 0 8px; font-size:0.78rem; font-weight:600; color:#1f2937;">What do you need done?</p>
                    <div style="display:flex; align-items:center; gap:8px;
                                border:1.5px solid #e2e8f0; border-radius:10px;
                                padding:0 12px; height:48px; background:#fff;">
                        {{-- house icon --}}
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" style="flex-shrink:0;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H15v-5h-6v5H4a1 1 0 01-1-1V9.5z"/>
                        </svg>
                        <select name="trade" style="flex:1; border:none; outline:none; background:transparent;
                                       font-size:0.875rem; color:#6b7280; cursor:pointer; -webkit-appearance:none; appearance:none;">
                            <option value="">Select a service</option>
                            @php $activeTrades = array_filter($trades['trades'] ?? [], fn($t) => $t['active'] ?? true); @endphp
                            @foreach($activeTrades as $trade)
                                <option value="{{ $trade['name'] }}">{{ $trade['name'] }}</option>
                            @endforeach
                        </select>
                        {{-- chevron --}}
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2.5" style="flex-shrink:0;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                {{-- Location input --}}
                <div style="flex:1;">
                    <p style="margin:0 0 8px; font-size:0.78rem; font-weight:600; color:#1f2937;">Your location</p>
                    <div style="display:flex; align-items:center; gap:8px;
                                border:1.5px solid #e2e8f0; border-radius:10px;
                                padding:0 12px; height:48px; background:#fff;">
                        {{-- pin icon --}}
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" style="flex-shrink:0;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <input type="text" name="location" placeholder="{{ $hero['search_placeholder'] ?? 'Enter your city or zip code' }}"
                               style="flex:1; border:none; outline:none; background:transparent;
                                      font-size:0.875rem; color:#374151;" />
                    </div>
                </div>

                {{-- Search button --}}
                <button type="submit" class="touch-btn" style="flex-shrink:0; border:none; cursor:pointer;
                               background:#e07b39; color:#fff; font-weight:600;
                               font-size:0.9rem; height:48px; padding:0 28px;
                               border-radius:10px;"
                        onmouseover="this.style.background='#c96a2a'"
                        onmouseout="this.style.background='#e07b39'">
                    Search
                </button>

            </div>

            </form>

            {{-- Row 2: Post a job for free --}}
            <div style="display:flex; justify-content:center;">
                <a href="{{ route('job.post') }}" class="touch-btn" style="display:inline-flex; align-items:center; gap:7px;
                               font-size:0.875rem; font-weight:500; color:#4b5563;
                               background:#fff; border:1.5px solid #d1d5db;
                               border-radius:10px; padding:10px 26px; cursor:pointer; text-decoration:none;"
                        onmouseover="this.style.borderColor='#e07b39'; this.style.color='#e07b39';"
                        onmouseout="this.style.borderColor='#d1d5db'; this.style.color='#4b5563';">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Post a job for free
                </a>
            </div>

        </div>
    </div>

</div>

{{-- Spacer: clears the 100px card overhang, matches cream background --}}
<div style="height:80px; background:#f2f1ec;"></div>
