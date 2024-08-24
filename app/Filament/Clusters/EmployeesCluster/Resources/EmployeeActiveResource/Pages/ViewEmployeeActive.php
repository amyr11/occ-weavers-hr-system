<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources\EmployeeActiveResource\Pages;

use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeActiveResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEmployeeActive extends ViewRecord
{
    protected static string $resource = EmployeeActiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
