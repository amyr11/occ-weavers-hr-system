<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources\EmployeeSeniorsResource\Pages;

use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeSeniorsResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEmployeeSeniors extends ViewRecord
{
    protected static string $resource = EmployeeSeniorsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
