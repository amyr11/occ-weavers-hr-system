<?php

namespace App\Filament\Clusters\ContractsCluster\Resources\ContractExpiredBothResource\Pages;

use App\Filament\Clusters\ContractsCluster\Resources\ContractExpiredBothResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContractExpiredBoth extends EditRecord
{
    protected static string $resource = ContractExpiredBothResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
