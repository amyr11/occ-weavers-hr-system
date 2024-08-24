<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveForVacationResource\Pages;

use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveForVacationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeLeaveForVacation extends EditRecord
{
    protected static string $resource = EmployeeLeaveForVacationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
