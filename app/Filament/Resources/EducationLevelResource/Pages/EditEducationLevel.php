<?php

namespace App\Filament\Resources\EducationLevelResource\Pages;

use App\Filament\Resources\EducationLevelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEducationLevel extends EditRecord
{
    protected static string $resource = EducationLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
