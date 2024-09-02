<?php

namespace App\Filament\Clusters\ContractsCluster\Resources\ContractExpiredBothResource\Pages;

use App\Filament\Clusters\ContractsCluster\Resources\ContractExpiredBothResource;
use App\Filament\Clusters\ContractsCluster\Resources\ContractTable;
use Filament\Resources\Pages\ListRecords;

class ListContractExpiredBoths extends ListRecords
{
    protected static string $resource = ContractExpiredBothResource::class;

    protected function getHeaderActions(): array
    {
        return ContractTable::getHeaderActions();
    }
}
