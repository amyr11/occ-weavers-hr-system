<?php

namespace App\Filament\Clusters\ContractsCluster\Resources\ContractUpcomingResource\Pages;

use App\Filament\Clusters\ContractsCluster\Resources\ContractUpcomingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContractUpcomings extends ListRecords
{
    protected static string $resource = ContractUpcomingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
