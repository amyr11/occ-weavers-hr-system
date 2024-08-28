<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources\EmployeeResource\Pages;

use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeResource;
use App\Filament\Imports\EmployeeImporter;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->icon('heroicon-o-arrow-up-tray')
                ->importer(EmployeeImporter::class),
            Actions\CreateAction::make(),
        ];
    }
}
