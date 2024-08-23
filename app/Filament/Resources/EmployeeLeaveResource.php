<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\EmployeeLeaveCluster;
use App\Filament\Clusters\EmployeeLeavesCluster;
use Filament\Tables\Columns\ToggleColumn;
use App\Filament\Resources\EmployeeLeaveResource\Pages;
use App\Filament\Resources\EmployeeLeaveResource\RelationManagers;
use App\Models\EmployeeLeave;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
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
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Pluralizer;
use Filament\Pages\SubNavigationPosition;

class EmployeeLeaveResource extends Resource
{
    protected static ?string $model = EmployeeLeave::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $navigationLabel = 'All';

    protected static ?string $cluster = EmployeeLeavesCluster::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Employee Information')
                    ->schema([
                        Grid::make([
                            'md' => 2,
                        ])
                            ->schema([
                                Forms\Components\Select::make('employee_number')
                                    ->label('Employee no.')
                                    ->relationship('employee', 'employee_number')
                                    ->searchable(['full_name', 'employee_number'])
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $set('employee_name_select', $get('employee_number'));
                                    })
                                    ->required(),
                                Forms\Components\Select::make('employee_name_select')
                                    ->relationship('employee', 'full_name')
                                    ->label('Employee name')
                                    ->disabled(),
                                Forms\Components\TextInput::make('contact_number')
                                    ->label('Contact number')
                                    ->maxLength(255),
                            ])
                    ]),
                Section::make('Leave details')
                    ->schema([
                        Forms\Components\Grid::make([
                            'md' => 3,
                        ])
                            ->schema([
                                Forms\Components\DatePicker::make('start_date')
                                    ->label('Departure date')
                                    ->required(),
                                Forms\Components\DatePicker::make('end_date')
                                    ->label('Return date')
                                    ->required(),
                                Forms\Components\TextInput::make('duration_in_days')
                                    ->hiddenOn(['create', 'edit'])
                                    ->label('Leave duration')
                                    ->suffix('day/s')
                                    ->disabled()
                                    ->default(null),
                                Forms\Components\TextInput::make('status')
                                    ->label('Leave status')
                                    ->hiddenOn(['create', 'edit'])
                                    ->disabled(),
                                Forms\Components\Toggle::make('arrived')
                                    ->default(false),
                            ]),
                    ]),
                Section::make('Visa details')
                    ->schema([
                        Forms\Components\Grid::make([
                            'md' => 3,
                        ])
                            ->schema([
                                Forms\Components\TextInput::make('visa_duration_in_days')
                                    ->label('Visa duration')
                                    ->suffix('day/s')
                                    ->numeric()
                                    ->live()
                                    ->requiredWith('start_date')
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $startDate = $get('start_date');
                                        $duration = $get('visa_duration_in_days');
                                        if (!$startDate || !$duration) {
                                            $set('visa_expiration', null);
                                            return;
                                        }
                                        $endDate = Carbon::parse($startDate)->addDay((int) $duration - 1)->format('Y-m-d');
                                        $set('visa_expiration', $endDate);
                                    })
                                    ->required(),
                                Forms\Components\DatePicker::make('visa_expiration')
                                    ->required()
                                    ->live()
                                    ->requiredWith('start_date')
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $startDate = $get('start_date');
                                        $endDate = $get('visa_expiration');
                                        if (!$startDate || !$endDate) {
                                            $set('visa_duration_in_days', null);
                                            return;
                                        }
                                        $duration = Carbon::parse($startDate)->diffInDays($endDate) + 1;
                                        $set('visa_duration_in_days', $duration);
                                    }),
                                Forms\Components\TextInput::make('visa_remaining_days')
                                    ->label('Visa remaining days')
                                    ->suffix('day/s')
                                    ->numeric()
                                    ->disabled()
                                    ->hiddenOn(['create', 'edit']),
                            ]),
                    ]),
                Forms\Components\TextInput::make('request_file_link')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->searchOnBlur()
            ->defaultSort('start_date', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('employee_number')
                    ->label('Employee no.')
                    ->numeric()
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee.full_name')
                    ->label('Employee name')
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contact_number')
                    ->copyable()
                    ->sortable(),
                ToggleColumn::make('arrived'),
                ToggleColumn::make('visa_expired'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(EmployeeLeave $record) => match ($record->status) {
                        'On vacation' => 'success',
                        'For vacation' => 'warning',
                        'Arrival expected' => 'info',
                        'Visa expired' => 'danger',
                        'Arrived (Resolved)' => 'gray',
                        'Visa expired (Resolved)' => 'gray',
                        default => 'info',
                    })
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Departure date')
                    ->date()
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Return date')
                    ->date()
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration_in_days')
                    ->label('Leave duration')
                    ->state(fn(EmployeeLeave $record) => "{$record->duration_in_days} " . Pluralizer::plural('day', $record->duration_in_days))
                    ->copyable(),
                Tables\Columns\TextColumn::make('remaining_leave_days')
                    ->label('Leave balance')
                    ->state(fn(EmployeeLeave $record) => "{$record->remaining_leave_days} " . Pluralizer::plural('day', $record->remaining_leave_days))
                    ->copyable(),
                Tables\Columns\TextColumn::make('visa_expiration')
                    ->date()
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('visa_duration_in_days')
                    ->label('Visa duration')
                    ->state(fn(EmployeeLeave $record) => "{$record->visa_duration_in_days} " . Pluralizer::plural('day', $record->visa_duration_in_days))
                    ->copyable(),
                Tables\Columns\TextColumn::make('visa_remaining_days')
                    ->label('Visa remaining days')
                    ->state(fn(EmployeeLeave $record) => $record->visa_remaining_days != null ? ("{$record->visa_remaining_days} " . Pluralizer::plural('day', $record->visa_remaining_days)) : null)
                    ->placeholder('-')
                    ->copyable(),
                Tables\Columns\TextColumn::make('request_file_link')
                    ->url(fn(EmployeeLeave $record) => $record->request_file_link)
                    ->color('info')
                    ->placeholder('-'),
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
