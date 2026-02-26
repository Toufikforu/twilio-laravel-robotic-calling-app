<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Brystore;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Subscription;
use DB;
use Illuminate\Support\Facades\Log;

use Stripe\Stripe;
use Stripe\Product;
use Stripe\Checkout\Session;


class UserController extends Controller
{

    public function userdashboard()
    {
        $user = Auth::user();
    
        // Get the latest subscription for the user
        $latestSubscription = Subscription::where('user_id', $user->id)
            ->orderBy('created_at', 'desc') // Get the most recent subscription
            ->first();
    
        return view('user.dashboard', compact('user', 'latestSubscription'));
    }
    
    
    
    
    
    
   
    public function privacy()
    {
        return view('user.pages.privacy');
    }
    
    public function help()
    {
        return view('user.pages.helpsupport');
    }


    

    // User Dashboard Pages List




    public function scripts()
    {
        return view('user.pages.scripts');
    }

    public function campaigns()
    {
        return view('user.pages.campaigns');
    }

    public function calllogs()
    {
        return view('user.pages.calllogs');
    }

    public function use()
    {
        return view('user.pages.use');
    }
    public function mobileapp()
    {
        return view('user.pages.mobileapp');
    }
    public function flowus()
    {
        return view('user.pages.flowus');
    }


}
