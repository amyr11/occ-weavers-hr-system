<?php

namespace App\Filament\Clusters\ContractsCluster\Resources\ContractActiveResource\Pages;

use App\Filament\Clusters\ContractsCluster\Resources\ContractActiveResource;
use App\Filament\Clusters\ContractsCluster\Resources\ContractTable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContractActives extends ListRecords
{
    protected static string $resource = ContractActiveResource::class;

    protected function getHeaderActions(): array
    {
        return ContractTable::getHeaderActions();
    }
}
