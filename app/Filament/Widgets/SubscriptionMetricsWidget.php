<?php

namespace App\Filament\Widgets;

use App\Models\Subscription;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SubscriptionMetricsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            $this->getChurnRateStat(),
            $this->getMRRStat(),
            $this->getRevenueStat(),
        ];
    }

    protected function getChurnRateStat(): Stat
    {
        $startDate = now()->subMonth();
        $endDate = now();

        $startSubscribers = Subscription::where('created_at', '<', $startDate)->count();
        $churnedSubscribers = Subscription::where('stripe_status', 'canceled')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->count();

        $churnRate = $startSubscribers > 0 ? ($churnedSubscribers / $startSubscribers) * 100 : 0;

        return Stat::make('Monthly Churn Rate', number_format($churnRate, 2).'%')
            ->description('Subscribers lost in the last 30 days')
            ->color('danger');
    }

    protected function getMRRStat(): Stat
    {
        $mrr = Subscription::where('stripe_status', 'active')
            ->sum('amount');

        $lastMonthMRR = Subscription::where('stripe_status', 'active')
            ->where('created_at', '<', now()->subMonth())
            ->sum('amount');

        $mrrIncrease = $mrr - $lastMonthMRR;

        return Stat::make('MRR', '$'.number_format($mrr, 2))
            ->description('$'.number_format($mrrIncrease, 2).' increase')
            ->descriptionIcon($mrrIncrease > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
            ->color($mrrIncrease > 0 ? 'success' : 'danger');
    }

    protected function getRevenueStat(): Stat
    {
        $totalRevenue = Subscription::where('stripe_status', 'active')
            ->sum('amount');

        $lastMonthRevenue = Subscription::where('stripe_status', 'active')
            ->where('created_at', '>=', now()->subMonth())
            ->sum('amount');

        return Stat::make('Total Revenue', '$'.number_format($totalRevenue, 2))
            ->description('$'.number_format($lastMonthRevenue, 2).' last month')
            ->color('success');
    }
}
