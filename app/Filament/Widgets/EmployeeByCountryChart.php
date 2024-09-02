<?php

namespace App\Filament\Widgets;

use App\Models\Country;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class EmployeeByCountryChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'employeeByCountryChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Employee % by Country';

    protected int | string | array $columnSpan = 'full';

    private function sortDataByPercentage(array $percentages, array $countries)
    {
        $data = [];
        foreach ($percentages as $index => $percentage) {
            $data[] = [
                'country' => $countries[$index],
                'percentage' => $percentage,
            ];
        }

        usort($data, function ($a, $b) {
            return $b['percentage'] > $a['percentage'];
        });

        return $data;
    }

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $countries = Country::all();

        $countryNames = $countries->map(fn($country) => $country->name);
        $data = $countries->map(fn($nationality) => $nationality->employees->where('status', 'Active')->count());
        $total = $data->sum();
        $percentages = $data->map(fn($count) => $total ? round(($count / $total) * 100, 1) : 0);
        $sortedData = $this->sortDataByPercentage($percentages->toArray(), $countryNames->toArray());

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Percentage',
                    'data' => array_map(fn($item) => $item['percentage'], $sortedData),
                ],
            ],
            'xaxis' => [
                'categories' => array_map(fn($item) => $item['country'], $sortedData),
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
            'colors' => "#159456",
            'plotOptions' => [
                'bar' => [
                    'horizontal' => false,
                ],
            ],
        ];
    }
}
