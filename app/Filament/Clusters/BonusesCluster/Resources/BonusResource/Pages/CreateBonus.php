<?php

namespace App\Filament\Clusters\BonusesCluster\Resources\BonusResource\Pages;

use App\Filament\Clusters\BonusesCluster\Resources\BonusResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBonus extends CreateRecord
{
    protected static string $resource = BonusResource::class;
}
