<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources;

use App\Filament\Clusters\EmployeesCluster;
use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeExpiringIqamaResource\Pages;
use App\Models\Employee;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Pluralizer;

class EmployeeExpiringIqamaResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $navigationLabel = 'Expiring IQAMA';

    protected static ?string $cluster = EmployeesCluster::class;

    private static function getQuery()
    {
        // 1 month before expiration
        return Employee::where('iqama_expiration_gregorian', '<=', now()->addMonths(3))->where('status', '=', 'Active');
    }

    public static function getNavigationBadge(): ?string
    {
        return EmployeeExpiringIqamaResource::getQuery()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
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
                $employeeTable->iqama_expiration_hijri,
                $employeeTable->iqama_expiration_gregorian,
                $employeeTable->iqama_expiration_remaining_days
                    ->toggledHiddenByDefault(false),
                $employeeTable->iqama_number,
                $employeeTable->employeeJob_job_title,
                $employeeTable->iqama_job_title,
                $employeeTable->project_project_name,
                $employeeTable->electronic_contract_start_date,
                $employeeTable->electronic_contract_end_date,
                $employeeTable->paper_contract_end_date,
                $employeeTable->country_name->toggledHiddenByDefault(),
                $employeeTable->age->toggledHiddenByDefault(),
                $employeeTable->email->toggledHiddenByDefault(),
                $employeeTable->educationLevel_level->toggledHiddenByDefault(),
                $employeeTable->degree_degree->toggledHiddenByDefault(),
                $employeeTable->college_graduation_date->toggledHiddenByDefault(),
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
                $employeeTable->max_leave_days->toggledHiddenByDefault(),
                $employeeTable->current_leave_days->toggledHiddenByDefault(),
                $employeeTable->created_at,
                $employeeTable->updated_at,
            ],
        )
            ->query(EmployeeExpiringIqamaResource::getQuery())
            ->defaultsort('iqama_expiration_gregorian', 'asc');
    }

    public static function getRelations(): array
    {
        return EmployeeTable::getRelations();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployeeExpiringIqamas::route('/'),
            'create' => Pages\CreateEmployeeExpiringIqama::route('/create'),
            'view' => Pages\ViewEmployeeExpiringIqama::route('/{record}'),
            'edit' => Pages\EditEmployeeExpiringIqama::route('/{record}/edit'),
        ];
    }
}
