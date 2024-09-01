<?php

namespace App\Filament\Clusters\ContractsCluster\Resources\ContractExpiringElectronicResource\Pages;

use App\Filament\Clusters\ContractsCluster\Resources\ContractExpiringElectronicResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContractExpiringElectronic extends EditRecord
{
    protected static string $resource = ContractExpiringElectronicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
