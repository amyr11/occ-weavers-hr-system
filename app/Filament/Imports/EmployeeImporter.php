<?php

namespace App\Filament\Imports;

use App\Filament\Imports\Utils\DateImportColumn;
use App\Models\Employee;
use Filament\Actions\Imports\Exceptions\RowImportFailedException;
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
                ->ignoreBlankState()
                ->rules(['nullable', 'integer']),
            ImportColumn::make('full_name')
                ->ignoreBlankState()
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('project')
                ->ignoreBlankState()
                ->relationship(resolveUsing: 'project_name')
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('country')
                ->ignoreBlankState()
                ->relationship(resolveUsing: 'name')
                ->rules(['nullable']),
            ImportColumn::make('insuranceClass')
                ->ignoreBlankState()
                ->relationship(resolveUsing: 'name')
                ->rules(['nullable']),
            DateImportColumn::make('birthdate')
                ->ignoreBlankState(),
            ImportColumn::make('mobile_number')
                ->ignoreBlankState()
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('email')
                ->ignoreBlankState()
                ->rules(['nullable', 'email', 'max:255']),
            ImportColumn::make('labor_office_number')
                ->ignoreBlankState()
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('iban_number')
                ->ignoreBlankState()
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('iqama_number')
                ->ignoreBlankState()
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('iqama_job_title')
                ->ignoreBlankState()
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('iqama_expiration_hijri')
                ->ignoreBlankState()
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('passport_number')
                ->ignoreBlankState()
                ->rules(['nullable', 'max:255']),
            DateImportColumn::make('passport_date_issue')
                ->ignoreBlankState(),
            DateImportColumn::make('passport_expiration')
                ->ignoreBlankState(),
            DateImportColumn::make('sce_expiration')
                ->ignoreBlankState(),
            DateImportColumn::make('company_start_date')
                ->ignoreBlankState(),
            DateImportColumn::make('final_exit_date')
                ->ignoreBlankState(),
            DateImportColumn::make('visa_expired_date')
                ->ignoreBlankState(),
            DateImportColumn::make('transferred_date')
                ->ignoreBlankState(),
        ];
    }

    public function resolveRecord(): ?Employee
    {
        // Fail when full name is not provided when creating a new employee
        $employee = Employee::where('employee_number', $this->data['employee_number'])->first();
        if ($employee == null and $this->data['full_name'] == null) {
            throw new RowImportFailedException('Full name is required.');
        }

        return Employee::firstOrNew([
            // Update existing records, matching them by `$this->data['column_name']`
            'employee_number' => $this->data['employee_number'],
        ]);
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
