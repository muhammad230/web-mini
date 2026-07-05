<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FixIt – Get Your Home Jobs Done Fast & Reliably</title>

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
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body style="margin:0; padding:0; font-family:'Inter',sans-serif; background:#fff; color:#1f2937;">

    {{-- ======= HERO + SEARCH (navbar embedded inside) ======= --}}
    @include('components.hero')

    {{-- ======= STATS BAR ======= --}}
    @include('components.stats')

    {{-- ======= BROWSE BY TRADE ======= --}}
    @include('components.browse-trades')

    {{-- ======= HOW IT WORKS ======= --}}
    @include('components.how-it-works')

    {{-- ======= FEATURED PROFESSIONALS ======= --}}
    @include('components.featured-professionals')

    {{-- ======= TESTIMONIALS ======= --}}
    @include('components.testimonials')

    {{-- ======= CTA – JOIN AS PROFESSIONAL ======= --}}
    @include('components.cta-professional')

    {{-- ======= CTA BOTTOM BANNER ======= --}}
    @include('components.cta-bottom')

    {{-- ======= FOOTER ======= --}}
    @include('components.footer')

</body>
</html>
