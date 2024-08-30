<?php

namespace App\Filament\Imports;

use App\Filament\Imports\Utils\DateImportColumn;
use App\Models\EmployeeLeave;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class EmployeeLeaveImporter extends Importer
{
    protected static ?string $model = EmployeeLeave::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('request_file_link')
                ->rules(['max:255']),
            ImportColumn::make('employee_number')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('contact_number')
                ->rules(['max:255']),
            DateImportColumn::make('start_date')
                ->requiredMapping()
                ->rules(['required', 'date']),
            DateImportColumn::make('end_date')
                ->requiredMapping()
                ->rules(['required', 'date']),
            DateImportColumn::make('visa_expiration')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('arrived')
                ->boolean()
                ->castStateUsing(fn($state) => $state == null ? false : $state)
                ->rules(['nullable', 'boolean']),
            ImportColumn::make('visa_expired')
                ->boolean()
                ->castStateUsing(fn($state) => $state == null ? false : $state)
                ->rules(['nullable', 'boolean']),
        ];
    }

    public function resolveRecord(): ?EmployeeLeave
    {
        // return EmployeeLeave::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new EmployeeLeave();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your employee leave import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
