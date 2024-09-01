<?php

namespace App\Filament\Clusters\ContractsCluster\Resources;

use App\Filament\Clusters\ContractsCluster;
use App\Filament\Clusters\ContractsCluster\Resources\ContractExpiringPaperResource\Pages;
use App\Models\Contract;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContractExpiringPaperResource extends Resource
{
    protected static ?string $model = Contract::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $navigationLabel = 'Expiring (Paper)';

    protected static ?int $navigationSort = 4;

    protected static ?string $cluster = ContractsCluster::class;

    private static function getQuery()
    {
        // 2 months before expiration
        return Contract::where('paper_contract_end_date', '<=', now()->addMonths(2))
            ->where('status', '!=', 'Expired (Paper)')
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
            ->defaultSort('p_contract_exp_rem_days', 'asc');
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
            'index' => Pages\ListContractExpiringPapers::route('/'),
            'create' => Pages\CreateContractExpiringPaper::route('/create'),
            'view' => Pages\ViewContractExpiringPaper::route('/{record}'),
            'edit' => Pages\EditContractExpiringPaper::route('/{record}/edit'),
        ];
    }
}
