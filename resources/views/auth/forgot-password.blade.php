<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Fixly</title>
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
        [data-theme="dark"] .bg-green-50 { background-color: #0f2e1a !important; border-color: #166534 !important; color: #86efac !important; }
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
            <h1 class="text-[#16302A] text-2xl font-bold mb-2 auth-title">Forgot Password</h1>
            <p class="text-gray-600 text-sm">Enter your email and we'll send you a reset link</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 auth-card">
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 rounded-xl px-4 py-3 mb-6 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none transition-colors"
                        placeholder="you@example.com"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full bg-[#E8823C] hover:bg-[#c96a2a] text-white font-semibold py-3 px-6 rounded-xl transition-colors text-base"
                >
                    Send Reset Link
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