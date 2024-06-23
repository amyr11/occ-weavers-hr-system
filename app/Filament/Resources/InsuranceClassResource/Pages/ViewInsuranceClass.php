<?php

namespace App\Filament\Resources\InsuranceClassResource\Pages;

use App\Filament\Resources\InsuranceClassResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewInsuranceClass extends ViewRecord
{
    protected static string $resource = InsuranceClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
