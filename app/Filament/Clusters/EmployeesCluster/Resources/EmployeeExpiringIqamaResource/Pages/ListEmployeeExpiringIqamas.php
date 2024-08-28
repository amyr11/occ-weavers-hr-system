<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources\EmployeeExpiringIqamaResource\Pages;

use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeExpiringIqamaResource;
use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeTable;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeExpiringIqamas extends ListRecords
{
    protected static string $resource = EmployeeExpiringIqamaResource::class;

    protected function getHeaderActions(): array
    {
        return EmployeeTable::getHeaderActions();
    }
}
