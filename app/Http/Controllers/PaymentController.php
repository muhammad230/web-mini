<?php

namespace App\Http\Controllers;

use App\Models\CustomerJob;
use App\Models\Payment;
use App\Models\PayoutRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    const PLATFORM_FEE_PERCENT = 10;

    // ── Customer: show payment form for a completed job ──
    public function customerPayForm(CustomerJob $job)
    {
        if ($job->customer_id !== Auth::id()) {
            abort(403);
        }
        if ($job->status !== 'completed') {
            return back()->with('error', 'This job is not yet completed.');
        }

        $quote = $job->quotes()->where('status', 'accepted')->first();
        if (!$quote) {
            return back()->with('error', 'No accepted quote found for this job.');
        }

        $existing = Payment::where('job_id', $job->id)->first();
        if ($existing && $existing->status === 'paid') {
            return back()->with('info', 'This job has already been paid.');
        }

        $amount          = (float) $quote->amount;
        $platformFee     = round($amount * self::PLATFORM_FEE_PERCENT / 100, 2);
        $payoutAmount    = $amount - $platformFee;

        return view('payments.customer-pay', compact('job', 'quote', 'amount', 'platformFee', 'payoutAmount', 'existing'));
    }

    // ── Customer: submit payment record ──
    public function customerPaySubmit(Request $request, CustomerJob $job)
    {
        if ($job->customer_id !== Auth::id()) {
            abort(403);
        }
        if ($job->status !== 'completed') {
            return back()->with('error', 'This job is not yet completed.');
        }

        $quote = $job->quotes()->where('status', 'accepted')->first();
        if (!$quote) {
            return back()->with('error', 'No accepted quote found.');
        }

        $existing = Payment::where('job_id', $job->id)->where('status', 'paid')->first();
        if ($existing) {
            return back()->with('info', 'Already paid.');
        }

        $request->validate([
            'payment_method' => 'required|in:cash,bank_transfer,jazzcash,easypaisa,other',
        ]);

        $amount       = (float) $quote->amount;
        $platformFee  = round($amount * self::PLATFORM_FEE_PERCENT / 100, 2);
        $payoutAmount = $amount - $platformFee;

        Payment::updateOrCreate(
            ['job_id' => $job->id],
            [
                'customer_id'              => $job->customer_id,
                'professional_id'          => $job->assigned_pro_id,
                'amount'                   => $amount,
                'platform_fee'             => $platformFee,
                'professional_payout_amount'=> $payoutAmount,
                'payment_method'           => $request->payment_method,
                'status'                   => 'pending',
                'transaction_reference'    => $request->transaction_reference,
            ]
        );

        return redirect()->route('dashboard.customer')->with('success', 'Payment recorded! Admin will confirm once received.');
    }

    // ── Professional: earnings data (used by the dashboard) ──
    public static function professionalEarnings(User $pro): array
    {
        $paidPayments = Payment::where('professional_id', $pro->id)
            ->where('status', 'paid')
            ->get();

        $totalEarned        = $paidPayments->sum('amount');
        $totalPlatformFee   = $paidPayments->sum('platform_fee');
        $netPayoutAmount    = $paidPayments->sum('professional_payout_amount');

        $thisMonth = $paidPayments->filter(function ($p) {
            return $p->paid_at && $p->paid_at->isCurrentMonth();
        })->sum('professional_payout_amount');

        $paidOut = PayoutRequest::where('professional_id', $pro->id)
            ->where('status', 'paid')
            ->sum('amount');

        $pendingPayout = $netPayoutAmount - $paidOut;

        $payoutRequests = PayoutRequest::where('professional_id', $pro->id)
            ->orderByDesc('created_at')
            ->get();

        $recentPayments = Payment::where('professional_id', $pro->id)
            ->where('status', 'paid')
            ->with('job')
            ->orderByDesc('paid_at')
            ->limit(10)
            ->get()
            ->map(function ($p) {
                return (object) [
                    'date'           => $p->paid_at ? $p->paid_at->format('M j, Y') : '—',
                    'trade_category' => $p->job->trade_category ?? '—',
                    'customer_name'  => $p->customer->name ?? '—',
                    'amount'         => $p->amount,
                    'fee'            => $p->platform_fee,
                    'payout'         => $p->professional_payout_amount,
                    'status'         => 'Paid',
                ];
            });

        return [
            'total_earned'     => $totalEarned,
            'platform_fee'     => $totalPlatformFee,
            'net_payout'       => $netPayoutAmount,
            'this_month'       => $thisMonth,
            'pending_payout'   => max(0, $pendingPayout),
            'paid_out'         => $paidOut,
            'payout_history'   => $recentPayments,
            'payout_requests'  => $payoutRequests,
        ];
    }

    // ── Professional: request payout ──
    public function requestPayout(Request $request)
    {
        $pro = Auth::user();
        $earnings = self::professionalEarnings($pro);

        $available = $earnings['pending_payout'];
        if ($available <= 0) {
            return back()->with('error', 'No payout balance available.');
        }

        PayoutRequest::create([
            'professional_id' => $pro->id,
            'amount'          => $available,
            'status'          => 'pending',
        ]);

        return back()->with('success', 'Payout request submitted! Admin will process it manually.');
    }

    // ── Admin: view payments dashboard ──
    public function adminPayments()
    {
        $payments = Payment::with('job', 'customer', 'professional')
            ->orderByDesc('created_at')
            ->paginate(20);

        $payoutRequests = PayoutRequest::with('professional')
            ->orderByDesc('created_at')
            ->get();

        $stats = [
            'total_revenue'    => Payment::where('status', 'paid')->sum('platform_fee'),
            'total_processed'  => Payment::where('status', 'paid')->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'pending_payouts'  => PayoutRequest::where('status', 'pending')->count(),
        ];

        return view('dashboard.admin.payments', compact('payments', 'payoutRequests', 'stats'));
    }

    // ── Admin: mark payment as paid ──
    public function adminMarkPaid(Request $request, Payment $payment)
    {
        if ($payment->status === 'paid') {
            return back()->with('info', 'Already marked as paid.');
        }

        $request->validate([
            'transaction_reference' => 'nullable|string|max:255',
        ]);

        $payment->update([
            'status'               => 'paid',
            'payment_method'       => $request->payment_method ?? $payment->payment_method,
            'transaction_reference'=> $request->transaction_reference ?? $payment->transaction_reference,
            'paid_at'              => now(),
        ]);

        return back()->with('success', 'Payment marked as paid.');
    }

    // ── Admin: process payout request ──
    public function adminProcessPayout(Request $request, PayoutRequest $payoutRequest)
    {
        $request->validate([
            'action' => 'required|in:approve,pay,reject',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $status = match ($request->action) {
            'approve' => 'approved',
            'pay'     => 'paid',
            'reject'  => 'rejected',
        };

        $payoutRequest->update([
            'status'       => $status,
            'admin_notes'  => $request->admin_notes,
            'processed_at' => in_array($status, ['paid', 'rejected']) ? now() : ($status === 'approved' ? null : $payoutRequest->processed_at),
            'processed_by' => Auth::id(),
        ]);

        if ($status === 'paid') {
            $payoutRequest->update(['processed_at' => now()]);
        }

        $msg = $status === 'paid' ? 'Payout marked as paid.' : ($status === 'approved' ? 'Payout approved.' : 'Payout rejected.');
        return back()->with('success', $msg);
    }

    // ── Platform fee helper ──
    public static function calculateFee(float $amount): array
    {
        $fee   = round($amount * self::PLATFORM_FEE_PERCENT / 100, 2);
        $payout = $amount - $fee;
        return ['fee' => $fee, 'payout' => $payout];
    }
}
