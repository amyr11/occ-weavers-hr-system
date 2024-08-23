<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\EmployeeLeavesCluster;
use App\Filament\Resources\EmployeeLeaveResource\EmployeeLeaveTable;
use App\Filament\Resources\EmployeeLeaveResource\Pages;
use App\Models\EmployeeLeave;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Pages\SubNavigationPosition;

class EmployeeLeaveResource extends Resource
{
    protected static ?string $model = EmployeeLeave::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $navigationLabel = 'All';

    protected static ?string $cluster = EmployeeLeavesCluster::class;

    public static function form(Form $form): Form
    {
        return $form->schema(EmployeeLeaveTable::getSchema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->searchOnBlur()
            ->defaultSort('start_date', 'desc')
            ->columns(EmployeeLeaveTable::getColumns())
            ->filters([
                Filter::make('employee_number')
                    ->indicateUsing(function (array $data) {
                        if (empty($data['employee_number'])) {
                            return null;
                        }
                        return 'Employee no.: ' . $data['employee_number'];
                    })
                    ->query(function (Builder $query, array $data) {
                        if (empty($data['employee_number'])) {
                            return;
                        }
                        return $query->where('employee_number', '=', $data['employee_number']);
                    })
                    ->form(function () {
                        return [
                            TextInput::make('employee_number')
                                ->label('Employee no.')
                                ->placeholder('Enter Employee no.'),
                        ];
                    }),
                SelectFilter::make('status')
                    ->options([
                        'On vacation' => 'On vacation',
                        'For vacation' => 'For vacation',
                        'Visa expired' => 'Visa expired',
                        'Arrived' => 'Arrived',
                        'Arrival expected' => 'Arrival expected',
                    ])
                    ->multiple(),
                QueryBuilder::make()
                    ->constraints([
                        DateConstraint::make('start_date')
                            ->icon('heroicon-o-calendar'),
                        DateConstraint::make('end_date')
                            ->icon('heroicon-o-calendar'),
                        NumberConstraint::make('duration_in_days')
                            ->icon('heroicon-o-hashtag'),
                    ])
            ], layout: FiltersLayout::Modal)
            ->filtersFormWidth(MaxWidth::TwoExtraLarge)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ], position: ActionsPosition::BeforeColumns)
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\BulkAction::make('Mark as arrived')
                    ->requiresConfirmation()
                    ->icon('heroicon-o-check-circle')
                    ->deselectRecordsAfterCompletion()
                    ->action(fn(Collection $records) => $records->each(fn($record) => $record->update(['arrived' => true]))),
                Tables\Actions\BulkAction::make('Mark as visa expired')
                    ->requiresConfirmation()
                    ->color('warning')
                    ->icon('heroicon-o-exclamation-circle')
                    ->deselectRecordsAfterCompletion()
                    ->action(fn(Collection $records) => $records->each(fn($record) => $record->update(['visa_expired' => true]))),
                Tables\Actions\BulkAction::make('Clear status')
                    ->requiresConfirmation()
                    ->color('gray')
                    ->icon('heroicon-o-arrow-uturn-down')
                    ->deselectRecordsAfterCompletion()
                    ->action(fn(Collection $records) => $records->each(fn($record) => $record->update(['arrived' => false, 'visa_expired' => false]))),
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
            'index' => Pages\ListEmployeeLeaves::route('/'),
            'create' => Pages\CreateEmployeeLeave::route('/create'),
            'view' => Pages\ViewEmployeeLeave::route('/{record}'),
            'edit' => Pages\EditEmployeeLeave::route('/{record}/edit'),
        ];
    }
}
