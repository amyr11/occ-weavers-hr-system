<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources\EmployeesClusterResource\RelationManagers;

use App\Filament\Clusters\ContractsCluster\Resources\ContractTable;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ContractsRelationManager extends RelationManager
{
    protected static string $relationship = 'contracts';

    public function form(Form $form): Form
    {
        return $form
            ->schema(array_slice(ContractTable::getSchema(), 1));
    }

    public function table(Table $table): Table
    {
        return ContractTable::getTable($table)
            ->columns(array_slice(ContractTable::getColumns(), 2))
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
