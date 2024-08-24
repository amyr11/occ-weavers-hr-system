<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources\EmployeeResource\Pages;

use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;
}
