<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Fixly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @media (max-width: 480px) {
            .auth-card { padding: 1.25rem !important; }
            .auth-title { font-size: 1.3rem !important; }
        }
        @media (max-width: 375px) {
            body { padding-left: 0.75rem !important; padding-right: 0.75rem !important; }
            .auth-card { padding: 1rem !important; }
        }
    </style>
    <link rel="stylesheet" href="/css/dark-mode.css">
</head>
<body class="min-h-screen bg-[#16302A] flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mb-6">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                    <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H15v-5h-6v5H4a1 1 0 01-1-1V9.5z" fill="#E8823C"/>
                </svg>
                <span class="text-white text-2xl font-bold">Fix<span class="text-[#E8823C]">ly</span></span>
            </a>
            <h1 class="text-white text-2xl font-bold mb-2 auth-title">Admin Login</h1>
            <p class="text-gray-300 text-sm">Access the Fixly admin dashboard</p>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-8 auth-card">
            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none transition-colors"
                        placeholder="admin@fixly.com"
                    >
                    @error('email')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
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

                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-[#E8823C] focus:ring-[#E8823C] border-gray-300 rounded">
                        <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="text-sm text-[#E8823C] hover:text-[#c96a2a] font-medium">Forgot password?</a>
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-[#E8823C] hover:bg-[#c96a2a] text-white font-semibold py-3 px-6 rounded-xl transition-colors text-base"
                >
                    Log In
                </button>
            </form>
        </div>

        <p class="text-center mt-6 text-gray-400 text-sm">
            Not an admin? <a href="{{ route('login') }}" class="text-[#E8823C] hover:text-[#c96a2a] font-medium">Go to user login</a>
        </p>
    </div>
    <div style="position:fixed;top:16px;right:16px;z-index:9999;display:flex;align-items:center;gap:8px;background:rgba(255,255,255,0.1);padding:4px 8px;border-radius:8px;">
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
