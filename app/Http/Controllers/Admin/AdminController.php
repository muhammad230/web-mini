<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerJob;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Professionals
    public function professionals(Request $request)
    {
        $query = User::where('role', 'professional');

        if ($request->has('trade')) {
            $query->where('trade', 'like', '%' . $request->trade . '%');
        }

        if ($request->has('status')) {
            $query->where('verification_status', $request->status);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $professionals = $query->withCount(['assignedJobs as jobs_completed' => function ($q) {
            $q->where('status', 'completed');
        }])->orderBy('created_at', 'desc')->paginate(20);

        return view('dashboard.admin.professionals', compact('professionals'));
    }

    public function professionalDetail($id)
    {
        $professional = User::where('role', 'professional')
            ->with(['assignedJobs' => function ($q) {
                $q->with('customer');
            }, 'reviewsReceived' => function ($q) {
                $q->with('customer');
            }])
            ->withCount(['assignedJobs as jobs_completed' => function ($q) {
                $q->where('status', 'completed');
            }])
            ->findOrFail($id);

        return view('dashboard.admin.professional-detail', compact('professional'));
    }

    public function toggleProfessionalActive($id)
    {
        $professional = User::where('role', 'professional')->findOrFail($id);
        $professional->available = !$professional->available;
        $professional->save();

        return back()->with('success', 'Professional status updated!');
    }

    // Customers
    public function customers(Request $request)
    {
        $query = User::where('role', 'customer');

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        $customers = $query->withCount('customerJobs')->orderBy('created_at', 'desc')->paginate(20);

        return view('dashboard.admin.customers', compact('customers'));
    }

    public function customerDetail($id)
    {
        $customer = User::where('role', 'customer')
            ->with(['customerJobs' => function ($q) {
                $q->with('assignedPro');
            }, 'addresses'])
            ->findOrFail($id);

        return view('dashboard.admin.customer-detail', compact('customer'));
    }

    public function toggleCustomerActive($id)
    {
        $customer = User::where('role', 'customer')->findOrFail($id);
        $customer->available = !$customer->available; // Using available as active/inactive
        $customer->save();

        return back()->with('success', 'Customer status updated!');
    }

    // Jobs
    public function jobs(Request $request)
    {
        $query = CustomerJob::with('customer', 'assignedPro');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('trade')) {
            $query->where('trade_category', 'like', '%' . $request->trade . '%');
        }

        if ($request->has('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->where('created_at', '<=', $request->date_to);
        }

        $jobs = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('dashboard.admin.jobs', compact('jobs'));
    }

    public function jobDetail($id)
    {
        $job = CustomerJob::with('customer', 'assignedPro', 'quotes.pro', 'review')->findOrFail($id);

        return view('dashboard.admin.job-detail', compact('job'));
    }

    // Reviews & Ratings
    public function reviews(Request $request)
    {
        $reviews = Review::with('customer', 'pro', 'job')->orderBy('created_at', 'desc')->paginate(20);

        return view('dashboard.admin.reviews', compact('reviews'));
    }

    public function deleteReview($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return back()->with('success', 'Review deleted!');
    }

    // Settings
    public function settings()
    {
        $admin = Auth::user();
        return view('dashboard.admin.settings', compact('admin'));
    }

    public function updateSettings(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $admin->id,
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:6|confirmed',
            ]);
            $admin->password = bcrypt($request->password);
        }

        $admin->save();

        return back()->with('success', 'Settings updated!');
    }

    // Reports
    public function reports(Request $request)
    {
        $period = $request->get('period', 'month');

        $startDate = match ($period) {
            'week' => now()->startOfWeek(),
            'month' => now()->startOfMonth(),
            'year' => now()->startOfYear(),
            default => now()->startOfMonth(),
        };

        $revenue = CustomerJob::where('status', 'completed')
            ->where('created_at', '>=', $startDate)
            ->sum('amount_paid');

        $totalJobs = CustomerJob::where('created_at', '>=', $startDate)->count();
        $completedJobs = CustomerJob::where('status', 'completed')
            ->where('created_at', '>=', $startDate)
            ->count();

        $jobsByTrade = CustomerJob::select('trade_category', \DB::raw('count(*) as total'))
            ->where('created_at', '>=', $startDate)
            ->groupBy('trade_category')
            ->get();

        return view('dashboard.admin.reports', compact('revenue', 'totalJobs', 'completedJobs', 'jobsByTrade', 'period'));
    }
}

