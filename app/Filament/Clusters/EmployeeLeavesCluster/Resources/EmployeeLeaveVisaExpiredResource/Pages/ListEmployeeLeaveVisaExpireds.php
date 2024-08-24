<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveVisaExpiredResource\Pages;

use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveVisaExpiredResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeLeaveVisaExpireds extends ListRecords
{
    protected static string $resource = EmployeeLeaveVisaExpiredResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
