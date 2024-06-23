<?php

namespace App\Filament\Resources\InsuranceClassResource\Pages;

use App\Filament\Resources\InsuranceClassResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInsuranceClasses extends ListRecords
{
    protected static string $resource = InsuranceClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
