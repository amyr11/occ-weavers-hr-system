<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources\EmployeeActiveResource\Pages;

use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeActiveResource;
use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeTable;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEmployeeActive extends ViewRecord
{
    protected static string $resource = EmployeeActiveResource::class;

    protected function getHeaderActions(): array
    {
        return EmployeeTable::getViewHeaderActions();
    }
}
