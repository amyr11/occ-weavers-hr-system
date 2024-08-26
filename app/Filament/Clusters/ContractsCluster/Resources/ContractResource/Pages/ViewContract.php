<?php

namespace App\Filament\Clusters\ContractsCluster\Resources\ContractResource\Pages;

use App\Filament\Clusters\ContractsCluster\Resources\ContractResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContract extends ViewRecord
{
    protected static string $resource = ContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
