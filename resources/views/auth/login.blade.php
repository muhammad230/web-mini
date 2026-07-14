<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Fixly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
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
            <h1 class="text-[#16302A] text-2xl font-bold mb-2">Welcome Back</h1>
            <p class="text-gray-600 text-sm">Sign in to your Fixly account</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8">
            <form method="POST" action="{{ route('login.submit') }}">
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
                        placeholder="you@example.com"
                    >
                    @error('email')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
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

                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-[#E8823C] focus:ring-[#E8823C] border-gray-300 rounded">
                        <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
                    </div>
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-[#E8823C] hover:bg-[#c96a2a] text-white font-semibold py-3 px-6 rounded-xl transition-colors text-base"
                >
                    Sign In
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-600 text-sm">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-[#E8823C] hover:text-[#c96a2a] font-medium">Sign up</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
