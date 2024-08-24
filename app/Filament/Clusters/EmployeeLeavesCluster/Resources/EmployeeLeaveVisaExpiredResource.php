<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources;

use App\Filament\Clusters\EmployeeLeavesCluster;
use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveVisaExpiredResource\Pages;
use App\Models\EmployeeLeave;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;

class EmployeeLeaveVisaExpiredResource extends Resource
{
    protected static ?string $model = EmployeeLeave::class;

    protected static ?string $cluster = EmployeeLeavesCluster::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $navigationLabel = 'Visa Expired';

    private static function getQuery()
    {
        return EmployeeLeave::where('status', '=', 'Visa expired');
    }

    public static function getNavigationBadge(): ?string
    {
        return EmployeeLeaveVisaExpiredResource::getQuery()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(EmployeeLeaveTable::getSchema());
    }

    public static function table(Table $table): Table
    {
        return EmployeeLeaveTable::getTable($table, statusOptions: [])
            ->query(EmployeeLeaveVisaExpiredResource::getQuery());
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
            'index' => Pages\ListEmployeeLeaveVisaExpireds::route('/'),
            'create' => Pages\CreateEmployeeLeaveVisaExpired::route('/create'),
            'view' => Pages\ViewEmployeeLeaveVisaExpired::route('/{record}'),
            'edit' => Pages\EditEmployeeLeaveVisaExpired::route('/{record}/edit'),
        ];
    }
}
