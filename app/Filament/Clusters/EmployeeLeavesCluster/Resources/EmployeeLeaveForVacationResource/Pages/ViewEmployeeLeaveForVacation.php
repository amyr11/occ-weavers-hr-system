<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveForVacationResource\Pages;

use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveForVacationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEmployeeLeaveForVacation extends ViewRecord
{
    protected static string $resource = EmployeeLeaveForVacationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
