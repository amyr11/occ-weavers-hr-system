<?php

namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Models\Employee;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;

class EmployeeExitsMonthly extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'employeeExits';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Employee Exits (Monthly)';

    protected function getFormSchema(): array
    {
        return [
            // Input for start date
            DatePicker::make('start_date')
                ->label('Start Date')
                ->default(Carbon::now()->startOfYear()->format('Y-m-d'))
                ->required(),

            // Input for end date
            DatePicker::make('end_date')
                ->label('End Date')
                ->default(Carbon::now()->endOfYear()->format('Y-m-d'))
                ->required(),
        ];
    }

    protected function getOptions(): array
    {
        // Default to current year if no dates are provided
        $startDate = $this->filterFormData['start_date'] ?? Carbon::now()->startOfYear()->format('Y-m-d');
        $endDate = $this->filterFormData['end_date'] ?? Carbon::now()->endOfYear()->format('Y-m-d');

        // Convert to Carbon instances
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        // Array of abbreviated month names
        $monthNames = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Aug',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec'
        ];

        // Initialize arrays for data and categories
        $finalExits = [];
        $visaExpired = [];
        $transferred = [];
        $categories = [];

        // Generate categories and populate data
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $month = $currentDate->month;
            $year = $currentDate->year;

            // Create category label in the format "Year - Month"
            $categories[] = "{$year} - {$monthNames[$month]}";

            // Collect data for each month
            $finalExits[$currentDate->format('Y-m')] = Employee::whereMonth('final_exit_date', $month)
                ->whereYear('final_exit_date', $year)
                ->count();

            $visaExpired[$currentDate->format('Y-m')] = Employee::whereMonth('visa_expired_date', $month)
                ->whereYear('visa_expired_date', $year)
                ->count();

            $transferred[$currentDate->format('Y-m')] = Employee::whereMonth('transferred_date', $month)
                ->whereYear('transferred_date', $year)
                ->count();

            $currentDate->addMonth();
        }

        // Fill missing months with zero values
        $monthRange = array_fill_keys(array_map(fn($date) => $date->format('Y-m'), $this->getDateRange($startDate, $endDate)), 0);
        $finalExits = array_merge($monthRange, $finalExits);
        $visaExpired = array_merge($monthRange, $visaExpired);
        $transferred = array_merge($monthRange, $transferred);

        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Final Exits',
                    'data' => array_values($finalExits),
                ],
                [
                    'name' => 'Visa Expired',
                    'data' => array_values($visaExpired),
                ],
                [
                    'name' => 'Transferred',
                    'data' => array_values($transferred),
                ],
            ],
            'xaxis' => [
                'categories' => $categories,
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#fb6107', '#f5b700', '#159456'],
            'stroke' => [
                'curve' => 'smooth',
            ],
            'title' => [
                'text' => "{$startDate->format('M d, Y')} - {$endDate->format('M d, Y')}",
                'align' => 'left',
            ],
        ];
    }

    private function getDateRange(Carbon $start, Carbon $end): array
    {
        $dates = [];
        $currentDate = $start->copy();
        while ($currentDate <= $end) {
            $dates[] = $currentDate->copy();
            $currentDate->addMonth();
        }
        return $dates;
    }
}
