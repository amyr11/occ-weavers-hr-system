<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveForVacationResource\Pages;

use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveForVacationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeLeaveForVacations extends ListRecords
{
    protected static string $resource = EmployeeLeaveForVacationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
