<?php

namespace App\Filament\Exports;

use App\Models\ProjectAssignment;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProjectAssignmentExporter extends Exporter
{
    protected static ?string $model = ProjectAssignment::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('employee.employee_number')
                ->label('Employee No.'),
            ExportColumn::make('employee.full_name')
                ->label('Employee Name'),
            ExportColumn::make('project.project_name'),
            ExportColumn::make('transfer_date'),
            ExportColumn::make('transfer_memo_link'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your project assignment export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
