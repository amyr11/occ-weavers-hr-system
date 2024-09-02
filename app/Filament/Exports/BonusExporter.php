<?php

namespace App\Filament\Exports;

use App\Filament\Exports\Utils\DateExportColumn;
use App\Models\Bonus;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class BonusExporter extends Exporter
{
    protected static ?string $model = Bonus::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('employee_number')
                ->label('Employee no.'),
            ExportColumn::make('employee.full_name')
                ->label('Employee name'),
            ExportColumn::make('bonus'),
            DateExportColumn::make('date_received'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your bonus export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
