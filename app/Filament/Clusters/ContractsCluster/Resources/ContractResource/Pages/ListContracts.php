<?php

namespace App\Filament\Clusters\ContractsCluster\Resources\ContractResource\Pages;

use App\Filament\Clusters\ContractsCluster\Resources\ContractResource;
use App\Filament\Clusters\ContractsCluster\Resources\ContractTable;
use Filament\Resources\Pages\ListRecords;

class ListContracts extends ListRecords
{
    protected static string $resource = ContractResource::class;

    protected function getHeaderActions(): array
    {
        return ContractTable::getHeaderActions();
    }
}
