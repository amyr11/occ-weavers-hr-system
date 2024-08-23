<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources;

use App\Filament\Clusters\EmployeeLeavesCluster;
use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveIndividualResource\Pages;
use App\Models\EmployeeLeave;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;

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
            ->searchOnBlur()
            ->modifyQueryUsing(function (Builder $query) {
                return $query
                    ->latest('start_date')
                    ->where('status', '!=', 'Arrived (Resolved)')
                    ->where('status', '!=', 'Visa expired (Resolved)');
            })
            ->defaultGroup('status')
            ->columns(EmployeeLeaveTable::getColumns())
            ->filtersFormWidth(MaxWidth::TwoExtraLarge)
            ->filters(EmployeeLeaveTable::getFilters(), layout: FiltersLayout::Modal)
            ->actions(EmployeeLeaveTable::getActions(), position: ActionsPosition::BeforeColumns)
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
