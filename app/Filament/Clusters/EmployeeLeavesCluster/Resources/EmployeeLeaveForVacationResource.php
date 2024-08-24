<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources;

use App\Filament\Clusters\EmployeeLeavesCluster;
use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveForVacationResource\Pages;
use App\Models\EmployeeLeave;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;

class EmployeeLeaveForVacationResource extends Resource
{
    protected static ?string $model = EmployeeLeave::class;

    protected static ?string $cluster = EmployeeLeavesCluster::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $navigationLabel = 'For Vacation';

    private static function getQuery()
    {
        return EmployeeLeave::where('status', '=', 'For vacation');
    }

    public static function getNavigationBadge(): ?string
    {
        return EmployeeLeaveForVacationResource::getQuery()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(EmployeeLeaveTable::getSchema());
    }

    public static function table(Table $table): Table
    {
        return EmployeeLeaveTable::getTable($table, statusOptions: [])
            ->query(EmployeeLeaveForVacationResource::getQuery());
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
            'index' => Pages\ListEmployeeLeaveForVacations::route('/'),
            'create' => Pages\CreateEmployeeLeaveForVacation::route('/create'),
            'view' => Pages\ViewEmployeeLeaveForVacation::route('/{record}'),
            'edit' => Pages\EditEmployeeLeaveForVacation::route('/{record}/edit'),
        ];
    }
}
