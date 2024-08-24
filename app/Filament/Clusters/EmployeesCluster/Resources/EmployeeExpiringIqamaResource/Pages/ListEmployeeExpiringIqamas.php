<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources\EmployeeExpiringIqamaResource\Pages;

use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeExpiringIqamaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeExpiringIqamas extends ListRecords
{
    protected static string $resource = EmployeeExpiringIqamaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
