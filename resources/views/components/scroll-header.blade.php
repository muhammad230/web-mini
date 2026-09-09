<header id="scroll-header" class="scroll-header" aria-label="On-scroll navigation">
    <div class="scroll-header-inner">

        <a href="{{ route('home') }}" class="scroll-header-logo">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H15v-5h-6v5H4a1 1 0 01-1-1V9.5z" fill="#E8823C"/>
            </svg>
            <span>Fix<span style="color:#E8823C;">ly</span></span>
        </a>

        <nav class="scroll-header-nav">
            <a href="#how-it-works" class="scroll-header-link" data-scroll-section=".home-how-it-works">How it works</a>
            <a href="#browse" class="scroll-header-link" data-scroll-section=".home-trades">Browse services</a>
            <a href="#professionals" class="scroll-header-link" data-scroll-section=".home-pros">Professionals</a>
            <a href="#testimonials" class="scroll-header-link" data-scroll-section=".home-testimonials">Testimonials</a>
            <a href="{{ route('contact') }}" class="scroll-header-link">Contact</a>
        </nav>

        <a href="{{ route('job.post') }}" class="scroll-header-cta">Post a job</a>

    </div>
</header>

<style>
html { scroll-padding-top: 76px; }

#scroll-header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 60;
    background: rgba(255,255,255,0.94);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    box-shadow: 0 2px 16px rgba(0,0,0,0.08);
    transform: translateY(-100%);
    transition: transform 0.35s cubic-bezier(0.22, 1, 0.36, 1);
    visibility: hidden;
}
#scroll-header.scroll-header-visible {
    transform: translateY(0);
    visibility: visible;
}

.scroll-header-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
    min-height: 60px;
    display: flex;
    align-items: center;
    gap: 24px;
}

.scroll-header-logo {
    display: flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    flex-shrink: 0;
    font-size: 1.1rem;
    font-weight: 700;
    color: #1f2937;
    line-height: 1;
}

.scroll-header-nav {
    display: flex;
    align-items: center;
    gap: 22px;
    flex: 1;
    justify-content: center;
    overflow-x: auto;
    scrollbar-width: none;
    -ms-overflow-style: none;
}
.scroll-header-nav::-webkit-scrollbar { display: none; }

.scroll-header-link {
    font-size: 0.95rem;
    font-weight: 500;
    color: #374151;
    text-decoration: none;
    padding: 6px 2px;
    border-bottom: 2px solid transparent;
    transition: color 0.2s ease, border-color 0.2s ease;
    white-space: nowrap;
    flex-shrink: 0;
}
.scroll-header-link:hover { color: #E8823C; }
.scroll-header-link.is-active {
    color: #E8823C;
    border-bottom-color: #E8823C;
}

.scroll-header-cta {
    flex-shrink: 0;
    background: #e07b39;
    color: #fff;
    font-weight: 600;
    font-size: 0.875rem;
    padding: 9px 18px;
    border-radius: 10px;
    text-decoration: none;
    transition: background 0.2s ease;
    white-space: nowrap;
}
.scroll-header-cta:hover { background: #c96a2a; }

@media (max-width: 768px) {
    .scroll-header-inner { gap: 14px; padding: 0 14px; }
    .scroll-header-nav { justify-content: flex-start; gap: 16px; }
    .scroll-header-cta { display: none; }
}
@media (max-width: 480px) {
    .scroll-header-logo span { display: none; }
}

[data-theme="dark"] #scroll-header {
    background: rgba(24, 33, 34, 0.94);
    box-shadow: 0 2px 16px rgba(0, 0, 0, 0.5);
}
[data-theme="dark"] .scroll-header-logo { color: #f3f4f6 !important; }
[data-theme="dark"] .scroll-header-logo span span { color: #E8823C !important; }
[data-theme="dark"] .scroll-header-link { color: #d1d5db !important; }
[data-theme="dark"] .scroll-header-link:hover,
[data-theme="dark"] .scroll-header-link.is-active { color: #E8823C !important; border-bottom-color: #E8823C !important; }
</style>

<script>
(function () {
    var header = document.getElementById('scroll-header');
    if (!header) return;

    var linkNodes = Array.prototype.slice.call(header.querySelectorAll('a[data-scroll-section]'));
    var heroSec = document.querySelector('.hero-section');
    var sections = [];
    var selectors = [];
    var activeBySelector = {};

    linkNodes.forEach(function (link) {
        var sel = link.getAttribute('data-scroll-section');
        var el = document.querySelector(sel);
        if (el) {
            sections.push(el);
            selectors.push(sel);
            activeBySelector[sel] = link;
        }
    });

    linkNodes.forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            var el = document.querySelector(link.getAttribute('data-scroll-section'));
            if (!el) return;
            var top = el.getBoundingClientRect().top + window.scrollY - header.offsetHeight;
            window.scrollTo({ top: top, behavior: 'smooth' });
        });
    });

    var visible = false;

    function update() {
        var rect = heroSec ? heroSec.getBoundingClientRect() : null;
        var show = rect ? (rect.bottom <= header.offsetHeight) : (window.scrollY > 120);
        if (show !== visible) {
            visible = show;
            header.classList.toggle('scroll-header-visible', show);
        }

        var searchTop = header.offsetHeight + 88;
        var activeIndex = -1;
        for (var i = 0; i < sections.length; i++) {
            if (sections[i].getBoundingClientRect().top <= searchTop) activeIndex = i;
        }

        linkNodes.forEach(function (l) { l.classList.remove('is-active'); });
        if (activeIndex >= 0) {
            var activeLink = activeBySelector[selectors[activeIndex]];
            if (activeLink) activeLink.classList.add('is-active');
        }
    }

    var ticking = false;
    function requestUpdate() {
        if (ticking) return;
        ticking = true;
        requestAnimationFrame(function () {
            update();
            ticking = false;
        });
    }

    window.addEventListener('scroll', requestUpdate, { passive: true });
    window.addEventListener('resize', requestUpdate);
    window.addEventListener('load', update);
    update();
})();
</script>