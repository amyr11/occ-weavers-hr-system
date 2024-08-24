<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources;

use App\Filament\Clusters\EmployeeLeavesCluster;
use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveArrivalExpectedResource\Pages;
use App\Models\EmployeeLeave;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;

class EmployeeLeaveArrivalExpectedResource extends Resource
{
    protected static ?string $model = EmployeeLeave::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $navigationLabel = 'Arrival Expected';

    protected static ?string $cluster = EmployeeLeavesCluster::class;

    private static function getQuery()
    {
        return EmployeeLeave::where('status', '=', 'Arrival expected');
    }

    public static function getNavigationBadge(): ?string
    {
        return EmployeeLeaveArrivalExpectedResource::getQuery()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'info';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(EmployeeLeaveTable::getSchema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(EmployeeLeaveArrivalExpectedResource::getQuery())
            ->searchOnBlur()
            ->defaultSort('start_date', 'desc')
            ->columns(EmployeeLeaveTable::getColumns())
            ->filters(EmployeeLeaveTable::getFilters(statusOptions: []), layout: FiltersLayout::Modal)
            ->filtersFormWidth(MaxWidth::TwoExtraLarge)
            ->actions(EmployeeLeaveTable::getActions())
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
            'index' => Pages\ListEmployeeLeaveArrivalExpecteds::route('/'),
            'create' => Pages\CreateEmployeeLeaveArrivalExpected::route('/create'),
            'view' => Pages\ViewEmployeeLeaveArrivalExpected::route('/{record}'),
            'edit' => Pages\EditEmployeeLeaveArrivalExpected::route('/{record}/edit'),
        ];
    }
}
