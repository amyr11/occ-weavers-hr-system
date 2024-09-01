<?php

namespace App\Filament\Clusters\ContractsCluster\Resources\ContractExpiringElectronicResource\Pages;

use App\Filament\Clusters\ContractsCluster\Resources\ContractExpiringElectronicResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContractExpiringElectronic extends ViewRecord
{
    protected static string $resource = ContractExpiringElectronicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
