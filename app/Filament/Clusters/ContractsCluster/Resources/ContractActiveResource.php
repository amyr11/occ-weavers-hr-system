<?php

namespace App\Filament\Clusters\ContractsCluster\Resources;

use App\Filament\Clusters\ContractsCluster;
use App\Filament\Clusters\ContractsCluster\Resources\ContractActiveResource\Pages;
use App\Models\Contract;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class ContractActiveResource extends Resource
{
    protected static ?string $model = Contract::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Active';

    protected static ?string $cluster = ContractsCluster::class;

    private static function getQuery()
    {
        return Contract::where('status', '=', 'Active');
    }

    public static function getNavigationBadge(): ?string
    {
        return self::getQuery()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(ContractTable::getSchema());
    }

    public static function table(Table $table): Table
    {
        $contractTable = new ContractTable();

        return ContractTable::getTable(
            $table,
            statusOptions: [],
            columns: [
                $contractTable->employee_number,
                $contractTable->employee_full_name,
                $contractTable->employeeJob_job_title,
                $contractTable->duration_in_years,
                $contractTable->status->toggledHiddenByDefault(),
                $contractTable->start_date,
                $contractTable->end_date,
                $contractTable->paper_contract_end_date,
                $contractTable->e_contract_exp_rem_days,
                $contractTable->p_contract_exp_rem_days,
                $contractTable->basic_salary,
                $contractTable->housing_allowance,
                $contractTable->transportation_allowance,
                $contractTable->food_allowance,
                $contractTable->remarks,
                $contractTable->file_link,
                $contractTable->created_at,
                $contractTable->updated_at,
            ],
        )
            ->query(self::getQuery());
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
            'index' => Pages\ListContractActives::route('/'),
            'create' => Pages\CreateContractActive::route('/create'),
            'view' => Pages\ViewContractActive::route('/{record}'),
            'edit' => Pages\EditContractActive::route('/{record}/edit'),
        ];
    }
}
