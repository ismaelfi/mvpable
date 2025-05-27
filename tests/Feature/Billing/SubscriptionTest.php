<?php

namespace Tests\Feature\Billing;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('unauthenticated users cannot access subscription page', function () {
    $response = $this->get('/subscribe');

    $response->assertRedirect('/login');
});

test('authenticated users can view subscription page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/subscribe');

    $response->assertStatus(200);
    $response->assertViewIs('subscriptions.index');
});

test('users are redirected to payment when selecting a plan', function () {
    $user = User::factory()->create();

    // Mock the checkout to avoid actual Stripe API calls
    $this->mock(\App\Http\Controllers\SubscriptionController::class, function ($mock) {
        $mock->shouldReceive('checkout')
            ->andReturn(redirect('/dashboard')->with('success', 'Subscription created successfully!'));
    });

    $response = $this->actingAs($user)->post('/checkout', [
        'plan' => 'price_test123',
    ]);

    $response->assertRedirect('/dashboard');
    $response->assertSessionHas('success', 'Subscription created successfully!');
});

test('authenticated users can access billing portal', function () {
    $user = User::factory()->create(['stripe_id' => 'cus_test123']);

    // Mock the method to avoid actual Stripe API calls
    $this->mock(\App\Http\Controllers\SubscriptionController::class, function ($mock) {
        $mock->shouldReceive('redirectToBillingPortal')
            ->andReturn(redirect('https://billing.stripe.com/session/test'));
    });

    $response = $this->actingAs($user)->get('/billing-portal');

    $response->assertRedirect('https://billing.stripe.com/session/test');
});
