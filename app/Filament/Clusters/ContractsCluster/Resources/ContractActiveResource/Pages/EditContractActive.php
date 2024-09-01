<?php

namespace App\Filament\Clusters\ContractsCluster\Resources\ContractActiveResource\Pages;

use App\Filament\Clusters\ContractsCluster\Resources\ContractActiveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContractActive extends EditRecord
{
    protected static string $resource = ContractActiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
