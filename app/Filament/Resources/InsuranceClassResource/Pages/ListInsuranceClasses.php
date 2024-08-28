<?php

namespace App\Filament\Resources\InsuranceClassResource\Pages;

use App\Filament\Imports\InsuranceClassImporter;
use App\Filament\Resources\InsuranceClassResource;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListInsuranceClasses extends ListRecords
{
    protected static string $resource = InsuranceClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->icon('heroicon-o-arrow-up-tray')
                ->importer(InsuranceClassImporter::class),
            Actions\CreateAction::make(),
        ];
    }
}
