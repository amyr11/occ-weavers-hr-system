<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources\EmployeeSeniorsResource\Pages;

use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeSeniorsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployeeSeniors extends CreateRecord
{
    protected static string $resource = EmployeeSeniorsResource::class;
}
