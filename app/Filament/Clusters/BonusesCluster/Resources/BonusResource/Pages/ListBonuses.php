<?php

namespace App\Filament\Clusters\BonusesCluster\Resources\BonusResource\Pages;

use App\Filament\Clusters\BonusesCluster\Resources\BonusResource;
use App\Filament\Clusters\BonusesCluster\Resources\BonusTable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBonuses extends ListRecords
{
    protected static string $resource = BonusResource::class;

    protected function getHeaderActions(): array
    {
        return BonusTable::getHeaderActions();
    }
}
