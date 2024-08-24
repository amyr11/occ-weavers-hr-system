<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveOnVacationResource\Pages;

use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveOnVacationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployeeLeaveOnVacation extends CreateRecord
{
    protected static string $resource = EmployeeLeaveOnVacationResource::class;
}
