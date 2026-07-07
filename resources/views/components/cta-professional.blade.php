<section style="background:#f2f1ec; padding:0 56px 16px; box-sizing:border-box; width:100%;">
    <div style="background:#1b3a30; border-radius:14px; padding:24px 36px;
                display:flex; align-items:center; justify-content:space-between; gap:24px;
                max-width:960px; margin:0 auto;">

        <div style="display:flex; align-items:center; gap:18px;">
            <div style="flex-shrink:0;">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                    <circle cx="24" cy="13" r="7" stroke="#d4900a" stroke-width="2"/>
                    <path d="M13 19s-2 13 11 13 11-13 11-13" stroke="#d4900a" stroke-width="2" stroke-linecap="round"/>
                    <path d="M9 42c0-8.284 6.716-15 15-15s15 6.716 15 15" stroke="#d4900a" stroke-width="2" stroke-linecap="round"/>
                    <rect x="17" y="5" width="14" height="5" rx="2.5" stroke="#d4900a" stroke-width="1.5"/>
                </svg>
            </div>
            <div>
                <h3 style="font-size:1.1rem; font-weight:700; color:#fff; margin:0 0 4px;">{{ $ctaBanner['heading'] ?? 'Are You a Home Service Professional?' }}</h3>
                <p style="font-size:0.82rem; color:#8aaa9e; margin:0;">{{ $ctaBanner['description'] ?? 'Join FixIt and get access to hundreds of local job leads every month.' }}</p>
            </div>
        </div>

        <a href="{{ route('register', ['role' => 'professional']) }}" style="flex-shrink:0; background:#e07b39; color:#fff; font-size:0.875rem;
                           font-weight:600; padding:11px 26px; border-radius:8px; text-decoration:none;
                           white-space:nowrap;"
           onmouseover="this.style.background='#c96a2a'" onmouseout="this.style.background='#e07b39'">
            {{ $ctaBanner['button_text'] ?? 'Join as a professional' }}
        </a>

    </div>
</section>
