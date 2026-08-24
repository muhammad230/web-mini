<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Fixly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .tab-active { background-color: #E8823C; color: white; }
        .tab-inactive { background-color: #F5F1EA; color: #16302A; }
        @media (max-width: 480px) {
            .auth-card { padding: 1.25rem !important; }
            .auth-title { font-size: 1.3rem !important; }
            .role-tabs { flex-direction: column !important; gap: 4px !important; }
        }
        @media (max-width: 375px) {
            body { padding-left: 0.75rem !important; padding-right: 0.75rem !important; }
            .auth-card { padding: 1rem !important; }
        }
    </style>
    <link rel="stylesheet" href="/css/dark-mode.css">
</head>
<body class="min-h-screen bg-[#F5F1EA] flex items-center justify-center px-4 py-12">
    <div class="max-w-lg w-full">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mb-6">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                    <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H15v-5h-6v5H4a1 1 0 01-1-1V9.5z" fill="#E8823C"/>
                </svg>
                <span class="text-[#16302A] text-2xl font-bold">Fix<span class="text-[#E8823C]">ly</span></span>
            </a>
            <h1 class="text-[#16302A] text-2xl font-bold mb-2 auth-title">Create Your Account</h1>
            <p class="text-gray-600 text-sm">Join Fixly to get your home jobs done</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 auth-card">
            {{-- Role Toggle Tabs --}}
            <div class="flex mb-8 bg-[#F5F1EA] rounded-xl p-1 role-tabs">
                <button 
                    id="customer-tab" 
                    onclick="switchRole('customer')" 
                    class="flex-1 py-3 px-4 rounded-lg font-semibold text-sm transition-all {{ $tab === 'customer' ? 'tab-active' : 'tab-inactive' }}"
                >
                    Customer
                </button>
                <button 
                    id="professional-tab" 
                    onclick="switchRole('professional')" 
                    class="flex-1 py-3 px-4 rounded-lg font-semibold text-sm transition-all {{ $tab === 'professional' ? 'tab-active' : 'tab-inactive' }}"
                >
                    Professional
                </button>
            </div>

            <form id="register-form" method="POST" action="{{ route('register.submit') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="role-input" name="role" value="{{ $tab }}">

                <div class="mb-5">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none transition-colors"
                        placeholder="John Doe"
                    >
                    @error('name')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none transition-colors"
                        placeholder="you@example.com"
                    >
                    @error('email')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        value="{{ old('phone') }}" 
                        required 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none transition-colors"
                        placeholder="+1 (555) 000-0000"
                    >
                    @error('phone')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Professional Only Fields --}}
                <div id="professional-fields" class="{{ $tab === 'professional' ? '' : 'hidden' }}">
                    <div class="mb-5">
                        <label for="trade" class="block text-sm font-medium text-gray-700 mb-2">Your Trade</label>
                        <select 
                            id="trade" 
                            name="trade" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none transition-colors"
                        >
                            <option value="">Select your trade</option>
                            <option value="Plumbing"         {{ old('trade') === 'Plumbing'         ? 'selected' : '' }}>Plumbing</option>
                            <option value="Electrical"       {{ old('trade') === 'Electrical'       ? 'selected' : '' }}>Electrical</option>
                            <option value="Carpentry"        {{ old('trade') === 'Carpentry'        ? 'selected' : '' }}>Carpentry</option>
                            <option value="Painting"         {{ old('trade') === 'Painting'         ? 'selected' : '' }}>Painting</option>
                            <option value="Handyman"         {{ old('trade') === 'Handyman'         ? 'selected' : '' }}>Handyman</option>
                            <option value="Appliance Repair" {{ old('trade') === 'Appliance Repair' ? 'selected' : '' }}>Appliance Repair</option>
                            <option value="AC Repair"        {{ old('trade') === 'AC Repair'        ? 'selected' : '' }}>AC Repair</option>
                            <option value="Cleaning"         {{ old('trade') === 'Cleaning'         ? 'selected' : '' }}>Cleaning</option>
                        </select>
                        @error('trade')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Your Location</label>
                        <input 
                            type="text" 
                            id="location" 
                            name="location" 
                            value="{{ old('location') }}" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none transition-colors"
                            placeholder="City, State"
                        >
                        @error('location')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="years_experience" class="block text-sm font-medium text-gray-700 mb-2">Years of Experience</label>
                        <input 
                            type="number" 
                            id="years_experience" 
                            name="years_experience" 
                            value="{{ old('years_experience') }}" 
                            required
                            min="0"
                            max="50"
                            inputmode="numeric"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none transition-colors"
                            placeholder="e.g. 5"
                        >
                        @error('years_experience')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="id_document" class="block text-sm font-medium text-gray-700 mb-2">National ID / CNIC Photo (Front)</label>
                        <input 
                            type="file" 
                            id="id_document" 
                            name="id_document" 
                            accept="image/*"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none transition-colors"
                        >
                        <p class="text-gray-500 text-xs mt-1">Required for verification. This is reviewed by our team before your account is approved.</p>
                        @error('id_document')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="selfie_document" class="block text-sm font-medium text-gray-700 mb-2">Selfie Holding ID <span class="text-gray-500">(Optional)</span></label>
                        <input 
                            type="file" 
                            id="selfie_document" 
                            name="selfie_document" 
                            accept="image/*"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none transition-colors"
                        >
                        @error('selfie_document')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="certification_document" class="block text-sm font-medium text-gray-700 mb-2">Trade Certification / License Photo (Optional)</label>
                        <input 
                            type="file" 
                            id="certification_document" 
                            name="certification_document" 
                            accept="image/*"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none transition-colors"
                        >
                        @error('certification_document')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-5">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required 
                            class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none transition-colors"
                            placeholder="••••••••"
                        >
                        <button type="button" data-toggle-password aria-controls="password"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#E8823C] transition-colors"
                                aria-label="Show password" title="Show password">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 icon-eye">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 icon-eye-off hidden">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            required 
                            class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none transition-colors"
                            placeholder="••••••••"
                        >
                        <button type="button" data-toggle-password aria-controls="password_confirmation"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#E8823C] transition-colors"
                                aria-label="Show password" title="Show password">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 icon-eye">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 icon-eye-off hidden">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                </div>
                <button 
                    type="submit" 
                    class="w-full bg-[#E8823C] hover:bg-[#c96a2a] text-white font-semibold py-3 px-6 rounded-xl transition-colors text-base"
                >
                    Create Account
                </button>
            </form>
            <div class="mt-6 text-center">
                <p class="text-gray-600 text-sm">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-[#E8823C] hover:text-[#c96a2a] font-medium">Sign in</a>
                </p>
            </div>
        </div>
    </div>
    <script>
        var professionalFields = document.querySelectorAll('#professional-fields [name]');

        function setProfessionalFields(visible) {
            professionalFields.forEach(function (el) {
                el.disabled = !visible;
            });
        }

        function switchRole(role) {
            document.getElementById('role-input').value = role;
            document.getElementById('customer-tab').className = 
                role === 'customer' ? 'flex-1 py-3 px-4 rounded-lg font-semibold text-sm transition-all tab-active' : 'flex-1 py-3 px-4 rounded-lg font-semibold text-sm transition-all tab-inactive';
            document.getElementById('professional-tab').className = 
                role === 'professional' ? 'flex-1 py-3 px-4 rounded-lg font-semibold text-sm transition-all tab-active' : 'flex-1 py-3 px-4 rounded-lg font-semibold text-sm transition-all tab-inactive';
            document.getElementById('professional-fields').className = 
                role === 'professional' ? '' : 'hidden';
            setProfessionalFields(role === 'professional');
        }

        // Clear client-side validation messages for the required professional fields
        document.addEventListener('DOMContentLoaded', function () {
            setProfessionalFields(document.getElementById('role-input').value === 'professional');

            var messages = {
                trade: 'Please select your trade.',
                location: 'Please enter your service location.',
                years_experience: 'Please enter your years of experience.',
                id_document: 'Please upload your National ID / CNIC photo for verification.',
            };
            Object.keys(messages).forEach(function (name) {
                var el = document.querySelector('[name="' + name + '"]');
                if (!el) return;
                el.addEventListener('invalid', function () {
                    if (this.validity.valueMissing) this.setCustomValidity(messages[name]);
                });
                el.addEventListener('input', function () { this.setCustomValidity(''); });
                el.addEventListener('change', function () { this.setCustomValidity(''); });
            });
        });
    </script>
    <div style="position:fixed;top:16px;right:16px;z-index:9999;display:flex;align-items:center;gap:8px;background:rgba(0,0,0,0.12);padding:4px 8px;border-radius:8px;">
        @include('partials.theme-toggle')
    </div>
    @include('partials.chat-widget')
    <script src="/js/theme-toggle.js"></script>
    <script>
        document.querySelectorAll('[data-toggle-password]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var input = document.getElementById(btn.getAttribute('aria-controls'));
                var show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                btn.querySelector('.icon-eye').classList.toggle('hidden', show);
                btn.querySelector('.icon-eye-off').classList.toggle('hidden', !show);
                btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
                btn.setAttribute('title', btn.getAttribute('aria-label'));
            });
        });
    </script>
</body>
</html>
