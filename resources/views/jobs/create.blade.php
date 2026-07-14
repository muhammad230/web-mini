<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a New Job - Fixly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #F5F1EA; color: #1f2937; }
        .heading-underline { position: relative; display: inline-block; }
        .heading-underline::after { content: ''; position: absolute; bottom: -6px; left: 0; width: 40px; height: 3px; background: #E8823C; border-radius: 2px; }
    </style>
</head>
<body class="min-h-screen">
    {{-- Top Bar --}}
    <header class="bg-[#16302A] px-6 py-4 flex items-center justify-between sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard.customer') }}" class="flex items-center gap-2">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                <span class="text-white font-bold text-lg">Back to Dashboard</span>
            </a>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="max-w-2xl mx-auto px-6 py-10">
        <h1 class="text-3xl font-extrabold text-[#16302A] mb-8 heading-underline">Post a New Job</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc pl-5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('dashboard.customer.jobs.store') }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Trade Category</label>
                <select name="trade_category" required class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none">
                    <option value="">Select a trade</option>
                    @foreach($trades as $t)
                        <option value="{{ $t['name'] }}" {{ $trade === $t['name'] ? 'selected' : '' }}>{{ $t['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="4" required placeholder="Describe the job you need done..." class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                <input type="text" name="location" value="{{ $location }}" required placeholder="Enter your city or zip code" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Budget Type</label>
                <select name="budget_type" id="budget_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none">
                    <option value="fixed">Fixed Price</option>
                    <option value="flexible">Flexible / Negotiable</option>
                </select>
            </div>

            <div id="budget-fields" class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Min Budget ($)</label>
                    <input type="number" name="budget_min" min="0" step="0.01" placeholder="0" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Max Budget ($)</label>
                    <input type="number" name="budget_max" min="0" step="0.01" placeholder="0" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Schedule</label>
                <input type="text" name="schedule" required placeholder="e.g. This weekend, Next week, Flexible" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#E8823C] focus:border-[#E8823C] outline-none">
            </div>

            <button type="submit" class="w-full bg-[#E8823C] hover:bg-[#c96a2a] text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                Post Job
            </button>
        </form>
    </main>

    <script>
        document.getElementById('budget_type').addEventListener('change', function() {
            document.getElementById('budget-fields').style.display = this.value === 'flexible' ? 'none' : 'grid';
        });
    </script>
</body>
</html>
