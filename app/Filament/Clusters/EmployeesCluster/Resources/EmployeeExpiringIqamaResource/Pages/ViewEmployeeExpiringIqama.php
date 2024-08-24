<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources\EmployeeExpiringIqamaResource\Pages;

use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeExpiringIqamaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEmployeeExpiringIqama extends ViewRecord
{
    protected static string $resource = EmployeeExpiringIqamaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
