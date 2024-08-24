<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveOnVacationResource\Pages;

use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveOnVacationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeLeaveOnVacation extends EditRecord
{
    protected static string $resource = EmployeeLeaveOnVacationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
