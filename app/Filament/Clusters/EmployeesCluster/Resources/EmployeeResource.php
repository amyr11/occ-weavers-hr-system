<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources;

use App\Filament\Clusters\EmployeesCluster;
use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeResource\Pages;
use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeTable;
use App\Models\Employee;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $navigationLabel = 'All';

    protected static ?int $navigationSort = 1;

    protected static ?string $cluster = EmployeesCluster::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema(EmployeeTable::getSchema());
    }

    public static function table(Table $table): Table
    {
        return EmployeeTable::getTable($table);
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
