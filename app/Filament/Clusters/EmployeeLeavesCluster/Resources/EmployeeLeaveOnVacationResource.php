<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources;

use App\Filament\Clusters\EmployeeLeavesCluster;
use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveOnVacationResource\Pages;
use App\Models\EmployeeLeave;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;

class EmployeeLeaveOnVacationResource extends Resource
{
    protected static ?string $model = EmployeeLeave::class;

    protected static ?string $cluster = EmployeeLeavesCluster::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $navigationLabel = 'On Vacation';

    private static function getQuery()
    {
        return EmployeeLeave::where('status', '=', 'On vacation');
    }

    public static function getNavigationBadge(): ?string
    {
        return EmployeeLeaveOnVacationResource::getQuery()->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(EmployeeLeaveTable::getSchema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(EmployeeLeaveOnVacationResource::getQuery())
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
            'index' => Pages\ListEmployeeLeaveOnVacations::route('/'),
            'create' => Pages\CreateEmployeeLeaveOnVacation::route('/create'),
            'view' => Pages\ViewEmployeeLeaveOnVacation::route('/{record}'),
            'edit' => Pages\EditEmployeeLeaveOnVacation::route('/{record}/edit'),
        ];
    }
}
