<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class paycheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // public function handle(Request $request, Closure $next)
    // {
    //     // Skip the logic for the registration route
    //     if ($request->is('register')) {
    //         return $next($request); // Allow registration to proceed without checks
    //     }
    
    //     $userid = Auth::id();
    
    //     // Ensure that the user is logged in
    //     if (!$userid) {
    //         return redirect()->route('login'); // Redirect to login if not authenticated
    //     }
    
    //     $user = User::find($userid);
    
    //     // ✅ Check if admin manually approved the user
    //     if ($user->is_admin_approved) {
    //         \Log::info("User with ID $userid is admin approved. Bypassing Stripe check.");
    //         return $next($request);
    //     }
    
    //     // Fetch the most recent subscription based on created_at descending
    //     $latestSubscription = Subscription::where('user_id', $user->id)
    //         ->orderBy('created_at', 'desc') // Most recent subscription first
    //         ->first();
    
    //     // If there's no subscription or if the latest subscription is inactive
    //     if ($latestSubscription === null || $latestSubscription->stripe_status === 'inactive') {
    //         \Log::info("User with ID $userid has no subscription or inactive subscription. Redirecting...");
    //         return redirect()->route('package'); // Redirect to the subscription page
    //     }
    
    //     // If the subscription is active, proceed with the request
    //     \Log::info("User with ID $userid has an active subscription.");
    //     return $next($request); // Proceed with the next middleware or request handling
    // }
    
    
        public function handle(Request $request, Closure $next)
    {
        // Skip the logic for the registration route
        if ($request->is('register')) {
            return $next($request); // Allow registration to proceed without checks
        }

        $userid = Auth::id();

        // Ensure that the user is logged in
        if (!$userid) {
            return redirect()->route('login'); // Redirect to login if not authenticated
        }

        $user = User::find($userid);

        // ✅ Check if admin manually approved the user
        if ($user->is_admin_approved) {
            \Log::info("User with ID $userid is admin approved. Bypassing Stripe check.");
            return $next($request);
        }

        // Fetch the most recent subscription based on created_at descending
        $latestSubscription = Subscription::where('user_id', $user->id)
            ->orderBy('created_at', 'desc') // Most recent subscription first
            ->first();

        // If there's no subscription or if the latest subscription is inactive
        if ($latestSubscription === null || $latestSubscription->stripe_status === 'inactive') {
            \Log::info("User with ID $userid has no subscription or inactive subscription. Redirecting...");
            return redirect()->route('package'); // Redirect to the subscription page
        }

        // If the subscription is active, proceed with the request
        \Log::info("User with ID $userid has an active subscription.");
        return $next($request); // Proceed with the next middleware or request handling
    }

    
    
}
