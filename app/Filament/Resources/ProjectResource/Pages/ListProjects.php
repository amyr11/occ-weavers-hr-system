<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Imports\ProjectImporter;
use App\Filament\Resources\ProjectResource;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->icon('heroicon-o-arrow-up-tray')
                ->importer(ProjectImporter::class),
            Actions\CreateAction::make(),
        ];
    }
}
