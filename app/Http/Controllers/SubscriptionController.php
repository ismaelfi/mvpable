<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        $user = Auth::user();
        $currentPlan = null;
        $hasActiveSubscription = false;

        if ($user->subscribed('default')) {
            $hasActiveSubscription = true;
            $currentPlan = $user->subscription('default')->stripe_price;
        }

        return view('subscriptions.index', compact('plans', 'currentPlan', 'hasActiveSubscription'));
    }

    public function checkout(Request $request)
    {
        $plan = Plan::findOrFail($request->plan);
        $checkoutSession = $request->user()->newSubscription('default', $plan->stripe_plan_id)->checkout([
            'success_url' => route('dashboard'),
            'cancel_url' => route('subscribe'),
            'allow_promotion_codes' => true,
        ]);

        return redirect($checkoutSession->url);
    }

    public function swap(Request $request)
    {
        $plan = Plan::findOrFail($request->plan);
        $user = Auth::user();

        if ($user->subscribed('default')) {
            try {
                $user->subscription('default')->swap($plan->stripe_plan_id);

                return redirect()->route('subscribe')->with('success', 'Your subscription has been updated to '.$plan->name.'.');
            } catch (Exception $e) {
                return redirect()->route('subscribe')->with('error', 'There was an error updating your subscription: '.$e->getMessage());
            }
        }

        return redirect()->route('subscribe')->with('error', 'You don\'t have an active subscription.');
    }

    public function redirectToBillingPortal()
    {
        $user = Auth::user();

        return $user->redirectToBillingPortal(route('dashboard'));
    }
}
