<footer class="home-footer" style="background:#1b3a30; padding:44px 56px 28px; width:100%; box-sizing:border-box;">
    <div style="max-width:960px; margin:0 auto;">

        {{-- Top: 4 columns --}}
        <div class="home-footer-grid" style="display:grid; grid-template-columns:1.6fr 1fr 1fr 1fr; gap:40px; margin-bottom:36px;">

            {{-- Brand column --}}
            <div>
                <div style="display:flex; align-items:center; gap:8px; margin-bottom:14px;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                        <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H15v-5h-6v5H4a1 1 0 01-1-1V9.5z" fill="#e07b39"/>
                    </svg>
                    <span style="font-size:1.1rem; font-weight:700; color:#fff;">Fix<span style="color:#e07b39;">ly</span></span>
                </div>
                <p style="font-size:0.78rem; color:#8aaa9e; line-height:1.7; margin:0 0 18px; max-width:200px;">
                    {{ $footerData['company_description'] ?? 'Connecting homeowners with reliable local professionals for all their home service needs.' }}
                </p>
                {{-- Social icons --}}
                <div style="display:flex; gap:10px;">
                    @php $social = $footerData['social'] ?? []; @endphp
                    @if(($social['facebook'] ?? '') !== '#')
                    <a href="{{ $social['facebook'] ?? '#' }}" target="_blank" style="width:32px; height:32px; border-radius:50%; border:1.5px solid #2d5a4a; display:flex; align-items:center; justify-content:center; text-decoration:none;"
                       onmouseover="this.style.borderColor='#e07b39'" onmouseout="this.style.borderColor='#2d5a4a'">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="#8aaa9e"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                    </a>
                    @endif
                    @if(($social['instagram'] ?? '') !== '#')
                    <a href="{{ $social['instagram'] ?? '#' }}" target="_blank" style="width:32px; height:32px; border-radius:50%; border:1.5px solid #2d5a4a; display:flex; align-items:center; justify-content:center; text-decoration:none;"
                       onmouseover="this.style.borderColor='#e07b39'" onmouseout="this.style.borderColor='#2d5a4a'">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8aaa9e" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="#8aaa9e"/></svg>
                    </a>
                    @endif
                    @if(($social['twitter'] ?? '') !== '#')
                    <a href="{{ $social['twitter'] ?? '#' }}" target="_blank" style="width:32px; height:32px; border-radius:50%; border:1.5px solid #2d5a4a; display:flex; align-items:center; justify-content:center; text-decoration:none;"
                       onmouseover="this.style.borderColor='#e07b39'" onmouseout="this.style.borderColor='#2d5a4a'">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="#8aaa9e"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
                    </a>
                    @endif
                    @if(($social['youtube'] ?? '') !== '#')
                    <a href="{{ $social['youtube'] ?? '#' }}" target="_blank" style="width:32px; height:32px; border-radius:50%; border:1.5px solid #2d5a4a; display:flex; align-items:center; justify-content:center; text-decoration:none;"
                       onmouseover="this.style.borderColor='#e07b39'" onmouseout="this.style.borderColor='#2d5a4a'">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8aaa9e" stroke-width="2"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="#8aaa9e" stroke="none"/></svg>
                    </a>
                    @endif
                </div>
            </div>

            {{-- Link groups --}}
            @php
                $fallbackUrls = [
                    'About us' => route('about'),
                    'Careers' => route('careers'),
                    'Press' => route('press'),
                    'How it works' => '/#how-it-works',
                    'Browse services' => '/#browse',
                    'Help center' => route('contact'),
                    'Join as a pro' => route('professionals.why-join'),
                    'Pro dashboard' => route('dashboard.professional'),
                    'Resources' => route('resources'),
                ];
            @endphp
            @foreach($footerData['link_groups'] ?? [] as $group)
            <div>
                <h4 style="font-size:0.9rem; font-weight:700; color:#fff; margin:0 0 16px;">{{ $group['title'] ?? '' }}</h4>
                <div style="display:flex; flex-direction:column; gap:10px;">
                    @foreach($group['links'] ?? [] as $link)
                    <a href="{{ ($link['url'] ?? '#') === '#' ? ($fallbackUrls[$link['label'] ?? ''] ?? '#') : $link['url'] }}" style="font-size:0.8rem; color:#8aaa9e; text-decoration:none;">{{ $link['label'] ?? '' }}</a>
                    @endforeach
                </div>
            </div>
            @endforeach

        </div>

        {{-- Bottom bar --}}
        <div class="home-footer-bottom" style="border-top:1px solid #2d5a4a; padding-top:20px;
                    display:flex; align-items:center; justify-content:space-between;">
            <p style="font-size:0.75rem; color:#8aaa9e; margin:0;">&copy; {{ date('Y') }} {{ $footerData['copyright'] ?? 'Fixly. All rights reserved.' }}</p>
            <div style="display:flex; gap:20px;">
                <a href="{{ route('contact') }}" style="font-size:0.75rem; color:#8aaa9e; text-decoration:none;">Contact</a>
                <a href="{{ route('privacy') }}" style="font-size:0.75rem; color:#8aaa9e; text-decoration:none;">Privacy Policy</a>
                <a href="{{ route('terms') }}" style="font-size:0.75rem; color:#8aaa9e; text-decoration:none;">Terms of Service</a>
                <a href="{{ route('terms') }}" style="font-size:0.75rem; color:#8aaa9e; text-decoration:none;">Legal</a>
            </div>
        </div>

    </div>
</footer>

<style>
@media (max-width: 900px) {
    .home-footer { padding: 32px 24px 24px !important; }
    .home-footer-grid { grid-template-columns: repeat(2, 1fr) !important; gap: 28px !important; }
}
@media (max-width: 600px) {
    .home-footer-grid { grid-template-columns: 1fr !important; gap: 24px !important; }
    .home-footer-bottom { flex-direction: column !important; gap: 12px !important; text-align: center !important; }
}
@media (max-width: 640px) {
    .home-footer { padding-bottom: 80px !important; }
}
@media (max-width: 480px) {
    .home-footer { padding: 24px 16px 80px !important; }
    .home-footer-bottom > div { flex-wrap: wrap !important; justify-content: center !important; gap: 10px !important; }
}
@media (max-width: 360px) {
    .home-footer { padding: 20px 12px 80px !important; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var hash = window.location.hash;
    if (hash) {
        var target = document.querySelector(hash);
        if (target) {
            setTimeout(function() {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 300);
        }
    }
});
</script>
