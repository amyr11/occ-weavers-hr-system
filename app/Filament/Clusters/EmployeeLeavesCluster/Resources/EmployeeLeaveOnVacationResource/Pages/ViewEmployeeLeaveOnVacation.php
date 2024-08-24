<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveOnVacationResource\Pages;

use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveOnVacationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEmployeeLeaveOnVacation extends ViewRecord
{
    protected static string $resource = EmployeeLeaveOnVacationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
