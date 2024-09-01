<?php

namespace App\Filament\Clusters\ContractsCluster\Resources\ContractExpiringPaperResource\Pages;

use App\Filament\Clusters\ContractsCluster\Resources\ContractExpiringPaperResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContractExpiringPaper extends CreateRecord
{
    protected static string $resource = ContractExpiringPaperResource::class;
}
