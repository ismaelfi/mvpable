<?php

use App\Http\Controllers\SubscriptionController;
use App\Http\Middleware\EnsureUserIsSubscribed;
use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::middleware(['auth'])->group(function () {   //EnsureUserIsSubscribed::class to middleware
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::get('/subscribe', [SubscriptionController::class, 'index'])->name('subscribe');
    Route::post('/checkout', [SubscriptionController::class, 'checkout'])->name('checkout');
    Route::get('/billing-portal', [SubscriptionController::class, 'billingPortal'])->name('billing-portal');
});

require __DIR__.'/auth.php';
