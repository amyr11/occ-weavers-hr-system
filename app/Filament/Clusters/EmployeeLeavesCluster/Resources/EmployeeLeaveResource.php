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

    protected static ?int $navigationSort = 0;

    protected static ?string $cluster = EmployeeLeavesCluster::class;

    public static function form(Form $form): Form
    {
        return $form->schema(EmployeeLeaveTable::getSchema());
    }

    public static function table(Table $table): Table
    {
        $employeeLeaveTable = new EmployeeLeaveTable();
        return EmployeeLeaveTable::getTable(
            $table,
            columns: [
                $employeeLeaveTable->employee_number,
                $employeeLeaveTable->employee_full_name,
                $employeeLeaveTable->contact_number,
                $employeeLeaveTable->status->toggledHiddenByDefault(false),
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
            ]
        )->defaultSort('start_date', 'desc');
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
