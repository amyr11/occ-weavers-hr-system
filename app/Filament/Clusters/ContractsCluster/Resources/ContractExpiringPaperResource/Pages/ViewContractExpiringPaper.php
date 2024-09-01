<?php

namespace App\Filament\Clusters\ContractsCluster\Resources\ContractExpiringPaperResource\Pages;

use App\Filament\Clusters\ContractsCluster\Resources\ContractExpiringPaperResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContractExpiringPaper extends ViewRecord
{
    protected static string $resource = ContractExpiringPaperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
