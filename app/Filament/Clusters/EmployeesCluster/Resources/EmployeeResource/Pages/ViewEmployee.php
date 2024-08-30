<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources\EmployeeResource\Pages;

use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeResource;
use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeTable;
use App\Models\Employee;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEmployee extends ViewRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return EmployeeTable::getViewHeaderActions();
    }
}
