<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pay for Job — FixIt</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #F5F1EA; color: #1f2937; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; }
        .card { background: #fff; border-radius: 20px; padding: 40px; max-width: 520px; width: 100%; box-shadow: 0 4px 24px rgba(0,0,0,0.06); border: 1px solid #ece8df; }
        .fee-breakdown { background: #F5F1EA; border-radius: 12px; padding: 16px; margin: 20px 0; }
        .fee-row { display: flex; justify-content: space-between; align-items: center; padding: 6px 0; font-size: 0.9rem; }
        .fee-row.total { border-top: 1px solid #d6cfc3; margin-top: 6px; padding-top: 10px; font-weight: 700; font-size: 1rem; }
        label { font-size: 0.85rem; font-weight: 600; color: #374151; display: block; margin-bottom: 4px; }
        select { width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 10px; font-size: 0.9rem; outline: none; }
        select:focus { border-color: #E8823C; ring: 2px solid rgba(232,130,60,0.2); }
        .btn-primary { background: #16302A; color: #fff; font-weight: 700; padding: 12px; border-radius: 12px; border: none; width: 100%; font-size: 1rem; cursor: pointer; }
        .btn-primary:hover { background: #1e4238; }
        .btn-primary:disabled { background: #9ca3af; cursor: not-allowed; }
        .info-banner { background: #fef3c7; border-radius: 10px; padding: 10px 14px; font-size: 0.8rem; color: #92400e; margin-bottom: 16px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="flex items-center gap-3 mb-6">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z" fill="#E8823C"/>
            </svg>
            <span class="text-lg font-extrabold text-[#16302A]">Fix<span class="text-[#E8823C]">It</span></span>
        </div>

        <h1 class="text-2xl font-extrabold text-[#16302A] mb-2">Pay for Job</h1>
        <p class="text-sm text-gray-500 mb-6">{{ $job->trade_category }} &middot; {{ $job->location }}</p>

        @if(session('success'))
            <div class="info-banner" style="background: #d1fae5; color: #065f46;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error') || $errors->any())
            <div class="info-banner" style="background: #fee2e2; color: #991b1b;">
                {{ session('error') ?? $errors->first() }}
            </div>
        @endif

        @if(isset($existing) && $existing && $existing->status === 'paid')
            <div class="info-banner" style="background: #d1fae5; color: #065f46;">
                This job has been paid.
            </div>
        @elseif(isset($existing) && $existing && $existing->status === 'pending')
            <div class="info-banner">
                A payment of <strong>Rs. {{ number_format($existing->amount) }}</strong> is pending confirmation.
                Payment method: <strong>{{ ucwords(str_replace('_', ' ', $existing->payment_method)) }}</strong>.
                @if($existing->transaction_reference)
                    <br>Ref: {{ $existing->transaction_reference }}
                @endif
            </div>
        @else
            <div class="fee-breakdown">
                <div class="fee-row">
                    <span class="text-gray-600">Job Amount (from accepted quote)</span>
                    <span class="font-semibold">Rs. {{ number_format($amount) }}</span>
                </div>
                <div class="fee-row">
                    <span class="text-gray-600">Platform Fee ({{ \App\Http\Controllers\PaymentController::PLATFORM_FEE_PERCENT }}%)</span>
                    <span class="text-gray-500">- Rs. {{ number_format($platformFee) }}</span>
                </div>
                <div class="fee-row total">
                    <span>Professional Receives</span>
                    <span>Rs. {{ number_format($payoutAmount) }}</span>
                </div>
            </div>

            <form method="POST" action="{{ route('dashboard.customer.jobs.pay.submit', $job->id) }}">
                @csrf
                <div class="mb-4">
                    <label for="payment_method">Payment Method</label>
                    <select name="payment_method" id="payment_method" required>
                        <option value="">Select a method</option>
                        <option value="cash">Cash</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="jazzcash">JazzCash</option>
                        <option value="easypaisa">EasyPaisa</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <p class="text-xs text-gray-400 mb-4">
                    Manual tracking — no live payment gateway connected. Select how you paid the professional outside the app. Admin will confirm receipt.
                </p>
                <button type="submit" id="payNowBtn" class="btn-primary" onclick="this.disabled=true;this.textContent='Processing...';">Confirm Payment — Rs. {{ number_format($amount) }}</button>
            </form>
        @endif

        <a href="{{ route('dashboard.customer') }}" class="block text-center text-sm text-[#E8823C] font-semibold mt-4 hover:underline">&larr; Back to Dashboard</a>
    </div>
</body>
</html>
