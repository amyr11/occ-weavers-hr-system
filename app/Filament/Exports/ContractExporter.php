<?php

namespace App\Filament\Exports;

use App\Models\Contract;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ContractExporter extends Exporter
{
    protected static ?string $model = Contract::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('employee.employee_number')
                ->label('Employee no.'),
            ExportColumn::make('employee.full_name')
                ->label('Employee name'),
            ExportColumn::make('employeeJob.job_title')
                ->label('Job title'),
            ExportColumn::make('start_date'),
            ExportColumn::make('end_date'),
            ExportColumn::make('paper_contract_end_date'),
            ExportColumn::make('duration_in_years'),
            ExportColumn::make('basic_salary'),
            ExportColumn::make('housing_allowance'),
            ExportColumn::make('transportation_allowance'),
            ExportColumn::make('food_allowance'),
            ExportColumn::make('remarks'),
            ExportColumn::make('file_link'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your contract export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
