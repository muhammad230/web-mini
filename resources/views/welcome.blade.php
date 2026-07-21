<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fixly – Get Your Home Jobs Done Fast & Reliably</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS via CDN (no build step required) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
                    },
                    colors: {
                        brand: {
                            dark:   '#1a2e2a',
                            darker: '#243d37',
                            orange: '#e07b39',
                            'orange-dark': '#c96a2a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; overflow-x: hidden; }

        /* ── Responsive: Hero ── */
        @media (max-width: 768px) {
            .hero-section { min-height: 300px !important; }
            .hero-section h1 { font-size: 2rem !important; }
            .hero-text-wrap { padding: 90px 24px 120px !important; }
            .hero-text-wrap p { max-width: 100% !important; }
            .hero-text-wrap p br { display: none; }
            .hero-overlay-img { width: 100% !important; opacity: 0.2; }
        }
        @media (max-width: 480px) {
            .hero-section h1 { font-size: 1.55rem !important; }
            .hero-text-wrap { padding: 90px 16px 100px !important; }
        }

        /* ── Responsive: Search Card ── */
        @media (max-width: 768px) {
            .search-card-wrap { padding: 0 16px !important; }
            .search-card-inner { padding: 20px 16px 18px !important; }
            .search-card-inner .search-row { flex-direction: column !important; gap: 12px !important; }
            .search-card-inner .search-row > div { width: 100% !important; }
            .search-card-inner .search-row button { width: 100% !important; }
        }

        /* ── Responsive: Hero spacer ── */
        @media (max-width: 480px) {
            .hero-search-spacer { height: 100px !important; }
        }
        @media (max-width: 360px) {
            .hero-search-spacer { height: 90px !important; }
        }

        /* ── Responsive: Stats ── */
        @media (max-width: 900px) {
            .home-stats { padding: 28px 24px 32px !important; }
            .home-stats-grid { grid-template-columns: repeat(2, 1fr) !important; }
        }
        @media (max-width: 480px) {
            .home-stats { padding: 24px 16px 28px !important; }
            .home-stats-grid { grid-template-columns: 1fr !important; }
        }

        /* ── Responsive: Browse Trades ── */
        @media (max-width: 900px) {
            .home-trades { padding: 28px 24px 40px !important; }
            .home-trades-grid { grid-template-columns: repeat(2, 1fr) !important; }
        }
        @media (max-width: 480px) {
            .home-trades { padding: 24px 16px 32px !important; }
            .home-trades-grid { grid-template-columns: 1fr !important; }
        }

        /* ── Responsive: How It Works ── */
        @media (max-width: 768px) {
            .home-how-it-works { padding: 28px 24px 40px !important; }
            .home-how-it-works-grid { flex-direction: column !important; gap: 24px !important; }
        }
        @media (max-width: 480px) {
            .home-how-it-works { padding: 24px 16px 32px !important; }
        }

        /* ── Responsive: Featured Pros ── */
        @media (max-width: 900px) {
            .home-pros { padding: 28px 24px 40px !important; }
            .home-pros-grid { grid-template-columns: repeat(2, 1fr) !important; }
        }
        @media (max-width: 600px) {
            .home-pros-grid { grid-template-columns: 1fr !important; }
        }
        @media (max-width: 480px) {
            .home-pros { padding: 24px 16px 32px !important; }
        }

        /* ── Responsive: Testimonials ── */
        @media (max-width: 768px) {
            .home-testimonials { padding: 28px 24px 40px !important; }
            .home-testimonials-grid { grid-template-columns: 1fr !important; }
        }
        @media (max-width: 480px) {
            .home-testimonials { padding: 24px 16px 32px !important; }
        }

        /* ── Responsive: CTA Professional ── */
        @media (max-width: 768px) {
            .home-cta-pro-section { padding: 0 24px 16px !important; }
            .home-cta-pro-inner { flex-direction: column !important; text-align: center !important; padding: 20px 24px !important; }
            .home-cta-pro-inner .cta-pro-flex { flex-direction: column !important; text-align: center !important; }
            .home-cta-pro-btn { width: 100% !important; text-align: center !important; }
        }
        @media (max-width: 480px) {
            .home-cta-pro-section { padding: 0 16px 16px !important; }
        }

        /* ── Responsive: CTA Bottom ── */
        @media (max-width: 768px) {
            .home-cta-bottom-section { padding: 20px 24px !important; }
            .home-cta-bottom-inner { flex-direction: column !important; text-align: center !important; }
            .home-cta-bottom-buttons { flex-direction: column !important; width: 100% !important; }
            .home-cta-bottom-buttons a { width: 100% !important; text-align: center !important; }
        }
        @media (max-width: 480px) {
            .home-cta-bottom-section { padding: 16px 16px !important; }
        }

        /* ── Responsive: Footer ── */
        @media (max-width: 900px) {
            .home-footer { padding: 32px 24px 24px !important; }
            .home-footer-grid { grid-template-columns: repeat(2, 1fr) !important; gap: 28px !important; }
        }
        @media (max-width: 600px) {
            .home-footer-grid { grid-template-columns: 1fr !important; }
            .home-footer-bottom { flex-direction: column !important; gap: 12px !important; text-align: center !important; }
        }
        @media (max-width: 480px) {
            .home-footer { padding: 24px 16px 20px !important; }
        }

        /* ── Responsive: Section headings ── */
        @media (max-width: 768px) {
            .section-heading { font-size: 1.5rem !important; }
        }
        @media (max-width: 480px) {
            .section-heading { font-size: 1.3rem !important; }
        }

        /* ── Buttons: touch-friendly min height ── */
        @media (pointer: coarse) {
            .touch-btn { min-height: 48px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; }
        }

        /* ── Responsive: 320px tiny screens ── */
        @media (max-width: 360px) {
            .hero-section { min-height: 260px !important; }
            .hero-section h1 { font-size: 1.3rem !important; }
            .hero-text-wrap { padding: 80px 12px 90px !important; max-width: 100% !important; }
            .hero-text-wrap p { font-size: 0.78rem !important; }
            .search-card-wrap { padding: 0 8px !important; bottom: -80px !important; }
            .search-card-inner { padding: 14px 10px 14px !important; }
            .search-card-inner .search-row { flex-direction: column !important; gap: 10px !important; }
            .search-card-inner .search-row > div { width: 100% !important; }
            .search-card-inner .search-row button { width: 100% !important; }
            .search-row p { font-size: 0.7rem !important; }
            .home-stats { padding: 20px 12px 24px !important; }
            .home-trades { padding: 20px 12px 28px !important; }
            .home-how-it-works { padding: 20px 12px 28px !important; }
            .home-pros { padding: 20px 12px 28px !important; }
            .home-testimonials { padding: 20px 12px 28px !important; }
            .home-cta-pro-section { padding: 0 8px 12px !important; }
            .home-cta-bottom-section { padding: 12px 12px !important; }
            .section-heading { font-size: 1.1rem !important; }
            .home-footer { padding: 20px 12px 16px !important; }
        }
    </style>
    <link rel="stylesheet" href="/css/dark-mode.css">
</head>
<body style="margin:0; padding:0; font-family:'Inter',sans-serif; background:#fff; color:#1f2937;">

    {{-- ======= HERO + SEARCH (navbar embedded inside) ======= --}}
    @include('components.hero', ['hero' => $hero, 'navData' => $navData, 'trades' => $trades])

    {{-- ======= STATS BAR ======= --}}
    @include('components.stats', ['statsBar' => $statsBar])

    {{-- ======= BROWSE BY TRADE ======= --}}
    @include('components.browse-trades', ['trades' => $trades])

    {{-- ======= HOW IT WORKS ======= --}}
    @include('components.how-it-works', ['howItWorks' => $howItWorks])

    {{-- ======= FEATURED PROFESSIONALS ======= --}}
    @include('components.featured-professionals')

    {{-- ======= TESTIMONIALS ======= --}}
    @include('components.testimonials')

    {{-- ======= CTA – JOIN AS PROFESSIONAL ======= --}}
    @include('components.cta-professional', ['ctaBanner' => $ctaBanner])

    {{-- ======= CTA BOTTOM BANNER ======= --}}
    @include('components.cta-bottom')

    {{-- ======= FOOTER ======= --}}
    @include('components.footer', ['footerData' => $footerData])

    @include('partials.chat-widget')
    <script src="/js/theme-toggle.js"></script>
</body>
</html>
