<?php

namespace App\Filament\Clusters\ContractsCluster\Resources\ContractExpiringElectronicResource\Pages;

use App\Filament\Clusters\ContractsCluster\Resources\ContractExpiringElectronicResource;
use App\Filament\Clusters\ContractsCluster\Resources\ContractTable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContractExpiringElectronics extends ListRecords
{
    protected static string $resource = ContractExpiringElectronicResource::class;

    protected function getHeaderActions(): array
    {
        return ContractTable::getHeaderActions();
    }
}
