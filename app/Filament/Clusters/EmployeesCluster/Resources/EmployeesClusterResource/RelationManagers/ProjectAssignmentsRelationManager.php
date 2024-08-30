<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources\EmployeesClusterResource\RelationManagers;

use App\Filament\Clusters\ProjectAssignmentsCluster\Resources\ProjectAssignmentTable;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectAssignmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'projectAssignments';

    public function form(Form $form): Form
    {
        return $form
            ->schema(array_slice(ProjectAssignmentTable::getSchema(), 1));
    }

    public function table(Table $table): Table
    {
        return ProjectAssignmentTable::getTable($table)
            ->columns(array_slice(ProjectAssignmentTable::getColumns(), 2))
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
