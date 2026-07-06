<section id="professionals" style="background:#f2f1ec; padding:36px 56px 48px;">
    <div style="max-width:960px; margin:0 auto;">
        <div style="text-align:center; margin-bottom:40px;">
            <h2 style="font-size:1.85rem; font-weight:800; color:#111827; margin:0 0 8px;">{{ $featuredPros['title'] ?? 'Featured Professionals' }}</h2>
            <div style="width:48px; height:3px; background:#e07b39; border-radius:2px; margin:0 auto;"></div>
        </div>
        @if(($featuredPros['mode'] ?? 'auto') === 'auto')
            <p style="text-align:center;color:#9ca3af;font-size:0.85rem;">Top-rated professionals automatically featured.</p>
        @else
            <p style="text-align:center;color:#9ca3af;font-size:0.85rem;">Hand-picked professionals displayed below.</p>
        @endif
    </div>
</section>
