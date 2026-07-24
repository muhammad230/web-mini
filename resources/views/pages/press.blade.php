<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Press & Media - Fixly</title>
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
            <h1 class="text-4xl md:text-5xl font-extrabold mb-6">Press & <span style="color:#E8823C;">Media</span></h1>
            <p class="text-lg text-gray-300">Resources for journalists and media professionals.</p>
        </div>
    </section>

    <section class="py-20 px-6">
        <div class="max-w-2xl mx-auto text-center">
            <div class="w-20 h-20 rounded-full bg-[#E8823C]/10 flex items-center justify-center mx-auto mb-8">
                <svg width="36" height="36" fill="none" stroke="#E8823C" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            </div>
            <h2 class="text-2xl font-bold mb-4">For Media Inquiries</h2>
            <p class="text-gray-500 mb-8 leading-relaxed">Thank you for your interest in Fixly. For press inquiries, interview requests, or media assets, please reach out to our team.</p>
            <div class="bg-white border border-[#ece8df] rounded-xl p-8 mb-8 text-left">
                <h3 class="font-bold mb-3">Contact Information</h3>
                <p class="text-gray-500 text-sm mb-2"><strong>Email:</strong> <a href="mailto:press@fixly.co" class="text-[#E8823C] hover:underline">press@fixly.co</a></p>
                <p class="text-gray-500 text-sm mb-2"><strong>General Inquiries:</strong> <a href="{{ route('contact') }}" class="text-[#E8823C] hover:underline">Contact Us</a></p>
                <p class="text-gray-500 text-sm">We aim to respond to all media requests within 24 hours.</p>
            </div>
            <a href="{{ route('contact') }}" class="bg-[#E8823C] hover:bg-[#c96a2a] text-white font-semibold px-6 py-3 rounded-lg transition-colors inline-block">Get in Touch</a>
        </div>
    </section>

    @include('components.footer', ['footerData' => []])
    <script src="/js/theme-toggle.js"></script>
</body>
</html>
