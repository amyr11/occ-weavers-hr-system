<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources\EmployeesClusterResource\RelationManagers;

use App\Filament\Clusters\BonusesCluster\Resources\BonusTable;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BonusesRelationManager extends RelationManager
{
    protected static string $relationship = 'bonuses';

    public function form(Form $form): Form
    {
        return $form
            ->schema(array_slice(BonusTable::getSchema(), 1));
    }

    public function table(Table $table): Table
    {
        return BonusTable::getTable($table)
            ->columns(array_slice(BonusTable::getColumns(), 2))
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
