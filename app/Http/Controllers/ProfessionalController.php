<?php

namespace App\Http\Controllers;

use App\Models\CustomerJob;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfessionalController extends Controller
{
    // ── Get the logged-in pro's trade list ─────────────────────────
    private function getProTrades(User $pro): array
    {
        $trades = [];
        if (!empty($pro->trades)) {
            $decoded = is_array($pro->trades) ? $pro->trades : json_decode($pro->trades, true);
            if (is_array($decoded)) $trades = $decoded;
        }
        if (!empty($pro->trade) && !in_array($pro->trade, $trades)) {
            $trades[] = $pro->trade;
        }
        return array_filter($trades);
    }

    // ── Main dashboard ─────────────────────────────────────────────
    public function index(\Illuminate\Http\Request $request)
    {
        $tab    = $request->get('tab', 'dashboard');
        $pro    = Auth::user();
        $trades = $this->getProTrades($pro);

        // ── New Leads ────────────────────────────────────────────
        $quotedJobIds = DB::table('quotes')
            ->where('pro_id', $pro->id)
            ->pluck('job_id')
            ->toArray();

        $skippedJobIds = DB::table('skipped_leads')
            ->where('pro_id', $pro->id)
            ->pluck('job_id')
            ->toArray();

        $excludedIds = array_merge($quotedJobIds, $skippedJobIds);

        // Only query leads if this pro has at least one trade
        $newLeads = collect();
        if (!empty($trades)) {
            $leadsQuery = DB::table('customer_jobs')
                ->where('status', 'pending_match')
                ->whereIn('trade_category', $trades);

            $serviceArea = $pro->service_area ?? null;
            $location    = $pro->location    ?? null;

            if ($serviceArea) {
                $leadsQuery->where(function($q) use ($serviceArea, $location) {
                    $q->where('location', 'like', '%' . $serviceArea . '%');
                    if ($location) $q->orWhere('location', 'like', '%' . $location . '%');
                });
            } elseif ($location) {
                $leadsQuery->where('location', 'like', '%' . $location . '%');
            }

            if (!empty($excludedIds)) {
                $leadsQuery->whereNotIn('id', $excludedIds);
            }

            $newLeads = $leadsQuery
                ->orderByDesc('created_at')
                ->limit(20)
                ->get()
                ->map(function($job) {
                    $fullName = DB::table('users')
                        ->where('id', $job->customer_id)
                        ->value('name') ?? 'Customer';
                    $job->customer_first_name = explode(' ', $fullName)[0];
                    $job->time_ago            = $this->timeAgo($job->created_at ?? '');
                    $job->budget_min          = $job->budget_min ?? 0;
                    $job->budget_max          = $job->budget_max ?? 0;
                    return $job;
                });
        }

        // ── Quick Stats ──────────────────────────────────────────
        $avgRating = DB::table('reviews')
            ->where('pro_id', $pro->id)
            ->avg('rating');

        $stats = [
            'new_leads'      => $newLeads->count(),
            'active_jobs'    => DB::table('customer_jobs')
                                    ->where('assigned_pro_id', $pro->id)
                                    ->whereIn('status', ['scheduled', 'in_progress'])
                                    ->count(),
            'jobs_completed' => DB::table('customer_jobs')
                                    ->where('assigned_pro_id', $pro->id)
                                    ->where('status', 'completed')
                                    ->count(),
            'total_earnings' => (float)\App\Models\Payment::where('professional_id', $pro->id)
                                    ->where('status', 'paid')
                                    ->sum('professional_payout_amount'),
            'avg_rating'     => $avgRating ? round((float)$avgRating, 1) : 0,
            'review_count'   => DB::table('reviews')
                                    ->where('pro_id', $pro->id)
                                    ->count(),
        ];

        // ── Active / Scheduled Jobs ──────────────────────────────
        $activeJobs = DB::table('customer_jobs')
            ->join('users', 'users.id', '=', 'customer_jobs.customer_id')
            ->where('customer_jobs.assigned_pro_id', $pro->id)
            ->whereIn('customer_jobs.status', ['scheduled', 'in_progress'])
            ->select('customer_jobs.*', 'users.name as customer_name')
            ->orderBy('customer_jobs.schedule')
            ->get();

        // ── Earnings (from payments table) ───────────────────────
        $earnings = \App\Http\Controllers\PaymentController::professionalEarnings($pro);
        $earnings['this_month'] = $earnings['this_month']; // already set
        // Backward compat: payout_history used by old view references
        if (empty($earnings['payout_history'])) {
            $earnings['payout_history'] = collect();
        }

        // ── Job History ──────────────────────────────────────────
        $jobHistory = DB::table('customer_jobs')
            ->join('users', 'users.id', '=', 'customer_jobs.customer_id')
            ->leftJoin('reviews', 'reviews.job_id', '=', 'customer_jobs.id')
            ->leftJoin('quotes', function($j) use ($pro) {
                $j->on('quotes.job_id', '=', 'customer_jobs.id')
                  ->where('quotes.pro_id', $pro->id)
                  ->where('quotes.status', 'accepted');
            })
            ->where('customer_jobs.assigned_pro_id', $pro->id)
            ->where('customer_jobs.status', 'completed')
            ->select(
                'customer_jobs.*',
                'users.name as customer_name',
                'reviews.rating  as review_rating',
                'reviews.comment as review_comment',
                'quotes.amount   as earned'
            )
            ->orderByDesc('customer_jobs.updated_at')
            ->get();

        // ── Reviews ──────────────────────────────────────────────
        $reviews = DB::table('reviews')
            ->join('users', 'users.id', '=', 'reviews.customer_id')
            ->where('reviews.pro_id', $pro->id)
            ->select('reviews.*', 'users.name as customer_name')
            ->orderByDesc('reviews.created_at')
            ->get();

        // ── Quoted Leads (tracking) ───────────────────────────────
        $quotedLeads = DB::table('customer_jobs')
            ->join('quotes', 'quotes.job_id', '=', 'customer_jobs.id')
            ->join('users',  'users.id',      '=', 'customer_jobs.customer_id')
            ->where('quotes.pro_id', $pro->id)
            ->whereIn('customer_jobs.status', ['pending_match', 'quotes_received'])
            ->select('customer_jobs.*', 'quotes.amount as quote_price', 'quotes.status as quote_status', 'users.name as customer_name')
            ->orderByDesc('quotes.created_at')
            ->get();

        return view('dashboard.professional', compact(
            'pro', 'newLeads', 'stats', 'activeJobs',
            'earnings', 'jobHistory', 'reviews', 'quotedLeads', 'tab'
        ));
    }

    // ── Toggle availability ────────────────────────────────────────
    public function toggleAvailability(Request $request)
    {
        $pro = Auth::user();
        $pro->available = !$pro->available;
        $pro->save();

        if ($request->expectsJson()) {
            return response()->json(['available' => $pro->available]);
        }
        return back();
    }

    // ── Send a quote ───────────────────────────────────────────────
    public function sendQuote(Request $request, int $jobId)
    {
        $request->validate([
            'price'   => 'required|numeric|min:1',
            'message' => 'nullable|string|max:1000',
        ]);

        $pro = Auth::user();

        // Verify job exists, is pending, and matches pro's trade
        $job = DB::table('customer_jobs')->where('id', $jobId)->first();
        if (!$job) return back()->withErrors(['error' => 'Job not found.']);

        $trades = $this->getProTrades($pro);
        if (!in_array($job->trade_category, $trades)) {
            return back()->withErrors(['error' => 'This job does not match your trade.']);
        }

        // Prevent duplicate quotes
        $existing = DB::table('quotes')
            ->where('job_id', $jobId)
            ->where('pro_id', $pro->id)
            ->first();

        if ($existing) return back()->with('info', 'You have already sent a quote for this job.');

        // Create quote
        DB::table('quotes')->insert([
            'job_id'     => $jobId,
            'pro_id'     => $pro->id,
            'amount'     => $request->price,
            'message'    => $request->message,
            'status'     => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Update job status to quotes_received
        DB::table('customer_jobs')
            ->where('id', $jobId)
            ->where('status', 'pending_match')
            ->update(['status' => 'quotes_received', 'updated_at' => now()]);

        // Notify the customer
        $customer = User::find($job->customer_id);
        Notification::create([
            'user_id'       => $job->customer_id,
            'type'          => 'quote_received',
            'title'         => 'Quote received from ' . $pro->name,
            'message'       => $pro->name . ' quoted Rs. ' . number_format($request->price) . ' for your "' . $job->trade_category . '" job.',
            'related_job_id'=> $jobId,
        ]);

        return back()->with('success', 'Quote sent successfully!');
    }

    // ── Skip a lead ────────────────────────────────────────────────
    public function skipLead(Request $request, int $jobId)
    {
        $pro = Auth::user();

        DB::table('skipped_leads')->updateOrInsert(
            ['pro_id' => $pro->id, 'job_id' => $jobId],
            ['created_at' => now(), 'updated_at' => now()]
        );

        if ($request->expectsJson()) {
            return response()->json(['skipped' => true]);
        }
        return back()->with('info', 'Lead hidden from your feed.');
    }

    // ── Start job (scheduled -> in_progress) ───────────────────────
    public function startJob(Request $request, int $jobId)
    {
        $pro = Auth::user();
        DB::table('customer_jobs')
            ->where('id', $jobId)
            ->where('assigned_pro_id', $pro->id)
            ->where('status', 'scheduled')
            ->update(['status' => 'in_progress', 'updated_at' => now()]);

        // Notify the customer
        $job = DB::table('customer_jobs')->where('id', $jobId)->first();
        if ($job) {
            Notification::create([
                'user_id'       => $job->customer_id,
                'type'          => 'job_started',
                'title'         => 'Job started',
                'message'       => $pro->name . ' has started your "' . $job->trade_category . '" job.',
                'related_job_id'=> $jobId,
            ]);
        }
        return back()->with('success', 'Job marked as in progress!');
    }

    // ── Mark job complete ──────────────────────────────────────────
    public function markComplete(Request $request, int $jobId)
    {
        $pro = Auth::user();

        $updated = DB::table('customer_jobs')
            ->where('id', $jobId)
            ->where('assigned_pro_id', $pro->id)
            ->whereIn('status', ['scheduled', 'in_progress'])
            ->update(['status' => 'completed', 'updated_at' => now()]);

        if ($updated) {
            // Earnings are tracked via payments table — customer submits payment,
            // admin confirms as paid, then professional sees it in earnings.
        }

        // Notify the customer
        $job = DB::table('customer_jobs')->where('id', $jobId)->first();
        if ($job) {
            $customerName = DB::table('users')->where('id', $job->customer_id)->value('name') ?? 'Customer';
            Notification::create([
                'user_id'       => $job->customer_id,
                'type'          => 'job_completed',
                'title'         => 'Job completed — leave a review',
                'message'       => $pro->name . ' marked your "' . $job->trade_category . '" job as complete. Please leave a review!',
                'related_job_id'=> $jobId,
            ]);
        }

        return back()->with('success', 'Job marked as completed!');
    }

    // ── Reschedule a job ───────────────────────────────────────────
    public function reschedule(Request $request, int $jobId)
    {
        $request->validate(['schedule' => 'required|date|after:now']);
        $pro = Auth::user();

        DB::table('customer_jobs')
            ->where('id', $jobId)
            ->where('assigned_pro_id', $pro->id)
            ->update(['schedule' => $request->schedule, 'updated_at' => now()]);

        return back()->with('success', 'Booking rescheduled.');
    }

    // ── Update profile ─────────────────────────────────────────────
    public function updateProfile(Request $request)
    {
        $pro = Auth::user();

        $request->validate([
            'bio'             => 'nullable|string|max:500',
            'trade'           => 'nullable|string|max:100',
            'trades'          => 'nullable|array',
            'trades.*'        => 'string|max:100',
            'years_experience'=> 'nullable|integer|min:0|max:50',
            'starting_price'  => 'nullable|numeric|min:0',
            'service_area'    => 'nullable|string|max:200',
            'location'        => 'nullable|string|max:200',
            'profile_photo'   => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'bio', 'trade', 'years_experience',
            'starting_price', 'service_area', 'location'
        ]);

        if ($request->has('trades')) {
            $data['trades'] = json_encode(array_filter($request->trades));
        }

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profiles', 'public');
            $data['profile_photo'] = $path;
        }

        $pro->fill($data)->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    // ── Change password ────────────────────────────────────────────
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|confirmed|min:8',
        ]);

        $pro = Auth::user();
        if (!Hash::check($request->current_password, $pro->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $pro->password = Hash::make($request->password);
        $pro->save();

        return back()->with('success', 'Password changed successfully.');
    }

    // ── Helper: human time ago ─────────────────────────────────────
    private function timeAgo(?string $datetime): string
    {
        if (empty($datetime)) return 'Recently';
        $now  = time();
        $then = strtotime($datetime);
        if ($then === false) return 'Recently';
        $diff = max(0, $now - $then);

        if ($diff < 60)     return 'Just now';
        if ($diff < 3600)   return floor($diff / 60) . 'm ago';
        if ($diff < 86400)  return floor($diff / 3600) . 'h ago';
        if ($diff < 604800) return floor($diff / 86400) . 'd ago';
        return date('M j', $then);
    }
}
