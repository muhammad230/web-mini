{{-- ================================================================
     HERO SECTION
     - Dark green background with living room photo on right
     - Text on the left
     - White search card overlaps the bottom of this section
     ================================================================ --}}

{{-- Outer wrapper: positions hero + overlapping search card together --}}
<div style="position:relative;">

    {{-- ── Dark green hero with background image ── --}}
    <section style="position:relative; overflow:hidden; background:#1b3a30; min-height:420px;">

        {{-- Background photo --}}
        <img src="{{ asset('images/ChatGPT Image Jul 5, 2026, 05_16_55 PM.png') }}"
             alt="" aria-hidden="true"
             style="position:absolute; inset:0; width:100%; height:100%;
                    object-fit:cover; object-position:right center; opacity:1;" />

        {{-- Gradient: opaque dark-green left → transparent right --}}
        <div style="position:absolute; inset:0;
                    background:linear-gradient(90deg,
                        #1b3a30 0%,
                        #1b3a30 28%,
                        rgba(27,58,48,0.92) 46%,
                        rgba(27,58,48,0.35) 68%,
                        rgba(27,58,48,0.0) 100%
                    );"></div>

        {{-- Content on top --}}
        <div style="position:relative; z-index:10; max-width:1100px; margin:0 auto;
                    padding:3rem 3.5rem 7rem;">
            <h1 style="font-size:3rem; font-weight:800; color:#fff;
                       line-height:1.15; letter-spacing:-0.5px; margin:0 0 1.25rem 0;
                       max-width:480px;">
                Get Your Home<br>
                Jobs Done
                <span style="color:#e8a74c;">Fast &amp;<br>Reliably</span>
            </h1>
            <p style="font-size:0.875rem; color:#cbd5e1; line-height:1.75;
                      max-width:340px; margin:0;">
                Connect with vetted local professionals for plumbing,<br>
                electrical, carpentry, and more. Book in minutes,<br>
                get the job done right.
            </p>
        </div>

    </section>

    {{-- ── Search card: overlaps hero bottom by ~50% ── --}}
    <div style="position:absolute; bottom:-95px; left:0; right:0; z-index:20;
                padding:0 3.5rem;">
        <div style="max-width:900px; margin:0 auto; background:#fff;
                    border-radius:1.25rem; box-shadow:0 8px 40px rgba(0,0,0,0.14);
                    padding:1.75rem 2rem 1.5rem;">

            {{-- Row 1 --}}
            <div style="display:flex; gap:1rem; align-items:flex-end; margin-bottom:1.1rem;
                        flex-wrap:wrap;">

                {{-- Service --}}
                <div style="flex:1; min-width:200px;">
                    <p style="font-size:0.78rem; font-weight:600; color:#1f2937;
                               margin:0 0 0.5rem 0;">What do you need done?</p>
                    <div style="display:flex; align-items:center; gap:0.5rem;
                                border:1.5px solid #e5e7eb; border-radius:0.6rem;
                                padding:0 0.75rem; height:46px; background:#fff;">
                        <svg width="16" height="16" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <select style="flex:1; border:none; outline:none; background:transparent;
                                       font-size:0.875rem; color:#6b7280; cursor:pointer; appearance:none;">
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
                        <svg width="14" height="14" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                {{-- Location --}}
                <div style="flex:1; min-width:200px;">
                    <p style="font-size:0.78rem; font-weight:600; color:#1f2937;
                               margin:0 0 0.5rem 0;">Your location</p>
                    <div style="display:flex; align-items:center; gap:0.5rem;
                                border:1.5px solid #e5e7eb; border-radius:0.6rem;
                                padding:0 0.75rem; height:46px; background:#fff;">
                        <svg width="16" height="16" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <input type="text" placeholder="Enter your city or zip code"
                               style="flex:1; border:none; outline:none; background:transparent;
                                      font-size:0.875rem; color:#374151;" />
                    </div>
                </div>

                {{-- Search button --}}
                <button style="flex-shrink:0; background:#e07b39; color:#fff;
                               font-size:0.9rem; font-weight:600; border:none; cursor:pointer;
                               border-radius:0.6rem; height:46px; padding:0 1.75rem;
                               transition:background 0.15s;"
                        onmouseover="this.style.background='#c96a2a'"
                        onmouseout="this.style.background='#e07b39'">
                    Search
                </button>

            </div>

            {{-- Row 2: Post a job --}}
            <div style="display:flex; justify-content:center;">
                <button style="display:inline-flex; align-items:center; gap:0.5rem;
                               font-size:0.875rem; font-weight:500; color:#374151;
                               border:1.5px solid #d1d5db; border-radius:0.6rem;
                               padding:0.6rem 1.75rem; background:#fff; cursor:pointer;
                               transition:border-color 0.15s, color 0.15s;"
                        onmouseover="this.style.borderColor='#e07b39'; this.style.color='#e07b39';"
                        onmouseout="this.style.borderColor='#d1d5db'; this.style.color='#374151';">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Post a job for free
                </button>
            </div>

        </div>
    </div>

</div>

{{-- Spacer so next section clears the overlapping card --}}
<div style="height:115px; background:#f2f1ec;"></div>
