<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Fixly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/dark-mode.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #F5F1EA; color: #1f2937; }
        .brand-section { background: #16302A; color: #fff; }
        .value-card { background: #fff; border: 1px solid #ece8df; border-radius: 14px; padding: 28px; }
        .value-card:hover { border-color: #E8823C; transform: translateY(-2px); transition: all 0.2s ease; }
        [data-theme="dark"] .value-card { background: #1e293b !important; border-color: #374151 !important; }
        [data-theme="dark"] .value-card:hover { border-color: #E8823C !important; }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    @include('components.navbar', ['navData' => []])

    <!-- Hero -->
    <section class="brand-section pt-32 pb-20 px-6 text-center">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-6">About <span style="color:#E8823C;">Fixly</span></h1>
            <p class="text-lg text-gray-300 leading-relaxed">We're on a mission to make finding trusted home professionals simple, fast, and stress-free.</p>
        </div>
    </section>

    <!-- Mission -->
    <section class="py-16 px-6">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl font-bold mb-4">Our Mission</h2>
            <p class="text-gray-600 leading-relaxed mb-8">Fixly connects homeowners with verified, reliable local professionals for every home service need — from repairs and maintenance to renovations and installations. We believe everyone deserves access to quality craftsmanship without the hassle of endless searching and guessing.</p>
            <p class="text-gray-600 leading-relaxed">Our platform makes it easy to post a job, receive competitive quotes from vetted professionals, and manage the entire process from start to finish — all in one place.</p>
        </div>
    </section>

    <!-- Values -->
    <section class="py-16 px-6 bg-white">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl font-bold mb-8">What We Stand For</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="value-card">
                    <div class="w-10 h-10 rounded-lg bg-[#E8823C] flex items-center justify-center mb-4">
                        <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="font-bold mb-2">Trust & Safety</h3>
                    <p class="text-sm text-gray-500">Every professional is verified. Reviews and ratings help you hire with confidence.</p>
                </div>
                <div class="value-card">
                    <div class="w-10 h-10 rounded-lg bg-[#E8823C] flex items-center justify-center mb-4">
                        <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="font-bold mb-2">Speed</h3>
                    <p class="text-sm text-gray-500">Post a job in minutes. Get quotes from available pros almost instantly.</p>
                </div>
                <div class="value-card">
                    <div class="w-10 h-10 rounded-lg bg-[#E8823C] flex items-center justify-center mb-4">
                        <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="font-bold mb-2">Community</h3>
                    <p class="text-sm text-gray-500">We support local professionals and help them grow their businesses.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 px-6 text-center">
        <div class="max-w-2xl mx-auto">
            <h2 class="text-2xl font-bold mb-4">Ready to get started?</h2>
            <p class="text-gray-600 mb-6">Join thousands of homeowners and professionals already using Fixly.</p>
            <div class="flex gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-[#E8823C] hover:bg-[#c96a2a] text-white font-semibold px-6 py-3 rounded-lg transition-colors">Sign up as Customer</a>
                <a href="{{ route('professionals.why-join') }}" class="border-2 border-[#16302A] text-[#16302A] hover:bg-[#16302A] hover:text-white font-semibold px-6 py-3 rounded-lg transition-colors">Join as a Pro</a>
            </div>
        </div>
    </section>

    @include('components.footer', ['footerData' => []])
    <script src="/js/theme-toggle.js"></script>
</body>
</html>
