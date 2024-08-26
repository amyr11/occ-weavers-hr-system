<?php

namespace App\Filament\Clusters\ContractsCluster\Resources\ContractResource\Pages;

use App\Filament\Clusters\ContractsCluster\Resources\ContractResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContract extends EditRecord
{
    protected static string $resource = ContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
