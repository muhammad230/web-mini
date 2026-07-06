<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\CustomerJob;
use App\Models\Quote;
use App\Models\Review;
use App\Models\Address;
use App\Helpers\SiteContentHelper;
use App\Http\Controllers\Admin\SiteContentController;

class CustomerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $activeJobs = $user->customerJobs()->whereNotIn('status', ['completed', 'cancelled'])->get();
        $completedJobs = $user->customerJobs()->where('status', 'completed')->get();
        $totalSpent = $completedJobs->sum('amount_paid');
        $savedPros = $user->savedProfessionals()->get();
        $quotesReceived = Quote::whereHas('job', function($q) use ($user) {
            $q->where('customer_id', $user->id);
        })->where('status', 'pending')->get();
        $reviewsGiven = $user->reviewsGiven()->get();
        $addresses = $user->addresses()->get();

        // Get trades from site content
        $tradesData = SiteContentHelper::get('browse_trades', SiteContentController::DEFAULTS['browse_trades']);
        $trades = $tradesData['trades'] ?? [];

        return view('dashboard.customer', compact(
            'activeJobs', 'completedJobs', 'totalSpent', 'savedPros',
            'quotesReceived', 'reviewsGiven', 'addresses', 'trades'
        ));
    }

    public function storeJob(Request $request)
    {
        $request->validate([
            'trade_category' => 'required|string',
            'description' => 'required|string',
            'location' => 'required|string',
            'budget_type' => 'required|in:fixed,flexible',
            'budget_min' => 'nullable|numeric|min:0',
            'budget_max' => 'nullable|numeric|min:0',
            'schedule' => 'required|string',
        ]);

        $job = CustomerJob::create([
            'customer_id' => Auth::id(),
            'trade_category' => $request->trade_category,
            'description' => $request->description,
            'location' => $request->location,
            'budget_type' => $request->budget_type,
            'budget_min' => $request->budget_min,
            'budget_max' => $request->budget_max,
            'schedule' => $request->schedule,
            'status' => 'pending_match',
        ]);

        return back()->with('success', 'Job posted successfully!');
    }

    public function showJob(CustomerJob $job)
    {
        // Ensure customer can only view their own jobs
        if ($job->customer_id !== Auth::id()) {
            abort(403);
        }
        return view('dashboard.customer-job-detail', compact('job'));
    }

    public function acceptQuote(Quote $quote)
    {
        if ($quote->job->customer_id !== Auth::id()) {
            abort(403);
        }

        // Accept this quote
        $quote->update(['status' => 'accepted']);

        // Reject all other quotes for the job
        $quote->job->quotes()->where('id', '!=', $quote->id)->update(['status' => 'rejected']);

        // Update job status and assign pro
        $quote->job->update([
            'status' => 'scheduled',
            'assigned_pro_id' => $quote->pro_id,
        ]);

        return back()->with('success', 'Quote accepted! Job scheduled.');
    }

    public function declineQuote(Quote $quote)
    {
        if ($quote->job->customer_id !== Auth::id()) {
            abort(403);
        }
        $quote->update(['status' => 'rejected']);
        return back()->with('success', 'Quote declined.');
    }

    public function rescheduleJob(Request $request, CustomerJob $job)
    {
        if ($job->customer_id !== Auth::id()) {
            abort(403);
        }
        $request->validate(['schedule' => 'required|string']);
        $job->update(['schedule' => $request->schedule]);
        return back()->with('success', 'Job rescheduled!');
    }

    public function cancelJob(CustomerJob $job)
    {
        if ($job->customer_id !== Auth::id()) {
            abort(403);
        }
        $job->update(['status' => 'cancelled']);
        return back()->with('success', 'Job cancelled.');
    }

    public function leaveReview(Request $request, CustomerJob $job)
    {
        if ($job->customer_id !== Auth::id() || $job->status !== 'completed' || $job->review()->exists()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        Review::create([
            'job_id' => $job->id,
            'customer_id' => Auth::id(),
            'pro_id' => $job->assigned_pro_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review submitted!');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
        ]);

        Auth::user()->update($request->only('name', 'email', 'phone'));

        return back()->with('success', 'Profile updated!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        Auth::user()->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Password changed!');
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        Address::create([
            'user_id' => Auth::id(),
            'label' => $request->label,
            'address' => $request->address,
        ]);

        return back()->with('success', 'Address saved!');
    }

    public function updateAddress(Request $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'label' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        $address->update($request->only('label', 'address'));

        return back()->with('success', 'Address updated!');
    }

    public function deleteAddress(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }
        $address->delete();
        return back()->with('success', 'Address deleted!');
    }

    public function savePro(Request $request)
    {
        $request->validate(['pro_id' => 'required|exists:users,id']);
        Auth::user()->savedProfessionals()->syncWithoutDetaching([$request->pro_id]);
        return back()->with('success', 'Professional saved!');
    }

    public function removeSavedPro(Request $request)
    {
        $request->validate(['pro_id' => 'required|exists:users,id']);
        Auth::user()->savedProfessionals()->detach($request->pro_id);
        return back()->with('success', 'Professional removed from saved list!');
    }

    public function rebookJob(CustomerJob $job)
    {
        if ($job->customer_id !== Auth::id()) {
            abort(403);
        }

        // Create a new job with same details
        CustomerJob::create([
            'customer_id' => Auth::id(),
            'trade_category' => $job->trade_category,
            'description' => $job->description,
            'location' => $job->location,
            'budget_type' => $job->budget_type,
            'budget_min' => $job->budget_min,
            'budget_max' => $job->budget_max,
            'schedule' => $job->schedule,
            'status' => 'pending_match',
        ]);

        return back()->with('success', 'Job rebooked!');
    }
}
