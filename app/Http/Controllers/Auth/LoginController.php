<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Default redirect URL
    protected $redirectTo = '/user/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function authenticated($request, $user)
    {
        Log::info('User authenticated: ' . $user->id . ' with access_status: ' . $user->access_status);

        if ($user->access_status == 1) {
            // Admin dashboard
            return redirect('/admin/dashboard');
        }

        // User dashboard
        return redirect('/user/dashboard');
    }
}
