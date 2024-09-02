<?php

namespace App\Filament\Clusters\ContractsCluster\Resources;

use App\Filament\Clusters\ContractsCluster;
use App\Filament\Clusters\ContractsCluster\Resources\ContractExpiredBothResource\Pages;
use App\Models\Contract;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class ContractExpiredBothResource extends Resource
{
    protected static ?string $model = Contract::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'Expired (Both)';

    protected static ?string $cluster = ContractsCluster::class;

    private static function getQuery()
    {
        return Contract::where('status', '=', 'Expired (Both)');
    }

    public static function getNavigationBadge(): ?string
    {
        return self::getQuery()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
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
            'index' => Pages\ListContractExpiredBoths::route('/'),
            'create' => Pages\CreateContractExpiredBoth::route('/create'),
            'view' => Pages\ViewContractExpiredBoth::route('/{record}'),
            'edit' => Pages\EditContractExpiredBoth::route('/{record}/edit'),
        ];
    }
}
