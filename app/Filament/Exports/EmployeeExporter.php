<?php

namespace App\Filament\Exports;

use App\Models\Employee;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class EmployeeExporter extends Exporter
{
    protected static ?string $model = Employee::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('employee_number'),
            ExportColumn::make('full_name'),
            ExportColumn::make('status'),
            ExportColumn::make('employeeJob.job_title')
                ->label('Current job title'),
            ExportColumn::make('country.name'),
            ExportColumn::make('insuranceClass.name'),
            ExportColumn::make('educationLevel.level'),
            ExportColumn::make('degree.degree'),
            ExportColumn::make('birthdate'),
            ExportColumn::make('age'),
            ExportColumn::make('mobile_number'),
            ExportColumn::make('email'),
            ExportColumn::make('college_graduation_date'),
            ExportColumn::make('labor_office_number'),
            ExportColumn::make('iban_number'),
            ExportColumn::make('iqama_number'),
            ExportColumn::make('iqama_job_title'),
            ExportColumn::make('iqama_expiration'),
            ExportColumn::make('passport_number'),
            ExportColumn::make('passport_date_issue'),
            ExportColumn::make('passport_expiration'),
            ExportColumn::make('sce_expiration'),
            ExportColumn::make('company_start_date'),
            ExportColumn::make('final_exit_date'),
            ExportColumn::make('visa_expired_date'),
            ExportColumn::make('transferred_date'),
            ExportColumn::make('max_leave_days'),
            ExportColumn::make('current_leave_days'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your employee export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
