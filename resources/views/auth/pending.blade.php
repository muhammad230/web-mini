<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>You're All Set! - FixIt</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-[#F5F1EA] flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full text-center">
        <div class="mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-[#E8823C] rounded-full mb-6 mx-auto">
                <span class="text-4xl">🎉</span>
            </div>
            <h1 class="text-[#16302A] text-3xl font-bold mb-3">You're All Set!</h1>
            <p class="text-gray-600 text-base leading-relaxed">
                Hi {{ $user->name }}, thanks for joining FixIt!
            </p>
            @if($user->isProfessional())
                <p class="text-gray-500 text-sm mt-2">
                    We'll review your profile and notify you when your professional dashboard is ready!
                </p>
            @else
                <p class="text-gray-500 text-sm mt-2">
                    We'll notify you when your customer dashboard is ready!
                </p>
            @endif
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8">
            <div class="mb-6">
                <p class="text-gray-700 text-sm mb-2">Your Account</p>
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#F5F1EA] rounded-xl">
                    <span class="text-gray-600 text-xs font-medium">
                        {{ $user->isProfessional() ? 'Professional' : 'Customer' }}</span>
                </div>
            </div>
            <a href="{{ route('home') }}" 
               class="w-full inline-flex items-center justify-center bg-[#16302A] hover:bg-[#243d37] text-white font-semibold py-3 px-6 rounded-xl transition-colors text-base">
                Back to Home
            </a>
        </div>
    </div>
</body>
</html>
