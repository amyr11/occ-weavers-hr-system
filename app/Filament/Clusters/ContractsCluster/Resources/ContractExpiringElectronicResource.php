<?php

namespace App\Filament\Clusters\ContractsCluster\Resources;

use App\Filament\Clusters\ContractsCluster;
use App\Filament\Clusters\ContractsCluster\Resources\ContractExpiringElectronicResource\Pages;
use App\Models\Contract;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContractExpiringElectronicResource extends Resource
{
    protected static ?string $model = Contract::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $navigationLabel = 'Expiring (Electronic)';

    protected static ?int $navigationSort = 3;

    protected static ?string $cluster = ContractsCluster::class;

    private static function getQuery()
    {
        // 2 months before expiration
        return Contract::where('end_date', '<=', now()->addMonths(2))
            ->where('status', '!=', 'Expired (Electronic)')
            ->where('status', '!=', 'Expired (Both)');
    }

    public static function getNavigationBadge(): ?string
    {
        return self::getQuery()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(ContractTable::getSchema());
    }

    public static function table(Table $table): Table
    {
        return ContractTable::getTable($table)
            ->query(self::getQuery())
            ->defaultSort('e_contract_exp_rem_days', 'asc');
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
            'index' => Pages\ListContractExpiringElectronics::route('/'),
            'create' => Pages\CreateContractExpiringElectronic::route('/create'),
            'view' => Pages\ViewContractExpiringElectronic::route('/{record}'),
            'edit' => Pages\EditContractExpiringElectronic::route('/{record}/edit'),
        ];
    }
}
