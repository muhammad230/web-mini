@php
    $icons = [
        'shield' => '<svg width="24" height="24" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
        'lightning' => '<svg width="24" height="24" fill="#fff" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
        'briefcase' => '<svg width="24" height="24" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/><line x1="12" y1="12" x2="12" y2="16" stroke="#fff" stroke-width="2" stroke-linecap="round"/><line x1="10" y1="14" x2="14" y2="14" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>',
        'star' => '<svg width="24" height="24" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>',
        'users' => '<svg width="24" height="24" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
        'clock' => '<svg width="24" height="24" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
        'check' => '<svg width="24" height="24" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        'thumbsup' => '<svg width="24" height="24" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>',
    ];
@endphp

<section class="home-stats" style="background:#f2f1ec; padding:32px 56px 40px;">
    <div class="home-stats-grid" style="max-width:960px; margin:0 auto; display:grid; grid-template-columns:repeat(4,1fr); gap:16px;">
        @foreach($statsBar['stats'] ?? [] as $stat)
        <div style="background:#fff; border:1px solid #e5e7eb; border-radius:14px; padding:20px 20px; display:flex; align-items:center; gap:16px;">
            <div style="flex-shrink:0; width:52px; height:52px; border-radius:50%; background:{{ $loop->index % 2 === 0 ? '#1b3a30' : '#d4900a' }}; display:flex; align-items:center; justify-content:center;">
                {!! $icons[$stat['icon'] ?? 'shield'] !!}
            </div>
            <div>
                <div style="font-size:1.4rem; font-weight:700; color:#111827; line-height:1.2;">{!! $stat['number'] ?? '' !!}</div>
                <div style="font-size:0.75rem; color:#6b7280; line-height:1.4; margin-top:2px;">{!! $stat['label'] ?? '' !!}</div>
            </div>
        </div>
        @endforeach
    </div>
</section>
