<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources;

use App\Filament\Clusters\EmployeesCluster;
use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeSeniorsResource\Pages;
use App\Models\Employee;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EmployeeSeniorsResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $navigationLabel = '60 Years and Above';

    protected static ?string $cluster = EmployeesCluster::class;

    private static function getQuery()
    {
        return Employee::where('age', '>=', 60)->where('status', '=', 'Active');
    }

    public static function getNavigationBadge(): ?string
    {
        return EmployeeSeniorsResource::getQuery()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'info';
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
                $employeeTable->age,
                $employeeTable->employeeJob_job_title,
                $employeeTable->iqama_job_title,
                $employeeTable->project_project_name,
                $employeeTable->iqama_expiration_hijri,
                $employeeTable->iqama_expiration_gregorian,
                $employeeTable->iqama_number,
                $employeeTable->electronic_contract_start_date,
                $employeeTable->electronic_contract_end_date,
                $employeeTable->paper_contract_start_date,
                $employeeTable->paper_contract_end_date,
                $employeeTable->country_name->toggledHiddenByDefault(),
                $employeeTable->email->toggledHiddenByDefault(),
                $employeeTable->mobile_number->toggledHiddenByDefault(),
                $employeeTable->labor_office_number->toggledHiddenByDefault(),
                $employeeTable->iban_number->toggledHiddenByDefault(),
                $employeeTable->passport_number->toggledHiddenByDefault(),
                $employeeTable->passport_date_issue->toggledHiddenByDefault(),
                $employeeTable->passport_expiration->toggledHiddenByDefault(),
                $employeeTable->sce_expiration->toggledHiddenByDefault(),
                $employeeTable->insuranceClass_name->toggledHiddenByDefault(),
                $employeeTable->company_start_date->toggledHiddenByDefault(),
                $employeeTable->final_exit_date->toggledHiddenByDefault(),
                $employeeTable->visa_expired_date->toggledHiddenByDefault(),
                $employeeTable->transferred_date->toggledHiddenByDefault(),
                $employeeTable->created_at,
                $employeeTable->updated_at,
            ],
        )
            ->query(EmployeeSeniorsResource::getQuery())
            ->defaultSort('age');
    }

    public static function getRelations(): array
    {
        return EmployeeTable::getRelations();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployeeSeniors::route('/'),
            'create' => Pages\CreateEmployeeSeniors::route('/create'),
            'view' => Pages\ViewEmployeeSeniors::route('/{record}'),
            'edit' => Pages\EditEmployeeSeniors::route('/{record}/edit'),
        ];
    }
}
