<?php

namespace App\Filament\Resources\DegreeResource\Pages;

use App\Filament\Imports\DegreeImporter;
use App\Filament\Resources\DegreeResource;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListDegrees extends ListRecords
{
    protected static string $resource = DegreeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->icon('heroicon-o-arrow-up-tray')
                ->importer(DegreeImporter::class),
            Actions\CreateAction::make(),
        ];
    }
}
