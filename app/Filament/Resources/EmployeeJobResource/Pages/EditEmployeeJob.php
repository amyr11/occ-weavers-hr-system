<?php

namespace App\Filament\Resources\EmployeeJobResource\Pages;

use App\Filament\Resources\EmployeeJobResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeJob extends EditRecord
{
    protected static string $resource = EmployeeJobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
