<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources\EmployeeExpiringIqamaResource\Pages;

use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeExpiringIqamaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeExpiringIqama extends EditRecord
{
    protected static string $resource = EmployeeExpiringIqamaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
