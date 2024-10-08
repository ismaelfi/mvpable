<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::create([
            'name' => 'Basic',
            'slug' => 'basic',
            'stripe_plan_id' => 'price_1234567890',
            'price' => 1000,
            'description' => 'Basic plan',
        ]);

        Plan::create([
            'name' => 'Pro',
            'slug' => 'pro',
            'stripe_plan_id' => 'price_0987654321',
            'price' => 2000,
            'description' => 'Pro plan',
        ]);

    }
}
