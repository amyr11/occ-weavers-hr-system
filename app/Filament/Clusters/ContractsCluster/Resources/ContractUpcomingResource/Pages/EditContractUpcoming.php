<?php

namespace App\Filament\Clusters\ContractsCluster\Resources\ContractUpcomingResource\Pages;

use App\Filament\Clusters\ContractsCluster\Resources\ContractUpcomingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContractUpcoming extends EditRecord
{
    protected static string $resource = ContractUpcomingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
