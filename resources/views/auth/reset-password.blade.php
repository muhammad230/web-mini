<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Fixly</title>
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
        [data-theme="dark"] .bg-red-50 { background-color: #2e0f0f !important; border-color: #991b1b !important; color: #fca5a5 !important; }
    </style>
    <link rel="stylesheet" href="/css/dark-mode.css">
</head>
<body class="min-h-screen bg-[#F5F1EA] flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mb-6">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                    <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H15v-5h-6v5H4a1 1 0 01-1-1V9.5z" fill="#E8823C"/>
                </svg>
                <span class="text-[#16302A] text-2xl font-bold">Fix<span class="text-[#E8823C]">ly</span></span>
            </a>
            <h1 class="text-[#16302A] text-2xl font-bold mb-2 auth-title">Reset Password</h1>
            <p class="text-gray-600 text-sm">Choose a new password for your account</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 auth-card">
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 rounded-xl px-4 py-3 mb-6 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ $email ?? old('email') }}"
                        required
                        readonly
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 text-gray-500 outline-none"
                    >
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        autofocus
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none transition-colors"
                        placeholder="Min. 8 characters"
                    >
                </div>

                <div class="mb-6">
                    <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                    <input
                        type="password"
                        id="password-confirm"
                        name="password_confirmation"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none transition-colors"
                        placeholder="Re-enter new password"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full bg-[#E8823C] hover:bg-[#c96a2a] text-white font-semibold py-3 px-6 rounded-xl transition-colors text-base"
                >
                    Reset Password
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm text-[#E8823C] hover:text-[#c96a2a] font-medium">Back to Login</a>
            </div>
        </div>
    </div>
    <div style="position:fixed;top:16px;right:16px;z-index:9999;display:flex;align-items:center;gap:8px;background:rgba(0,0,0,0.12);padding:4px 8px;border-radius:8px;">
        @include('partials.theme-toggle')
    </div>
    @include('partials.chat-widget')
    <script src="/js/theme-toggle.js"></script>
</body>
</html>