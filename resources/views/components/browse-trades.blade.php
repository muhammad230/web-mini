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
            <a href="#" class="trade-card">
                <div class="trade-icon-badge">
                    @include('components.trade-icons', ['icon' => $trade['icon'] ?? 'handyman', 'color' => '#ffffff'])
                </div>
                <div class="trade-text">
                    <div class="trade-name">{{ $trade['name'] ?? '' }}</div>
                    <div class="trade-desc">{!! $trade['description'] ?? '' !!}</div>
                </div>
            </a>
            @endforeach
        </div>
        @endforeach
    </div>
</section>

<style>
.trade-card {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    text-decoration: none;
    background: #F5F1EA;
    border-radius: 14px;
    padding: 18px 16px;
    border: 1.5px solid #e5e7eb;
    transition: background 0.2s, border-color 0.2s;
    cursor: default;
}
.trade-card:hover {
    border-color: #E8823C;
}
.trade-icon-badge {
    flex-shrink: 0;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #E8823C;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 2px;
}
.trade-icon-badge svg {
    display: block;
}
.trade-text {
    flex: 1;
    min-width: 0;
}
.trade-name {
    font-size: 0.88rem;
    font-weight: 700;
    color: #111827;
}
.trade-desc {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 3px;
}
[data-theme="dark"] .trade-card {
    border-color: #2d4a3a !important;
    cursor: default !important;
}
[data-theme="dark"] .trade-name {
    color: #e2e8f0 !important;
}
[data-theme="dark"] .trade-desc {
    color: #9ca3af !important;
}
[data-theme="dark"] .trade-icon-badge {
    background: #E8823C !important;
}
</style>
