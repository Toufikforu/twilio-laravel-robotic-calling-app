<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\subscription;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    public function showPlan()
    {
        $user = Auth::user();
    
        // Check if user has an active subscription
        if ($user->subscribed('default')) {
            // Get Subscription Details
            $subscription = $user->subscription('default');
    
            // Retrieve Plan Name from Stripe
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $stripePlan = $stripe->prices->retrieve($subscription->stripe_price);
    
            return view('user.payments.plan', [
                'planName' => $stripePlan->nickname // Plan Name from Stripe
            ]);
        }
    
        return view('user.payments.plan', [
            'planName' => 'No Active Subscription'
        ]);
    }


    // ---------------------  Not used code but needed --------------------------------------
        // Cancel Subscription
    public function cancelSubscription(Request $request)
    {
        $user = $request->user(); // Get the authenticated user
    
        try {
            if ($user->subscribed('default')) { // Assuming 'default' is the name of your subscription plan
                $subscription = $user->subscription('default');
                $subscription->cancel();
    
                return response()->json(['message' => 'Subscription canceled successfully'], 200);
            } else {
                return response()->json(['message' => 'User is not subscribed to any plan'], 400);
            }
        } catch (ApiErrorException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    
    // Used this code below working
    public function package()
    {
        $plans = Plan::get();
        return view('user.payments.package',compact('plans'))->with('stripeKey', env('STRIPE_KEY'));
    }


    // Package All to display from DB to view all package cards
    public function packageshow(Plan $plan, Request $request)
    {
        // Generate a SetupIntent for the authenticated user
        $intent = Auth::user()->createSetupIntent();
    
        // Pass the plan, intent, and Stripe public key to the view
        return view('user.payments.checkout', [
            'plan' => $plan,
            'intent' => $intent,
            'stripeKey' => 'pk_test_51GzoBwDn7g5G8yH48QM3w45IUUNDEWCgLW8tWk6s5gWRm9JRfAMYgGENv5gQVlDlDXmB2DCcBKd3clUQkrBGYMNn00Oa7qmayU' // Pass the public key dynamically from the .env file
        ]);
    }
    


    // old Subscription code with failed and successs

    public function paymentsuccess(Request $request)
    { 
        $plan = Plan::find($request->plan);
        $subscription = $request->user()->newSubscription($request->plan, $plan->stripe_plan)
                            ->create($request->token);
        return view('user.payments.paymentsuccess');
    }


}
