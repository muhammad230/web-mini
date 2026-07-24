<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Careers - Fixly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/dark-mode.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #F5F1EA; color: #1f2937; }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    @include('components.navbar', ['navData' => []])

    <section class="brand-section pt-32 pb-20 px-6 text-center" style="background:#16302A; color:#fff;">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-6">Careers at <span style="color:#E8823C;">Fixly</span></h1>
            <p class="text-lg text-gray-300">We're building the future of home services.</p>
        </div>
    </section>

    <section class="py-20 px-6">
        <div class="max-w-2xl mx-auto text-center">
            <div class="w-20 h-20 rounded-full bg-[#E8823C]/10 flex items-center justify-center mx-auto mb-8">
                <svg width="36" height="36" fill="none" stroke="#E8823C" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <h2 class="text-2xl font-bold mb-4">We're not hiring right now</h2>
            <p class="text-gray-500 mb-8 leading-relaxed">We're a small, focused team building something big. While we don't have open positions at the moment, we're always interested in hearing from talented people who are passionate about simplifying home services.</p>
            <p class="text-gray-500 mb-8">Check back soon — or reach out to us at <a href="mailto:careers@fixly.co" class="text-[#E8823C] font-semibold hover:underline">careers@fixly.co</a> to introduce yourself.</p>
            <a href="{{ route('contact') }}" class="bg-[#E8823C] hover:bg-[#c96a2a] text-white font-semibold px-6 py-3 rounded-lg transition-colors inline-block">Contact Us</a>
        </div>
    </section>

    @include('components.footer', ['footerData' => []])
    <script src="/js/theme-toggle.js"></script>
</body>
</html>
