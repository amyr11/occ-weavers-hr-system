<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveVisaExpiredResource\Pages;

use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveTable;
use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveVisaExpiredResource;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeLeaveVisaExpireds extends ListRecords
{
    protected static string $resource = EmployeeLeaveVisaExpiredResource::class;

    protected function getHeaderActions(): array
    {
        return EmployeeLeaveTable::getHeaderActions();
    }
}
