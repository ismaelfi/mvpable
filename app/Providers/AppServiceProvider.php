<?php

namespace App\Providers;

use App\Filament\Pages\ManageSettings;
use App\Models\Subscription;
use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Cashier::useSubscriptionModel(Subscription::class);
        Filament::registerPages([
            ManageSettings::class,
        ]);
    }
}
