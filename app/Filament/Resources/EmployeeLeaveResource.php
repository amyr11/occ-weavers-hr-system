<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeLeaveResource\Pages;
use App\Filament\Resources\EmployeeLeaveResource\RelationManagers;
use App\Models\EmployeeLeave;
use Filament\Forms;
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
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Pluralizer;

class EmployeeLeaveResource extends Resource
{
    protected static ?string $model = EmployeeLeave::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_number')
                    ->relationship('employee', 'employee_number')
                    ->searchable(['full_name', 'employee_number'])
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->employee_number} - {$record->full_name}")
                    ->required(),
                Forms\Components\TextInput::make('request_file_link')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Grid::make([
                    'md' => 3,
                ])
                    ->schema([
                        Forms\Components\DatePicker::make('start_date')
                            ->required(),
                        Forms\Components\DatePicker::make('end_date')
                            ->required(),
                        Forms\Components\TextInput::make('duration_in_days')
                            ->hiddenOn(['create', 'edit'])
                            ->label('Duration')
                            ->suffix('day/s')
                            ->disabled()
                            ->default(null),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('start_date', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('employee.full_name')
                    ->state(function (EmployeeLeave $record) {
                            return "{$record->employee->employee_number} - {$record->employee->full_name}";
                        })
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration_in_days')
                    ->label('Duration')
                    ->state(fn (EmployeeLeave $record) => "{$record->duration_in_days} " . Pluralizer::plural('day', $record->duration_in_days))
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('request_file_link')
                    ->url(fn (EmployeeLeave $record) => $record->request_file_link)
                    ->color('info')
                    ->placeholder('-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->copyable()
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->copyable()
                    ->dateTime()
                    ->sortable(),
            ])
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
