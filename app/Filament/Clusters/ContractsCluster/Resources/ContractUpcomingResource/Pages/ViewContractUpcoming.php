<?php

namespace App\Filament\Clusters\ContractsCluster\Resources\ContractUpcomingResource\Pages;

use App\Filament\Clusters\ContractsCluster\Resources\ContractUpcomingResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContractUpcoming extends ViewRecord
{
    protected static string $resource = ContractUpcomingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
