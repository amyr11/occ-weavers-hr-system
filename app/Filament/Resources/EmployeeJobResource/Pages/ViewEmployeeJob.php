<?php

namespace App\Filament\Resources\EmployeeJobResource\Pages;

use App\Filament\Resources\EmployeeJobResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEmployeeJob extends ViewRecord
{
    protected static string $resource = EmployeeJobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
