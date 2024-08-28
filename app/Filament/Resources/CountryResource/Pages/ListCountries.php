<?php

namespace App\Filament\Resources\CountryResource\Pages;

use App\Filament\Imports\CountryImporter;
use App\Filament\Resources\CountryResource;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListCountries extends ListRecords
{
    protected static string $resource = CountryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->icon('heroicon-o-arrow-up-tray')
                ->importer(CountryImporter::class),
            Actions\CreateAction::make(),
        ];
    }
}
