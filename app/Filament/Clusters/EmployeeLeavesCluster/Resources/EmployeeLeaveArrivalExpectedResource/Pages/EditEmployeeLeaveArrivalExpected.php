<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveArrivalExpectedResource\Pages;

use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveArrivalExpectedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeLeaveArrivalExpected extends EditRecord
{
    protected static string $resource = EmployeeLeaveArrivalExpectedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
