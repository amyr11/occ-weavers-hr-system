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
        $filipinoEmployeesCount = Country::where('name', 'Pilipino')->first()->employees->where('status', 'Active')->count();

        return [
            Stat::make('✅ No. of Active Employees', $activeEmployeesCount),
            Stat::make('🇵🇭 No. of Filipino Employees', $filipinoEmployeesCount),
        ];
    }
}
