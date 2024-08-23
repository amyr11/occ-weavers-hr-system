<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources;

use App\Filament\Clusters\EmployeeLeavesCluster;
use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveTable;
use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveResource\Pages;
use App\Models\EmployeeLeave;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Filament\Pages\SubNavigationPosition;

class EmployeeLeaveResource extends Resource
{
    protected static ?string $model = EmployeeLeave::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $navigationLabel = 'All';

    protected static ?string $cluster = EmployeeLeavesCluster::class;

    public static function form(Form $form): Form
    {
        return $form->schema(EmployeeLeaveTable::getSchema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->searchOnBlur()
            ->defaultSort('start_date', 'desc')
            ->columns(EmployeeLeaveTable::getColumns())
            ->filters(EmployeeLeaveTable::getFilters(), layout: FiltersLayout::Modal)
            ->filtersFormWidth(MaxWidth::TwoExtraLarge)
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
            'index' => Pages\ListEmployeeLeaves::route('/'),
            'create' => Pages\CreateEmployeeLeave::route('/create'),
            'view' => Pages\ViewEmployeeLeave::route('/{record}'),
            'edit' => Pages\EditEmployeeLeave::route('/{record}/edit'),
        ];
    }
}
