<?php

namespace App\Filament\Clusters\ContractsCluster\Resources\ContractActiveResource\Pages;

use App\Filament\Clusters\ContractsCluster\Resources\ContractActiveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContractActives extends ListRecords
{
    protected static string $resource = ContractActiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
