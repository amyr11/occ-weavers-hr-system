<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources\EmployeeSeniorsResource\Pages;

use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeSeniorsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeSeniors extends EditRecord
{
    protected static string $resource = EmployeeSeniorsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
