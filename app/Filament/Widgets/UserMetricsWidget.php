<?php

namespace App\Filament\Widgets;

use App\Models\Subscription;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserMetricsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            $this->getTotalUsersStat(),
            $this->getActiveSubscribersStat(),
            $this->getConversionRateStat(),
        ];
    }

    protected function getTotalUsersStat(): Stat
    {
        $totalUsers = User::count();
        $newUsersLastMonth = User::where('created_at', '>=', now()->subMonth())->count();

        return Stat::make('Total Users', $totalUsers)
            ->description($newUsersLastMonth.' new users last month')
            ->color('primary');
    }

    protected function getActiveSubscribersStat(): Stat
    {
        $activeSubscribers = Subscription::where('stripe_status', 'active')->count();
        $newSubscribersLastMonth = Subscription::where('stripe_status', 'active')
            ->where('created_at', '>=', now()->subMonth())
            ->count();

        return Stat::make('Active Subscribers', $activeSubscribers)
            ->description($newSubscribersLastMonth.' new subscribers last month')
            ->color('success');
    }

    protected function getConversionRateStat(): Stat
    {
        $totalUsers = User::count();
        $activeSubscribers = Subscription::where('stripe_status', 'active')->count();

        $conversionRate = $totalUsers > 0 ? ($activeSubscribers / $totalUsers) * 100 : 0;

        $lastMonthUsers = User::where('created_at', '<', now()->subMonth())->count();
        $lastMonthSubscribers = Subscription::where('stripe_status', 'active')
            ->where('created_at', '<', now()->subMonth())
            ->count();
        $lastMonthConversionRate = $lastMonthUsers > 0 ? ($lastMonthSubscribers / $lastMonthUsers) * 100 : 0;

        $conversionRateChange = $conversionRate - $lastMonthConversionRate;

        return Stat::make('Conversion Rate', number_format($conversionRate, 2).'%')
            ->description(number_format(abs($conversionRateChange), 2).'% '.($conversionRateChange >= 0 ? 'increase' : 'decrease'))
            ->descriptionIcon($conversionRateChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
            ->color($conversionRateChange >= 0 ? 'success' : 'danger');
    }
}
