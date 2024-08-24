<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources\EmployeeSeniorsResource\Pages;

use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeSeniorsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeSeniors extends ListRecords
{
    protected static string $resource = EmployeeSeniorsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
