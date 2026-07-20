<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Fixly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/dark-mode.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.3s ease, padding 0.3s ease; padding: 0 24px; }
        .faq-answer.open { max-height: 300px; padding: 0 24px 20px; }
        .faq-chevron { transition: transform 0.3s ease; }
        .faq-chevron.open { transform: rotate(180deg); }
    </style>
</head>
<body class="bg-[#F5F1EA] min-h-screen">

    @include('components.navbar', ['navData' => $navData ?? []])

    {{-- Hero Section --}}
    <section class="relative flex items-center justify-center px-6 pt-28 pb-16 md:pt-36 md:pb-20"
             style="background: linear-gradient(135deg, #16302A 0%, #1e3d35 50%, #16302A 100%);">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4">Get in Touch</h1>
            <p class="text-gray-300 text-lg md:text-xl max-w-xl mx-auto">Have a question, concern, or just want to say hi? We'd love to hear from you.</p>
        </div>
    </section>

    {{-- Contact Info + Form --}}
    <section class="py-16 md:py-20 px-6">
        <div class="max-w-5xl mx-auto grid md:grid-cols-5 gap-10">

            {{-- Contact Info --}}
            <div class="md:col-span-2">
                <h2 class="text-2xl font-bold text-[#16302A] mb-6">Contact Information</h2>

                <div class="space-y-5">

                    {{-- Email --}}
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-[#E8823C]/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#E8823C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Email</p>
                            <p class="text-gray-500 text-sm">support@fixly.com</p>
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-[#E8823C]/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#E8823C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Phone</p>
                            <p class="text-gray-500 text-sm">+1 (555) 000-0000</p>
                        </div>
                    </div>

                    {{-- Address --}}
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-[#E8823C]/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#E8823C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Address</p>
                            <p class="text-gray-500 text-sm">123 Service Lane, Suite 200<br>San Francisco, CA 94102</p>
                        </div>
                    </div>

                </div>

                {{-- Social --}}
                <div class="mt-8">
                    <p class="font-semibold text-gray-800 mb-3">Follow Us</p>
                    <div class="flex gap-3">
                        @php $social = $footerData['social'] ?? []; @endphp
                        <a href="{{ $social['facebook'] ?? '#' }}" target="_blank" class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center hover:border-[#E8823C] transition-colors group">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#9ca3af" class="group-hover:fill-[#E8823C] transition-colors"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                        </a>
                        <a href="{{ $social['instagram'] ?? '#' }}" target="_blank" class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center hover:border-[#E8823C] transition-colors group">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" class="group-hover:stroke-[#E8823C] transition-colors"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="#9ca3af"/></svg>
                        </a>
                        <a href="{{ $social['twitter'] ?? '#' }}" target="_blank" class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center hover:border-[#E8823C] transition-colors group">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#9ca3af" class="group-hover:fill-[#E8823C] transition-colors"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
                        </a>
                        <a href="{{ $social['youtube'] ?? '#' }}" target="_blank" class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center hover:border-[#E8823C] transition-colors group">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" class="group-hover:stroke-[#E8823C] transition-colors"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="#9ca3af" stroke="none"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="md:col-span-3">
                <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
                    <h2 class="text-xl font-bold text-[#16302A] mb-2">Send Us a Message</h2>
                    <p class="text-gray-500 text-sm mb-6">Fill out the form below and we'll get back to you within 24 hours.</p>

                    @if(session('success'))
                        <div class="bg-green-100 text-green-700 px-5 py-4 rounded-xl mb-6 font-medium text-sm flex items-center gap-3">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.submit') }}" novalidate>
                        @csrf

                        {{-- Name --}}
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                   class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#E8823C] focus:ring-2 focus:ring-[#E8823C]/20 outline-none transition"
                                   placeholder="John Doe" required>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                   class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#E8823C] focus:ring-2 focus:ring-[#E8823C]/20 outline-none transition"
                                   placeholder="john@example.com" required>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Subject --}}
                        <div class="mb-4">
                            <label for="subject" class="block text-sm font-semibold text-gray-700 mb-1.5">Reason for Contact <span class="text-red-500">*</span></label>
                            <select id="subject" name="subject"
                                    class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#E8823C] focus:ring-2 focus:ring-[#E8823C]/20 outline-none transition appearance-none bg-no-repeat"
                                    style="background-image:url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2216%22 height=%2216%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%236b7280%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Cpolyline points=%226 9 12 15 18 9%22/%3E%3C/svg%3E'); background-position:right 12px center; padding-right:40px;" required>
                                <option value="" disabled {{ old('subject') ? '' : 'selected' }}>Select a reason...</option>
                                <option value="General Inquiry" {{ old('subject') === 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                                <option value="Report a Problem" {{ old('subject') === 'Report a Problem' ? 'selected' : '' }}>Report a Problem</option>
                                <option value="Business Partnership" {{ old('subject') === 'Business Partnership' ? 'selected' : '' }}>Business Partnership</option>
                                <option value="Other" {{ old('subject') === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('subject')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Message --}}
                        <div class="mb-6">
                            <label for="message" class="block text-sm font-semibold text-gray-700 mb-1.5">Message <span class="text-red-500">*</span></label>
                            <textarea id="message" name="message" rows="5"
                                      class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#E8823C] focus:ring-2 focus:ring-[#E8823C]/20 outline-none transition resize-y"
                                      placeholder="Tell us how we can help..." required>{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="w-full bg-[#E8823C] hover:bg-[#c96a2a] text-white font-bold py-3.5 px-6 rounded-xl transition-colors text-base">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </section>

    {{-- FAQ Section --}}
    <section class="py-16 md:py-20 px-6 bg-white">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-[#16302A] mb-3">Frequently Asked Questions</h2>
                <p class="text-gray-500 text-lg">Quick answers to common questions about Fixly.</p>
            </div>

            <div class="space-y-3">

                @php
                    $faqs = [
                        ['q' => 'How do I post a job?', 'a' => 'Simply create a free account as a customer, describe the service you need, and we\'ll connect you with qualified professionals in your area. You can review quotes, check ratings, and choose the best pro for the job.'],
                        ['q' => 'How are professionals verified?', 'a' => 'Every professional on Fixly goes through a verification process that includes identity checks, license validation, and review of their experience and references. We maintain high standards to ensure quality service.'],
                        ['q' => 'How does payment work?', 'a' => 'Payments are processed securely through our platform. Customers pay when satisfied with the completed work, and professionals receive their payouts after the job is confirmed. This protects both parties.'],
                        ['q' => 'How do I become a professional on Fixly?', 'a' => 'Sign up as a professional, complete your profile with your trade, experience, and qualifications. Go through our verification process, set your availability, and start receiving job leads from customers in your area.'],
                        ['q' => 'Is my personal information safe?', 'a' => 'Absolutely. We use industry-standard encryption and security practices to protect your personal data. We never share your information with third parties without your consent.'],
                    ];
                @endphp

                @foreach($faqs as $index => $faq)
                <div class="faq-item border border-gray-200 rounded-xl overflow-hidden" data-index="{{ $index }}">
                    <button class="faq-toggle w-full flex items-center justify-between px-6 py-4 text-left bg-transparent hover:bg-gray-50 transition-colors cursor-pointer" type="button">
                        <span class="font-semibold text-gray-800 pr-4">{{ $faq['q'] }}</span>
                        <svg class="faq-chevron w-5 h-5 text-gray-400 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div class="faq-answer">
                        <p class="text-gray-500 text-sm leading-relaxed">{{ $faq['a'] }}</p>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>

    {{-- Footer --}}
    @include('components.footer', ['footerData' => $footerData ?? []])

    <script>
    document.querySelectorAll('.faq-toggle').forEach(btn => {
        btn.addEventListener('click', function () {
            const item = this.closest('.faq-item');
            const answer = item.querySelector('.faq-answer');
            const chevron = item.querySelector('.faq-chevron');
            const isOpen = answer.classList.contains('open');
            document.querySelectorAll('.faq-answer.open').forEach(a => {
                if (a !== answer) {
                    a.classList.remove('open');
                    a.closest('.faq-item').querySelector('.faq-chevron').classList.remove('open');
                }
            });
            answer.classList.toggle('open');
            chevron.classList.toggle('open');
        });
    });
    </script>
    @include('partials.chat-widget')
    <script src="/js/theme-toggle.js"></script>
</body>
</html>
