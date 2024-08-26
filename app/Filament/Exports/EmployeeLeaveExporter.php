<?php

namespace App\Filament\Exports;

use App\Models\EmployeeLeave;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class EmployeeLeaveExporter extends Exporter
{
    protected static ?string $model = EmployeeLeave::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('employee.employee_number')
                ->label('Employee no.'),
            ExportColumn::make('employee.full_name')
                ->label('Employee name'),
            ExportColumn::make('contact_number'),
            ExportColumn::make('status'),
            ExportColumn::make('start_date')
                ->label('Departure date'),
            ExportColumn::make('end_date')
                ->label('Return date'),
            ExportColumn::make('duration_in_days'),
            ExportColumn::make('remaining_leave_days'),
            ExportColumn::make('visa_expiration'),
            ExportColumn::make('visa_duration_in_days'),
            ExportColumn::make('visa_remaining_days'),
            ExportColumn::make('arrived'),
            ExportColumn::make('visa_expired'),
            ExportColumn::make('request_file_link'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your employee leave export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
