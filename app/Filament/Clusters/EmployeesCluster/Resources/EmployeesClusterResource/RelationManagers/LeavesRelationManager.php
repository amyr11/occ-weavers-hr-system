<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources\EmployeesClusterResource\RelationManagers;

use App\Filament\Clusters\EmployeeLeavesCluster\Resources\EmployeeLeaveTable;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeavesRelationManager extends RelationManager
{
    protected static string $relationship = 'leaves';

    public function form(Form $form): Form
    {
        return $form
            ->schema(array_merge(array_slice(EmployeeLeaveTable::getSchema(), 2), [
                Forms\Components\TextInput::make('contact_number')
                    ->label('Contact number')
                    ->maxLength(255),
            ]));
    }

    public function table(Table $table): Table
    {
        $employeeLeaveTable = new EmployeeLeaveTable();
        return EmployeeLeaveTable::getTable(
            $table,
            columns: [
                $employeeLeaveTable->status->toggledHiddenByDefault(false),
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
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
