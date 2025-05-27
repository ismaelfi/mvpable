<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ThemeController;
use App\Http\Middleware\EnsureUserIsSubscribed;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {   // EnsureUserIsSubscribed::class to middleware
    Route::view('/dashboard', 'dashboard')->name('dashboard');
});

Route::view('settings', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::get('/subscribe', [SubscriptionController::class, 'index'])->name('subscribe');
    Route::post('/checkout', [SubscriptionController::class, 'checkout'])->name('checkout');
    Route::post('/swap', [SubscriptionController::class, 'swap'])->name('swap');
    Route::get('/billing-portal', [SubscriptionController::class, 'redirectToBillingPortal'])->name('billing-portal');

});

Route::get('/sitemap.xml', function () {
    return response()->file(public_path('sitemap.xml'));
});

Route::post('/theme/update', [ThemeController::class, 'update'])->name('theme.update');

Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])
    ->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])
    ->name('socialite.callback');

require __DIR__.'/auth.php';
