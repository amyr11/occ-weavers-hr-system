<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveForVacationResource\Pages;

use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveForVacationResource;
use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveTable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeLeaveForVacations extends ListRecords
{
    protected static string $resource = EmployeeLeaveForVacationResource::class;

    protected function getHeaderActions(): array
    {
        return EmployeeLeaveTable::getHeaderActions();
    }
}
