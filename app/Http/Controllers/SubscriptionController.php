<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('subscriptions.index', compact('plans'));
    }

    public function checkout(Request $request)
    {
        $plan = Plan::findOrFail($request->plan);
        $checkoutSession = $request->user()->checkout($plan->stripe_plan_id, [
            'success_url' => route('dashboard'),
            'cancel_url' => route('subscribe'),
        ]);

        return redirect($checkoutSession->url);
    }

    public function billingPortal(Request $request)
    {
        $billingPortalSession = $request->user()->billingPortal();
        return redirect($billingPortalSession->url);
    }
}
