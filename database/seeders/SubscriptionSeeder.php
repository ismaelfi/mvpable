<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Laravel\Cashier\Subscription;

class SubscriptionSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            Subscription::create([
                'user_id' => $user->id,
                'type' => 'default',
                'stripe_id' => 'sub_'.Str::random(10),
                'stripe_status' => 'active',
                'stripe_price' => 'price_basic_monthly',
                'amount' => '134',
                'quantity' => 1,
                'trial_ends_at' => Carbon::now()->addMonth(),
                'ends_at' => null,
            ]);
        }
    }
}
