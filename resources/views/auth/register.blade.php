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
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none transition-colors"
                            placeholder="City, State"
                        >
                        @error('location')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="id_document" class="block text-sm font-medium text-gray-700 mb-2">National ID / CNIC Photo (Front) <span class="text-gray-500">(Optional)</span></label>
                        <input 
                            type="file" 
                            id="id_document" 
                            name="id_document" 
                            accept="image/*"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none transition-colors"
                        >
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
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none transition-colors"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        required 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none transition-colors"
                        placeholder="••••••••"
                    >
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
        function switchRole(role) {
            document.getElementById('role-input').value = role;
            document.getElementById('customer-tab').className = 
                role === 'customer' ? 'flex-1 py-3 px-4 rounded-lg font-semibold text-sm transition-all tab-active' : 'flex-1 py-3 px-4 rounded-lg font-semibold text-sm transition-all tab-inactive';
            document.getElementById('professional-tab').className = 
                role === 'professional' ? 'flex-1 py-3 px-4 rounded-lg font-semibold text-sm transition-all tab-active' : 'flex-1 py-3 px-4 rounded-lg font-semibold text-sm transition-all tab-inactive';
            document.getElementById('professional-fields').className = 
                role === 'professional' ? '' : 'hidden';
        }
    </script>
    <div style="position:fixed;top:16px;right:16px;z-index:9999;display:flex;align-items:center;gap:8px;background:rgba(0,0,0,0.12);padding:4px 8px;border-radius:8px;">
        @include('partials.theme-toggle')
    </div>
    @include('partials.chat-widget')
    <script src="/js/theme-toggle.js"></script>
</body>
</html>
