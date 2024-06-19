<?php

namespace App\Filament\Resources\EmployeeStatusResource\Pages;

use App\Filament\Resources\EmployeeStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeStatus extends EditRecord
{
    protected static string $resource = EmployeeStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
