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
        return self::getQuery()->count();
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
        $employeeLeaveTable = new EmployeeLeaveTable();

        return EmployeeLeaveTable::getTable(
            $table,
            statusOptions: [],
            columns: [
                $employeeLeaveTable->employee_number,
                $employeeLeaveTable->employee_full_name,
                $employeeLeaveTable->arrived->toggledHiddenByDefault(false),
                $employeeLeaveTable->visa_expired,
                $employeeLeaveTable->status,
                $employeeLeaveTable->contact_number,
                $employeeLeaveTable->start_date,
                $employeeLeaveTable->end_date,
                $employeeLeaveTable->duration_in_days,
                $employeeLeaveTable->remaining_leave_days,
                $employeeLeaveTable->visa_expiration,
                $employeeLeaveTable->visa_duration_in_days,
                $employeeLeaveTable->visa_remaining_days,
                $employeeLeaveTable->request_file_link,
                $employeeLeaveTable->created_at,
                $employeeLeaveTable->updated_at,
            ],
        )
            ->query(self::getQuery())
            ->defaultsort('leave_remaining_days', 'asc');
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
