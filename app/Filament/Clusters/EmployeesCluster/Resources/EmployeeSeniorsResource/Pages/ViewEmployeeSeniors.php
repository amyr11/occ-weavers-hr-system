<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources\EmployeeSeniorsResource\Pages;

use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeSeniorsResource;
use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeTable;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEmployeeSeniors extends ViewRecord
{
    protected static string $resource = EmployeeSeniorsResource::class;

    protected function getHeaderActions(): array
    {
        return EmployeeTable::getViewHeaderActions();
    }
}
