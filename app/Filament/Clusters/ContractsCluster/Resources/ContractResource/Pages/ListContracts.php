<?php

namespace App\Filament\Clusters\ContractsCluster\Resources\ContractResource\Pages;

use App\Filament\Clusters\ContractsCluster\Resources\ContractResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContracts extends ListRecords
{
    protected static string $resource = ContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
