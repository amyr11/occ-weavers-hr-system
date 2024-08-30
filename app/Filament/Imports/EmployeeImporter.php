<?php

namespace App\Filament\Imports;

use App\Filament\Imports\Utils\DateImportColumn;
use App\Models\Employee;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class EmployeeImporter extends Importer
{
    protected static ?string $model = Employee::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('employee_number')
                ->rules(['nullable', 'integer']),
            ImportColumn::make('full_name')
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('country')
                ->relationship(resolveUsing: 'name')
                ->rules(['nullable']),
            ImportColumn::make('insuranceClass')
                ->relationship(resolveUsing: 'name')
                ->rules(['nullable']),
            ImportColumn::make('educationLevel')
                ->relationship(resolveUsing: 'level')
                ->rules(['nullable']),
            ImportColumn::make('degree')
                ->relationship(resolveUsing: 'degree')
                ->rules(['nullable']),
            DateImportColumn::make('birthdate'),
            ImportColumn::make('mobile_number')
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('email')
                ->rules(['nullable', 'email', 'max:255']),
            DateImportColumn::make('college_graduation_date'),
            ImportColumn::make('labor_office_number')
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('iban_number')
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('iqama_number')
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('iqama_job_title')
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('iqama_expiration_hijri')
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('passport_number')
                ->rules(['nullable', 'max:255']),
            DateImportColumn::make('passport_date_issue'),
            DateImportColumn::make('passport_expiration'),
            DateImportColumn::make('sce_expiration'),
            DateImportColumn::make('company_start_date'),
            DateImportColumn::make('final_exit_date'),
            DateImportColumn::make('visa_expired_date'),
            DateImportColumn::make('transferred_date'),
            ImportColumn::make('max_leave_days')
                ->numeric()
                ->rules(['nullable', 'integer']),
        ];
    }

    public function resolveRecord(): ?Employee
    {
        return Employee::firstOrNew([
            // Update existing records, matching them by `$this->data['column_name']`
            'employee_number' => $this->data['employee_number'],
        ]);

        return new Employee();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your employee import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
