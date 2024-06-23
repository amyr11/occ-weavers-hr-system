<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InsuranceClassResource\Pages;
use App\Filament\Resources\InsuranceClassResource\RelationManagers;
use App\Models\InsuranceClass;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InsuranceClassResource extends Resource
{
    protected static ?string $model = InsuranceClass::class;

    protected static ?string $navigationIcon = 'heroicon-o-lifebuoy';

    protected static ?string $navigationGroup = 'Admin';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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
            'index' => Pages\ListInsuranceClasses::route('/'),
            'create' => Pages\CreateInsuranceClass::route('/create'),
            'view' => Pages\ViewInsuranceClass::route('/{record}'),
            'edit' => Pages\EditInsuranceClass::route('/{record}/edit'),
        ];
    }
}
