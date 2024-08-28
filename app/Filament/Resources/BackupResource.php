<?php

namespace App\Filament\Resources;

use App\Actions\BackupDatabase;
use App\Filament\Resources\BackupResource\Pages;
use App\Models\Backup;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class BackupResource extends Resource
{
    protected static ?string $model = Backup::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('filename'),
                Tables\Columns\TextColumn::make('created_at')->label('Backup Date')->sortable(),
            ])
            ->actions([
                Action::make('download')->action(fn(Backup $record) => $record->download())
            ])
            ->headerActions([
                Tables\Actions\Action::make('backup-now')
                    ->action(fn(BackupDatabase $backupDatabase) => $backupDatabase())
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
            'index' => Pages\ListBackups::route('/'),
        ];
    }
}
