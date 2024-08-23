<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources;

use App\Filament\Clusters\EmployeeLeavesCluster;
use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveIndividualResource\Pages;
use App\Models\EmployeeLeave;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Enums\ActionsPosition;

class EmployeeLeaveIndividualResource extends Resource
{
    protected static ?string $model = EmployeeLeave::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $cluster = EmployeeLeavesCluster::class;

    protected static ?string $navigationLabel = 'Unresolved';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(EmployeeLeaveTable::getSchema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query
                    ->latest('start_date')
                    ->where('status', '!=', 'Arrived (Resolved)')
                    ->where('status', '!=', 'Visa expired (Resolved)');
            })
            ->defaultGroup('status')
            ->columns(EmployeeLeaveTable::getColumns())
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ], position: ActionsPosition::BeforeColumns)
            ->bulkActions(EmployeeLeaveTable::getBulkActions());
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
            'index' => Pages\ListEmployeeLeaveIndividuals::route('/'),
            'create' => Pages\CreateEmployeeLeaveIndividual::route('/create'),
            'view' => Pages\ViewEmployeeLeaveIndividual::route('/{record}'),
            'edit' => Pages\EditEmployeeLeaveIndividual::route('/{record}/edit'),
        ];
    }
}
