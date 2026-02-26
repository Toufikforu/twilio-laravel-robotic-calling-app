<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SessionExpiredMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in
        if (Auth::check()) {
            // Get the last activity timestamp from session
            $lastActivity = session('lastActivityTime');

            // Define session timeout (in seconds) - Example: 15 minutes
            $sessionTimeout = config('session.lifetime') * 15; 

            // If last activity is set and exceeded timeout, logout and redirect
            if ($lastActivity && (time() - $lastActivity) > $sessionTimeout) {
                Auth::logout();
                session()->flush();
                return redirect()->route('login')->with('error', 'Your session has expired. Please login again.');
            }

            // Update session activity time
            session(['lastActivityTime' => time()]);
        }

        return $next($request);
    }
}
