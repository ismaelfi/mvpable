<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Illuminate\Console\Command;

class UpdateSubscriptionAmounts extends Command
{
    protected $signature = 'subscriptions:update-amounts';

    protected $description = 'Update the amount field for all active subscriptions';

    public function handle()
    {
        $subscriptions = Subscription::where('stripe_status', 'active')->get();

        foreach ($subscriptions as $subscription) {
            $subscription->updateAmount();
            $subscription->save();
            $this->info("Updated subscription {$subscription->id} with amount {$subscription->amount}");
        }

        $this->info('All subscription amounts have been updated.');
    }
}
