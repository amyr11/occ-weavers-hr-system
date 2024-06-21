<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeStatusResource\Pages;
use App\Filament\Resources\EmployeeStatusResource\RelationManagers;
use App\Models\EmployeeStatus;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeStatusResource extends Resource
{
    protected static ?string $model = EmployeeStatus::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    protected static ?string $navigationGroup = 'Admin';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('status')
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
            'index' => Pages\ListEmployeeStatuses::route('/'),
            'create' => Pages\CreateEmployeeStatus::route('/create'),
            'view' => Pages\ViewEmployeeStatus::route('/{record}'),
            'edit' => Pages\EditEmployeeStatus::route('/{record}/edit'),
        ];
    }
}
