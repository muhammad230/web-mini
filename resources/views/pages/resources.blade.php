<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resources for Professionals - Fixly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/dark-mode.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #F5F1EA; color: #1f2937; }
        .resource-card { background: #fff; border: 1px solid #ece8df; border-radius: 14px; padding: 28px; }
        [data-theme="dark"] .resource-card { background: #1e293b !important; border-color: #374151 !important; }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    @include('components.navbar', ['navData' => []])

    <section class="brand-section pt-32 pb-20 px-6 text-center" style="background:#16302A; color:#fff;">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-6">Pro <span style="color:#E8823C;">Resources</span></h1>
            <p class="text-lg text-gray-300">Tips and guidance to help you succeed on Fixly.</p>
        </div>
    </section>

    <section class="py-16 px-6">
        <div class="max-w-4xl mx-auto">
            <div class="grid md:grid-cols-2 gap-6">
                <div class="resource-card">
                    <div class="w-10 h-10 rounded-lg bg-[#E8823C] flex items-center justify-center mb-4">
                        <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                    <h3 class="font-bold mb-2">Getting More Leads</h3>
                    <p class="text-sm text-gray-500">Complete your profile, add photos of your work, and keep your availability up to date. Professionals with full profiles receive up to 3x more leads.</p>
                </div>
                <div class="resource-card">
                    <div class="w-10 h-10 rounded-lg bg-[#E8823C] flex items-center justify-center mb-4">
                        <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="font-bold mb-2">Verification Requirements</h3>
                    <p class="text-sm text-gray-500">To get verified, you'll need a valid business license or trade certification, proof of insurance, and a government-issued ID.</p>
                </div>
                <div class="resource-card">
                    <div class="w-10 h-10 rounded-lg bg-[#E8823C] flex items-center justify-center mb-4">
                        <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-bold mb-2">Writing Winning Quotes</h3>
                    <p class="text-sm text-gray-500">Be specific about what's included, provide realistic timelines, and break down costs clearly. Detailed quotes convert better.</p>
                </div>
                <div class="resource-card">
                    <div class="w-10 h-10 rounded-lg bg-[#E8823C] flex items-center justify-center mb-4">
                        <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    </div>
                    <h3 class="font-bold mb-2">Building Your Reputation</h3>
                    <p class="text-sm text-gray-500">Deliver quality work, communicate clearly, and ask satisfied customers to leave reviews. Higher ratings mean more visibility.</p>
                </div>
            </div>
        </div>
    </section>

    @include('components.footer', ['footerData' => []])
    <script src="/js/theme-toggle.js"></script>
</body>
</html>
