<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources\EmployeeSeniorsResource\Pages;

use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeSeniorsResource;
use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeTable;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeSeniors extends ListRecords
{
    protected static string $resource = EmployeeSeniorsResource::class;

    protected function getHeaderActions(): array
    {
        return EmployeeTable::getHeaderActions();
    }
}
