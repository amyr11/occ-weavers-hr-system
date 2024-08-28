<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveResource\Pages;

use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveResource;
use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveTable;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeLeaves extends ListRecords
{
    protected static string $resource = EmployeeLeaveResource::class;

    protected function getHeaderActions(): array
    {
        return EmployeeLeaveTable::getHeaderActions();
    }
}
