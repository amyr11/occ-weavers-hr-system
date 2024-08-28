<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources\EmployeeActiveResource\Pages;

use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeActiveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeActive extends EditRecord
{
    protected static string $resource = EmployeeActiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
