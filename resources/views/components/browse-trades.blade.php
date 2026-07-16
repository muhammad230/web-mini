<section id="browse" class="home-trades" style="background:#f2f1ec; padding:36px 56px 48px;">
    <div style="max-width:960px; margin:0 auto;">

        {{-- Title --}}
        <div style="text-align:center; margin-bottom:36px;">
            <h2 class="section-heading" style="font-size:1.85rem; font-weight:800; color:#111827; margin:0 0 8px;">Browse by Trade</h2>
            <div style="width:48px; height:3px; background:#e07b39; border-radius:2px; margin:0 auto;"></div>
        </div>

        @php $activeTrades = array_filter($trades['trades'] ?? [], fn($t) => $t['active'] ?? true); @endphp
        @foreach(array_chunk(array_values($activeTrades), 4) as $chunk)
        <div class="home-trades-grid" style="display:grid; grid-template-columns:repeat(4,1fr); gap:14px; {{ !$loop->last ? 'margin-bottom:14px;' : '' }}">
            @foreach($chunk as $trade)
            <a href="#" style="background:{{ $trade['bg'] ?? '#faf9f6' }}; border-radius:14px; padding:18px 16px; display:flex; align-items:flex-start; gap:12px; text-decoration:none; border:1.5px solid transparent;">
                <div style="flex-shrink:0; margin-top:2px;">
                    @include('components.trade-icons', ['icon' => $trade['icon'] ?? 'handyman', 'color' => $trade['colo'] ?? '#111827'])
                </div>
                <div>
                    <div style="font-size:0.88rem; font-weight:700; color:{{ $trade['color'] ?? '#111827' }};">{{ $trade['name'] ?? '' }}</div>
                    <div style="font-size:0.75rem; color:#6b7280; margin-top:3px;">{!! $trade['description'] ?? '' !!}</div>
                </div>
            </a>
            @endforeach
        </div>
        @endforeach
    </div>
</section>
