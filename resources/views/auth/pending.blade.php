<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Received – Fixly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="min-h-screen bg-[#F5F1EA] flex items-center justify-center px-4 py-12">

    <div class="max-w-md w-full">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                    <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H15v-5h-6v5H4a1 1 0 01-1-1V9.5z" fill="#E8823C"/>
                </svg>
                <span class="text-[#16302A] text-2xl font-bold">Fix<span class="text-[#E8823C]">ly</span></span>
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

            {{-- Top green banner --}}
            <div class="bg-[#16302A] px-8 py-7 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-[#E8823C] rounded-full mb-4">
                    <svg width="32" height="32" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h1 class="text-white text-2xl font-extrabold mb-1">Application Received!</h1>
                <p class="text-[#a3bfb5] text-sm">We've got your details, {{ explode(' ', $user->name)[0] }}</p>
            </div>

            {{-- Account details --}}
            <div class="px-8 py-6">

                {{-- Who is logged in — very explicit --}}
                <div class="bg-[#F5F1EA] rounded-xl p-4 mb-5">
                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide mb-2">Signed up as</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#E8823C] flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-[#16302A] text-sm">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                        </div>
                        <span class="ml-auto text-xs font-semibold px-2 py-1 rounded-full bg-amber-100 text-amber-700">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                    @if($user->trade)
                        <div class="mt-2 pt-2 border-t border-gray-200 flex items-center gap-2">
                            <span class="text-xs text-gray-500">Trade:</span>
                            <span class="text-xs font-semibold text-[#16302A]">{{ $user->trade }}</span>
                        </div>
                    @endif
                </div>

                @if($user->isProfessional())
                    {{-- What happens next --}}
                    <div class="mb-6 space-y-3">
                        <p class="text-sm font-semibold text-[#16302A] mb-3">What happens next:</p>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-[#E8823C] flex items-center justify-center text-white text-xs font-bold flex-shrink-0 mt-0.5">1</div>
                            <p class="text-sm text-gray-600">Our team reviews your application (usually within 24 hours)</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-[#16302A] flex items-center justify-center text-white text-xs font-bold flex-shrink-0 mt-0.5">2</div>
                            <p class="text-sm text-gray-600">You receive approval and your dashboard unlocks</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-[#16302A] flex items-center justify-center text-white text-xs font-bold flex-shrink-0 mt-0.5">3</div>
                            <p class="text-sm text-gray-600">Log back in and start receiving job leads matching your trade</p>
                        </div>
                    </div>
                @endif

                {{-- Buttons --}}
                <div class="space-y-3">
                    {{-- Log out and go to login (most important action) --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full bg-[#E8823C] hover:bg-[#c96a2a] text-white font-semibold py-3 px-6 rounded-xl transition-colors text-sm">
                            Done — Log Out
                        </button>
                    </form>
                    <a href="{{ route('home') }}"
                       class="w-full inline-flex items-center justify-center border border-gray-300 text-gray-600 hover:bg-gray-50 font-medium py-3 px-6 rounded-xl transition-colors text-sm">
                        Back to Homepage
                    </a>
                </div>

                <p class="text-center text-xs text-gray-400 mt-4">
                    Already approved? 
                    <a href="{{ route('login') }}" class="text-[#E8823C] font-medium hover:underline">Log in here</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>
