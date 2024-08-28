<?php

namespace App\Filament\Resources\EmployeeJobResource\Pages;

use App\Filament\Imports\EmployeeJobImporter;
use App\Filament\Resources\EmployeeJobResource;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeJobs extends ListRecords
{
    protected static string $resource = EmployeeJobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->icon('heroicon-o-arrow-up-tray')
                ->importer(EmployeeJobImporter::class),
            Actions\CreateAction::make(),
        ];
    }
}
