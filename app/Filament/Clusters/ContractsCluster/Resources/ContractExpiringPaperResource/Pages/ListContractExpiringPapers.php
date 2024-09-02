<?php

namespace App\Filament\Clusters\ContractsCluster\Resources\ContractExpiringPaperResource\Pages;

use App\Filament\Clusters\ContractsCluster\Resources\ContractExpiringPaperResource;
use App\Filament\Clusters\ContractsCluster\Resources\ContractTable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContractExpiringPapers extends ListRecords
{
    protected static string $resource = ContractExpiringPaperResource::class;

    protected function getHeaderActions(): array
    {
        return ContractTable::getHeaderActions();
    }
}
