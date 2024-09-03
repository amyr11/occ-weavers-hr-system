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
        return Contract::where(
            function ($query) {
                $query->where('status', '=', 'Active')
                    ->orWhere('status', '=', 'Expired (Paper)');
            }
        );
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
            statusOptions: [
                'Active' => 'Active',
                'Expired (Paper)' => 'Expired (Paper)',
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
