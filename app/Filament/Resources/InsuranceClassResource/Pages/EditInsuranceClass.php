<?php

namespace App\Filament\Resources\InsuranceClassResource\Pages;

use App\Filament\Resources\InsuranceClassResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInsuranceClass extends EditRecord
{
    protected static string $resource = InsuranceClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
