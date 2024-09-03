<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources;

use App\Filament\Clusters\EmployeesCluster;
use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeActiveResource\Pages;
use App\Models\Employee;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EmployeeActiveResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $navigationLabel = 'Active';

    protected static ?string $cluster = EmployeesCluster::class;

    private static function getQuery()
    {
        return Employee::where('status', '=', 'Active');
    }

    public static function getNavigationBadge(): ?string
    {
        return EmployeeActiveResource::getQuery()->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(EmployeeTable::getSchema());
    }

    public static function table(Table $table): Table
    {
        $employeeTable = new EmployeeTable();
        return EmployeeTable::getTable(
            $table,
            columns: [
                $employeeTable->employee_number,
                $employeeTable->full_name,
                $employeeTable->status->toggledHiddenByDefault(),
                $employeeTable->employeeJob_job_title,
                $employeeTable->project_project_name,
                $employeeTable->country_name,
                $employeeTable->age,
                $employeeTable->email,
                $employeeTable->educationLevel_level,
                $employeeTable->degree_degree,
                $employeeTable->college_graduation_date,
                $employeeTable->mobile_number,
                $employeeTable->labor_office_number,
                $employeeTable->iban_number,
                $employeeTable->iqama_number,
                $employeeTable->iqama_job_title,
                $employeeTable->iqama_expiration_hijri,
                $employeeTable->iqama_expiration_gregorian,
                $employeeTable->iqama_expiration_remaining_days,
                $employeeTable->passport_number,
                $employeeTable->passport_date_issue,
                $employeeTable->passport_expiration,
                $employeeTable->sce_expiration,
                $employeeTable->insuranceClass_name,
                $employeeTable->company_start_date,
                $employeeTable->electronic_contract_start_date,
                $employeeTable->electronic_contract_end_date,
                $employeeTable->paper_contract_start_date,
                $employeeTable->paper_contract_end_date,
                $employeeTable->final_exit_date,
                $employeeTable->visa_expired_date,
                $employeeTable->transferred_date,
                $employeeTable->created_at,
                $employeeTable->updated_at,
            ],
        )
            ->query(EmployeeActiveResource::getQuery());
    }

    public static function getRelations(): array
    {
        return EmployeeTable::getRelations();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployeeActives::route('/'),
            'create' => Pages\CreateEmployeeActive::route('/create'),
            'view' => Pages\ViewEmployeeActive::route('/{record}'),
            'edit' => Pages\EditEmployeeActive::route('/{record}/edit'),
        ];
    }
}
