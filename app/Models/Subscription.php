<?php

namespace App\Models;

use Laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{
    protected static function booted()
    {
        static::creating(function ($subscription) {
            $subscription->updateAmount();
        });

        static::updating(function ($subscription) {
            $subscription->updateAmount();
        });
    }

    public function updateAmount()
    {
        $stripeSubscription = $this->asStripeSubscription();
        $this->amount = $stripeSubscription->items->data[0]->price->unit_amount / 100;
    }

    public static function createOrUpdate($subscription, $name, $plan)
    {
        $sub = parent::createOrUpdate($subscription, $name, $plan);
        $sub->updateAmount();

        return $sub;
    }
}
