<?php

namespace App\Filament\Clusters\ContractsCluster\Resources\ContractExpiredBothResource\Pages;

use App\Filament\Clusters\ContractsCluster\Resources\ContractExpiredBothResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContractExpiredBoth extends ViewRecord
{
    protected static string $resource = ContractExpiredBothResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
