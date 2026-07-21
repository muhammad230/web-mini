@php
    $hiwIcons = [
        'post' => '<svg width="32" height="32" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M12 12h.01M12 16h.01"/></svg>',
        'match' => '<svg width="32" height="32" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
        'book' => '<svg width="32" height="32" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 14l2 2 4-4"/></svg>',
        'star' => '<svg width="32" height="32" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>',
        'shield' => '<svg width="32" height="32" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
        'lightning' => '<svg width="32" height="32" fill="#fff" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
    ];
@endphp

<section id="how-it-works" class="home-how-it-works" style="background:#f2f1ec; padding:36px 56px 48px;">
    <div style="max-width:960px; margin:0 auto;">

        {{-- Title --}}
        <div style="text-align:center; margin-bottom:48px;">
            <h2 class="section-heading" style="font-size:1.85rem; font-weight:800; color:#111827; margin:0 0 8px;">How It Works</h2>
            <div style="width:48px; height:3px; background:#e07b39; border-radius:2px; margin:0 auto;"></div>
        </div>

        {{-- Steps --}}
        <div class="home-how-it-works-grid" style="display:flex; align-items:flex-start; gap:0;">
            @foreach($howItWorks['steps'] ?? [] as $step)
            <div class="hiw-step" style="flex:1; display:flex; flex-direction:column; align-items:center; text-align:left; padding:0 16px;">
                {{-- Number badge + circle --}}
                <div style="position:relative; margin-bottom:20px;">
                    <div style="position:absolute; top:-6px; left:-6px; z-index:2;
                                width:24px; height:24px; border-radius:50%; background:#e07b39;
                                color:#fff; font-size:0.75rem; font-weight:700;
                                display:flex; align-items:center; justify-content:center;">{{ $loop->iteration }}</div>
                    <div style="width:70px; height:70px; border-radius:50%; background:#1b3a30;
                                display:flex; align-items:center; justify-content:center; box-shadow:0 4px 16px rgba(27,58,48,0.25);">
                        {!! $hiwIcons[$step['icon'] ?? 'post'] !!}
                    </div>
                </div>
                <h3 style="font-size:1rem; font-weight:700; color:#111827; margin:0 0 10px;">{!! $step['title'] ?? '' !!}</h3>
                <p class="hiw-desc" style="font-size:0.8rem; color:#6b7280; line-height:1.7; margin:0; max-width:180px;">
                    {!! $step['description'] ?? '' !!}
                </p>
            </div>
            @if(!$loop->last)
            <div class="hiw-arrow" style="flex-shrink:0; display:flex; align-items:center; padding-top:34px;">
                <svg width="80" height="20" viewBox="0 0 80 20" fill="none">
                    <path d="M4 10 Q20 4 40 10 Q60 16 76 10" stroke="#d4900a" stroke-width="2" stroke-dasharray="5 4" fill="none"/>
                    <path d="M70 6l8 4-8 4" stroke="#d4900a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                </svg>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>

<style>
@media (max-width: 1023px) {
    .home-how-it-works-grid {
        flex-direction: column !important;
        align-items: center !important;
    }
    .hiw-step {
        flex: none !important;
        width: 100% !important;
        max-width: 420px !important;
        padding: 0 !important;
        text-align: center !important;
    }
    .hiw-step .hiw-desc {
        max-width: 100% !important;
    }
    .hiw-arrow {
        padding: 4px 0 !important;
        justify-content: center !important;
    }
    .hiw-arrow svg {
        transform: rotate(90deg);
        transform-origin: center center;
        width: 24px;
        height: 80px;
    }
}
</style>
