<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveArrivalExpectedResource\Pages;

use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveArrivalExpectedResource;
use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveTable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeLeaveArrivalExpecteds extends ListRecords
{
    protected static string $resource = EmployeeLeaveArrivalExpectedResource::class;

    protected function getHeaderActions(): array
    {
        return EmployeeLeaveTable::getHeaderActions();
    }
}
