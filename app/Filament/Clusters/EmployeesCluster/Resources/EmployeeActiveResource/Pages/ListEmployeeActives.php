<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources\EmployeeActiveResource\Pages;

use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeActiveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeActives extends ListRecords
{
    protected static string $resource = EmployeeActiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
