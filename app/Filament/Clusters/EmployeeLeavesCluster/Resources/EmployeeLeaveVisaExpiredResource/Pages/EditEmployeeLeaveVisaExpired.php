<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveVisaExpiredResource\Pages;

use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveVisaExpiredResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeLeaveVisaExpired extends EditRecord
{
    protected static string $resource = EmployeeLeaveVisaExpiredResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
