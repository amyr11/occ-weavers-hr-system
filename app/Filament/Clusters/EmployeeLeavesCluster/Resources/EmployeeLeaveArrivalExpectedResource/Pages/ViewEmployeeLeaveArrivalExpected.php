<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveArrivalExpectedResource\Pages;

use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveArrivalExpectedResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEmployeeLeaveArrivalExpected extends ViewRecord
{
    protected static string $resource = EmployeeLeaveArrivalExpectedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
