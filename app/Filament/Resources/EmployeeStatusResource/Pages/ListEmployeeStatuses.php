<?php

namespace App\Filament\Resources\EmployeeStatusResource\Pages;

use App\Filament\Resources\EmployeeStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeStatuses extends ListRecords
{
    protected static string $resource = EmployeeStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
