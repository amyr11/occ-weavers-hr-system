<?php

namespace App\Filament\Clusters\ContractsCluster\Resources\ContractActiveResource\Pages;

use App\Filament\Clusters\ContractsCluster\Resources\ContractActiveResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContractActive extends ViewRecord
{
    protected static string $resource = ContractActiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
