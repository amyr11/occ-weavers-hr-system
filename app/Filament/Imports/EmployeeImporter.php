<?php

namespace App\Filament\Imports;

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
            ImportColumn::make('first_name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('middle_name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('last_name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('suffix')
                ->rules(['max:255']),
            ImportColumn::make('country_id')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('insurance_class_id')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('education_level_id')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('degree_id')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('birthdate')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('mobile_number')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('email')
                ->requiredMapping()
                ->rules(['required', 'email', 'max:255']),
            ImportColumn::make('photo_link')
                ->rules(['max:255']),
            ImportColumn::make('college_graduation_date')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('labor_office_number')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('iban_number')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('iqama_number')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('iqama_job_title')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('iqama_expiration_hijri')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('passport_number')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('passport_date_issue')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('passport_expiration')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('sce_expiration')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('company_start_date')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('final_exit_date')
                ->rules(['nullable', 'date']),
            ImportColumn::make('visa_expired_date')
                ->rules(['nullable', 'date']),
            ImportColumn::make('transferred_date')
                ->rules(['nullable', 'date']),
            ImportColumn::make('max_leave_days')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
        ];
    }

    public function resolveRecord(): ?Employee
    {
        // return Employee::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

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
