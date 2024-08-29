<?php

namespace App\Filament\Imports;

use App\Models\ProjectAssignment;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ProjectAssignmentImporter extends Importer
{
    protected static ?string $model = ProjectAssignment::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('employee_number')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('project')
                ->requiredMapping()
                ->relationship(resolveUsing: 'project_name')
                ->rules(['required']),
            ImportColumn::make('transfer_date')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('transfer_memo_link')
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): ?ProjectAssignment
    {
        // return ProjectAssignment::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new ProjectAssignment();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your project assignment import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
