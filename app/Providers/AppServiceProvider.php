<?php

namespace App\Providers;

use Carbon\Carbon;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Imports\ImportColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Table;
use Illuminate\Support\ServiceProvider;

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
        Table::$defaultDateDisplayFormat = config('app.date_format');

        DatePicker::configureUsing(function (DatePicker $datePicker) {
            return $datePicker
                ->native(false)
                ->displayFormat(config('app.date_format'));
        });
    }
}
