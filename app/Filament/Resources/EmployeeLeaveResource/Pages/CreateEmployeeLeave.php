<?php

namespace App\Filament\Resources\EmployeeLeaveResource\Pages;

use App\Filament\Resources\EmployeeLeaveResource;
use App\Models\Employee;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateEmployeeLeave extends CreateRecord
{
    protected static string $resource = EmployeeLeaveResource::class;
}
