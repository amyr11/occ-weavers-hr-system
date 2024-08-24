<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveVisaExpiredResource\Pages;

use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveVisaExpiredResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEmployeeLeaveVisaExpired extends ViewRecord
{
    protected static string $resource = EmployeeLeaveVisaExpiredResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
