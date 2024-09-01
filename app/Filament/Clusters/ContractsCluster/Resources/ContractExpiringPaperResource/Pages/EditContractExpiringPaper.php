<?php

namespace App\Filament\Clusters\ContractsCluster\Resources\ContractExpiringPaperResource\Pages;

use App\Filament\Clusters\ContractsCluster\Resources\ContractExpiringPaperResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContractExpiringPaper extends EditRecord
{
    protected static string $resource = ContractExpiringPaperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
