<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveOnVacationResource\Pages;

use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveOnVacationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeLeaveOnVacations extends ListRecords
{
    protected static string $resource = EmployeeLeaveOnVacationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
