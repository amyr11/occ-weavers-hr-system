<?php

namespace App\Filament\Clusters\BonusesCluster\Resources;

use App\Filament\Clusters\BonusesCluster;
use App\Filament\Clusters\BonusesCluster\Resources\BonusResource\Pages;
use App\Filament\Clusters\BonusesCluster\Resources\BonusResource\RelationManagers;
use App\Models\Bonus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BonusResource extends Resource
{
    protected static ?string $model = Bonus::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $navigationLabel = 'All';

    protected static ?string $cluster = BonusesCluster::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema(BonusTable::getSchema());
    }

    public static function table(Table $table): Table
    {
        return BonusTable::getTable($table);
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
            'index' => Pages\ListBonuses::route('/'),
            // 'create' => Pages\CreateBonus::route('/create'),
            // 'view' => Pages\ViewBonus::route('/{record}'),
            // 'edit' => Pages\EditBonus::route('/{record}/edit'),
        ];
    }
}
