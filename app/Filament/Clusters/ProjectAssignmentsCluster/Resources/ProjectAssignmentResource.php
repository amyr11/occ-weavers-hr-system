<?php

namespace App\Filament\Clusters\ProjectAssignmentsCluster\Resources;

use App\Filament\Clusters\ProjectAssignmentsCluster;
use App\Filament\Clusters\ProjectAssignmentsCluster\Resources\ProjectAssignmentResource\Pages;
use App\Models\ProjectAssignment;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class ProjectAssignmentResource extends Resource
{
    protected static ?string $model = ProjectAssignment::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $navigationLabel = 'All';

    protected static ?string $cluster = ProjectAssignmentsCluster::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema(ProjectAssignmentTable::getSchema());
    }

    public static function table(Table $table): Table
    {
        return ProjectAssignmentTable::getTable($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectAssignments::route('/'),
            'create' => Pages\CreateProjectAssignment::route('/create'),
            'view' => Pages\ViewProjectAssignment::route('/{record}'),
            'edit' => Pages\EditProjectAssignment::route('/{record}/edit'),
        ];
    }
}
