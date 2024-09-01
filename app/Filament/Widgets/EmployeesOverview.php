<?php

namespace App\Filament\Widgets;

use App\Models\Country;
use App\Models\Employee;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EmployeesOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $activeEmployeesCount = Employee::where('status', 'Active')->count();
        $saudi = Country::where('name', 'Saudi Arabian')->first();
        $saudiArabiansCount = $saudi != null ? $saudi->employees->where('status', 'Active')->count() : 0;
        $saudiArabiansPercentage = round($saudiArabiansCount / $activeEmployeesCount * 100, 1);
        $nonSaudiArabiansCount = $activeEmployeesCount - $saudiArabiansCount;
        $nonSaudiArabiansPercentage = round($nonSaudiArabiansCount / $activeEmployeesCount * 100, 1);

        return [
            Stat::make('Active Employees', $activeEmployeesCount)
                ->icon('heroicon-o-user-group')
                ->description('As of ' . now()->format('M d, Y')),
            Stat::make('Saudi Arabians', $saudiArabiansCount)
                ->description($saudiArabiansPercentage . '%' . ' of active employees')
                ->color('success'),
            Stat::make('Non-Saudi Arabians', $nonSaudiArabiansCount)
                ->description($nonSaudiArabiansPercentage . '%' . ' of active employees'),
        ];
    }
}
