<?php

namespace App\Filament\Imports;

use App\Models\Contract;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ContractImporter extends Importer
{
    protected static ?string $model = Contract::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('employee_number')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('employeeJob')
                ->relationship(resolveUsing: 'job_title'),
            ImportColumn::make('start_date')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('end_date')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('paper_contract_end_date')
                ->rules(['nullable', 'date']),
            ImportColumn::make('basic_salary')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('housing_allowance')
                ->numeric()
                ->rules(['nullable', 'integer']),
            ImportColumn::make('transportation_allowance')
                ->numeric()
                ->rules(['nullable', 'integer']),
            ImportColumn::make('food_allowance')
                ->numeric()
                ->rules(['nullable', 'integer']),
            ImportColumn::make('remarks')
                ->rules(['max:255']),
            ImportColumn::make('file_link')
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): ?Contract
    {
        // return Contract::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Contract();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your contract import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
