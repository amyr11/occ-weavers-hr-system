<?php

namespace App\Filament\Resources\EmployeeJobResource\Pages;

use App\Filament\Resources\EmployeeJobResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeJobs extends ListRecords
{
    protected static string $resource = EmployeeJobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
