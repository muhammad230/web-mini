<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectPendingJob
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('pending_job')) {
            $pending = session('pending_job');
            $trade = $pending['trade'] ?? '';
            $location = $pending['location'] ?? '';
            session()->forget('pending_job');

            return redirect()->route('jobs.create', [
                'trade' => $trade,
                'location' => $location,
            ]);
        }

        return $next($request);
    }
}
