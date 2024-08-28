<?php

namespace App\Filament\Resources\EducationLevelResource\Pages;

use App\Filament\Imports\EducationLevelImporter;
use App\Filament\Resources\EducationLevelResource;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListEducationLevels extends ListRecords
{
    protected static string $resource = EducationLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->icon('heroicon-o-arrow-up-tray')
                ->importer(EducationLevelImporter::class),
            Actions\CreateAction::make(),
        ];
    }
}
