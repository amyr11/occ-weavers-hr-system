<?php

namespace App\Filament\Clusters\BonusesCluster\Resources\BonusResource\Pages;

use App\Filament\Clusters\BonusesCluster\Resources\BonusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBonus extends EditRecord
{
    protected static string $resource = BonusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
