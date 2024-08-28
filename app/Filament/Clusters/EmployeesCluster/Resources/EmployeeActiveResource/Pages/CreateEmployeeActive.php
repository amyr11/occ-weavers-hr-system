<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources\EmployeeActiveResource\Pages;

use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeActiveResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployeeActive extends CreateRecord
{
    protected static string $resource = EmployeeActiveResource::class;
}
