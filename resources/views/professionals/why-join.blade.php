<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join as a Professional - FixIt</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#F5F1EA] min-h-screen">

    {{-- Navbar --}}
    @include('components.navbar')

    {{-- Hero Section --}}
    <section class="relative min-h-screen flex items-center justify-center px-6 pt-24 pb-20"
             style="background: linear-gradient(135deg, #16302A 0%, #1e3d35 50%, #16302A 100%);">
        <div class="max-w-4xl mx-auto text-center">
            <span class="inline-block bg-[#E8823C]/20 text-[#E8823C] text-sm font-semibold px-4 py-1.5 rounded-full mb-6">
                Earn More. Work Local. Be Your Own Boss.
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
                Turn Your Skills Into
                <span class="text-[#E8823C]">Income</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-300 max-w-2xl mx-auto mb-10 leading-relaxed">
                Join hundreds of trusted professionals in your area. Get matched with customers who need your expertise — plumbing, electrical, carpentry, and more.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register', ['role' => 'professional']) }}"
                   class="bg-[#E8823C] hover:bg-[#c96a2a] text-white font-bold px-8 py-4 rounded-xl text-lg transition-all shadow-lg shadow-[#E8823C]/25 hover:shadow-[#E8823C]/40">
                    Get Started Free
                </a>
                <a href="#how-it-works"
                   class="text-white/80 hover:text-white font-medium px-6 py-4 transition-colors">
                    Learn how it works &darr;
                </a>
            </div>
        </div>
    </section>

    {{-- How It Works --}}
    <section id="how-it-works" class="py-20 px-6 bg-white">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-[#16302A] mb-4">How It Works</h2>
                <p class="text-gray-500 text-lg max-w-2xl mx-auto">Three simple steps to start earning with FixIt</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center p-8">
                    <div class="w-16 h-16 bg-[#E8823C]/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#E8823C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                            <circle cx="8.5" cy="7" r="4"/>
                            <polyline points="17 11 19 13 23 9"/>
                        </svg>
                    </div>
                    <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-[#16302A] text-white text-sm font-bold mb-4">1</div>
                    <h3 class="text-xl font-bold text-[#16302A] mb-3">Create Your Profile</h3>
                    <p class="text-gray-500 leading-relaxed">Sign up, tell us about your trade, service areas, and experience. Set your availability and preferred job types.</p>
                </div>
                <div class="text-center p-8">
                    <div class="w-16 h-16 bg-[#E8823C]/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#E8823C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                        </svg>
                    </div>
                    <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-[#16302A] text-white text-sm font-bold mb-4">2</div>
                    <h3 class="text-xl font-bold text-[#16302A] mb-3">Get Job Leads</h3>
                    <p class="text-gray-500 leading-relaxed">We match you with nearby job requests. Browse leads, send quotes, and choose the jobs that fit your schedule.</p>
                </div>
                <div class="text-center p-8">
                    <div class="w-16 h-16 bg-[#E8823C]/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#E8823C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 1a3 3 0 00-3 3v8a3 3 0 006 0V4a3 3 0 00-3-3z"/>
                            <path d="M19 10v2a7 7 0 01-14 0v-2"/>
                            <line x1="12" y1="19" x2="12" y2="23"/>
                            <line x1="8" y1="23" x2="16" y2="23"/>
                        </svg>
                    </div>
                    <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-[#16302A] text-white text-sm font-bold mb-4">3</div>
                    <h3 class="text-xl font-bold text-[#16302A] mb-3">Complete & Get Paid</h3>
                    <p class="text-gray-500 leading-relaxed">Finish the job, get paid securely through the platform. Build your reputation with reviews and grow your business.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Benefits --}}
    <section class="py-20 px-6 bg-[#F5F1EA]">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-[#16302A] mb-4">Why Join FixIt?</h2>
                <p class="text-gray-500 text-lg max-w-2xl mx-auto">Built for professionals who want to grow their business</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-[#16302A]/5 rounded-xl flex items-center justify-center mb-4">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#16302A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><path d="M8 12l2 2 4-4"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-[#16302A] mb-2">Verified Leads</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">No spam. Every job lead is from a real customer in your area looking for help.</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-[#E8823C]/10 rounded-xl flex items-center justify-center mb-4">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#E8823C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 1a3 3 0 00-3 3v8a3 3 0 006 0V4a3 3 0 00-3-3z"/>
                            <path d="M19 10v2a7 7 0 01-14 0v-2"/>
                            <line x1="12" y1="19" x2="12" y2="23"/>
                            <line x1="8" y1="23" x2="16" y2="23"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-[#16302A] mb-2">Set Your Rates</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">You decide what to charge. Send custom quotes and negotiate directly with customers.</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-[#16302A]/5 rounded-xl flex items-center justify-center mb-4">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#16302A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-[#16302A] mb-2">Work on Your Terms</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Accept or decline jobs based on your availability. No minimum hours required.</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-[#E8823C]/10 rounded-xl flex items-center justify-center mb-4">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#E8823C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-[#16302A] mb-2">Build Your Reputation</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Get reviewed by customers. Top-rated professionals get featured and more leads.</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-[#16302A]/5 rounded-xl flex items-center justify-center mb-4">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#16302A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-[#16302A] mb-2">Steady Flow of Work</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Hundreds of customers post jobs every month. Keep your calendar full.</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-[#E8823C]/10 rounded-xl flex items-center justify-center mb-4">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#E8823C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-[#16302A] mb-2">Free to Join</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">No upfront fees. Create your profile and start browsing leads at no cost.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Requirements --}}
    <section class="py-20 px-6 bg-white">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-[#16302A] mb-4">What You Need to Get Started</h2>
                <p class="text-gray-500 text-lg">Joining is quick and easy. Here's what we ask from every professional:</p>
            </div>
            <div class="grid sm:grid-cols-2 gap-4 max-w-2xl mx-auto">
                <div class="flex items-start gap-3 p-4 rounded-lg bg-[#F5F1EA]">
                    <svg class="mt-0.5 flex-shrink-0" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#16302A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span class="text-gray-700 text-sm">Valid ID or business license</span>
                </div>
                <div class="flex items-start gap-3 p-4 rounded-lg bg-[#F5F1EA]">
                    <svg class="mt-0.5 flex-shrink-0" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#16302A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span class="text-gray-700 text-sm">Proof of trade qualifications (certificate, license, or experience)</span>
                </div>
                <div class="flex items-start gap-3 p-4 rounded-lg bg-[#F5F1EA]">
                    <svg class="mt-0.5 flex-shrink-0" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#16302A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span class="text-gray-700 text-sm">Phone number and email address</span>
                </div>
                <div class="flex items-start gap-3 p-4 rounded-lg bg-[#F5F1EA]">
                    <svg class="mt-0.5 flex-shrink-0" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#16302A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span class="text-gray-700 text-sm">Service area and trade selection</span>
                </div>
                <div class="flex items-start gap-3 p-4 rounded-lg bg-[#F5F1EA]">
                    <svg class="mt-0.5 flex-shrink-0" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#16302A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span class="text-gray-700 text-sm">Professional profile photo</span>
                </div>
                <div class="flex items-start gap-3 p-4 rounded-lg bg-[#F5F1EA]">
                    <svg class="mt-0.5 flex-shrink-0" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#16302A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span class="text-gray-700 text-sm">Commitment to quality service</span>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-20 px-6" style="background: linear-gradient(135deg, #16302A 0%, #1e3d35 50%, #16302A 100%);">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Ready to Grow Your Business?</h2>
            <p class="text-lg text-gray-300 mb-10 max-w-xl mx-auto">Join FixIt today and start connecting with customers who need your skills.</p>
            <a href="{{ route('register', ['role' => 'professional']) }}"
               class="inline-block bg-[#E8823C] hover:bg-[#c96a2a] text-white font-bold px-10 py-4 rounded-xl text-lg transition-all shadow-lg shadow-[#E8823C]/25 hover:shadow-[#E8823C]/40">
                Create Your Free Account
            </a>
            <p class="mt-6 text-gray-400 text-sm">
                Already have an account?
                <a href="{{ route('login') }}" class="text-[#E8823C] hover:text-[#c96a2a] font-medium">Log in</a>
            </p>
        </div>
    </section>

    {{-- Footer --}}
    @include('components.footer')

</body>
</html>
