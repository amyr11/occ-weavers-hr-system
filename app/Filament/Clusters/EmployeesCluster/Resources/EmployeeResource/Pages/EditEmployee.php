<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources\EmployeeResource\Pages;

use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployee extends EditRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
