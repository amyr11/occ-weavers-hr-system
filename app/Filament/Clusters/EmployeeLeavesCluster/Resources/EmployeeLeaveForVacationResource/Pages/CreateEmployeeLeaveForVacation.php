<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveForVacationResource\Pages;

use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveForVacationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployeeLeaveForVacation extends CreateRecord
{
    protected static string $resource = EmployeeLeaveForVacationResource::class;
}
