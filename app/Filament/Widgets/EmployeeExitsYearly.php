<?php

namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Models\Employee;
use Carbon\Carbon;
use Filament\Forms\Components\TextInput;

class EmployeeExitsYearly extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'employeeExitsYearly';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Employee Exits (Yearly)';

    protected function getFormSchema(): array
    {
        // Get the earliest and latest years from the employee data
        $years = Employee::selectRaw('YEAR(final_exit_date) as year')
            ->union(Employee::selectRaw('YEAR(visa_expired_date) as year'))
            ->union(Employee::selectRaw('YEAR(transferred_date) as year'))
            ->distinct()
            ->pluck('year')
            ->toArray();

        // Remove null item from years array
        $years = array_filter($years, function ($year) {
            return $year !== null;
        });

        $earliestYear = min($years);
        $latestYear = max($years);

        return [
            // Input for start year
            TextInput::make('start_year')
                ->label('Start Year')
                ->numeric()
                ->minLength(4)
                ->maxLength(4)
                ->default($earliestYear)
                ->required()
                ->rules(['integer', 'digits:4', 'min:1900', 'max:2099']),

            // Input for end year
            TextInput::make('end_year')
                ->label('End Year')
                ->numeric()
                ->minLength(4)
                ->maxLength(4)
                ->default($latestYear)
                ->required()
                ->rules(['integer', 'digits:4', 'min:1900', 'max:2099']),
        ];
    }

    protected function getOptions(): array
    {
        // Get start and end years from the form data
        $startYear = $this->filterFormData['start_year'] ?? Carbon::now()->startOfYear()->format('Y');
        $endYear = $this->filterFormData['end_year'] ?? Carbon::now()->endOfYear()->format('Y');

        // Ensure years are valid integers
        $startYear = (int)$startYear;
        $endYear = (int)$endYear;

        // Ensure endYear is greater than startYear
        if ($endYear < $startYear) {
            $endYear = $startYear;
        }

        // Generate years array for categories
        $categories = range($startYear, $endYear);

        // Retrieve data for each year
        $finalExits = Employee::selectRaw('YEAR(final_exit_date) as year, COUNT(*) as count')
            ->whereYear('final_exit_date', '>=', $startYear)
            ->whereYear('final_exit_date', '<=', $endYear)
            ->groupBy('year')
            ->pluck('count', 'year')
            ->toArray();

        $visaExpired = Employee::selectRaw('YEAR(visa_expired_date) as year, COUNT(*) as count')
            ->whereYear('visa_expired_date', '>=', $startYear)
            ->whereYear('visa_expired_date', '<=', $endYear)
            ->groupBy('year')
            ->pluck('count', 'year')
            ->toArray();

        $transferred = Employee::selectRaw('YEAR(transferred_date) as year, COUNT(*) as count')
            ->whereYear('transferred_date', '>=', $startYear)
            ->whereYear('transferred_date', '<=', $endYear)
            ->groupBy('year')
            ->pluck('count', 'year')
            ->toArray();

        // Fill missing years with zero values
        $finalExits = array_replace(array_fill_keys($categories, 0), $finalExits);
        $visaExpired = array_replace(array_fill_keys($categories, 0), $visaExpired);
        $transferred = array_replace(array_fill_keys($categories, 0), $transferred);

        return [
            'chart' => [
                'type' => 'bar',
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
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 3,
                    'horizontal' => false,
                ],
            ],
            'title' => [
                'text' => "{$startYear} - {$endYear}",
                'align' => 'left',
            ],
        ];
    }
}
