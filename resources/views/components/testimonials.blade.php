<section style="background:#f2f1ec; padding:36px 56px 48px;">
    <div style="max-width:960px; margin:0 auto;">
        <div style="text-align:center; margin-bottom:36px;">
            <h2 style="font-size:1.85rem; font-weight:800; color:#111827; margin:0 0 8px;">{{ $testimonials['title'] ?? "What Our Customers Say" }}</h2>
            <div style="width:48px; height:3px; background:#e07b39; border-radius:2px; margin:0 auto;"></div>
        </div>
        @if(($testimonials['mode'] ?? 'auto') === 'auto')
            <p style="text-align:center;color:#9ca3af;font-size:0.85rem;">Top reviews automatically showcased.</p>
        @else
            <p style="text-align:center;color:#9ca3af;font-size:0.85rem;">Curated reviews displayed below.</p>
        @endif
    </div>
</section>
