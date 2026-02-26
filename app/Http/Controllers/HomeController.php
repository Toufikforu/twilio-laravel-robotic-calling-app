<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\App\Models\User;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
    
        return view('user.dashboard', [
            'intent' => $user->createSetupIntent(),
        ]);
    }
}
