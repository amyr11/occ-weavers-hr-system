<?php

namespace App\Filament\Clusters\ContractsCluster\Resources;

use App\Filament\Clusters\ContractsCluster;
use App\Filament\Clusters\ContractsCluster\Resources\ContractResource\Pages;
use App\Models\Contract;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Pages\SubNavigationPosition;
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

class ContractResource extends Resource
{
    protected static ?string $model = Contract::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $navigationLabel = 'All';

    protected static ?string $cluster = ContractsCluster::class;

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
                            ])
                    ]),
                Section::make('Contract Details')
                    ->schema([
                        Forms\Components\Select::make('employee_job_id')
                            ->label('Job title')
                            ->relationship('employeeJob', 'job_title')
                            ->label('Job title')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Grid::make([
                            'md' => 3,
                        ])
                            ->schema([
                                Forms\Components\DatePicker::make('start_date')
                                    ->required(),
                                Forms\Components\DatePicker::make('end_date')
                                    ->required(),
                                Forms\Components\DatePicker::make('paper_contract_end_date'),
                            ])
                    ]),
                Section::make('Salary/Allowance')
                    ->schema([
                        Grid::make([
                            'md' => 2,
                            'xl' => 4,
                        ])
                            ->schema([
                                Forms\Components\TextInput::make('basic_salary')
                                    ->required()
                                    ->prefix('SAR')
                                    ->numeric(),
                                Forms\Components\TextInput::make('housing_allowance')
                                    ->prefix('SAR')
                                    ->numeric(),
                                Forms\Components\TextInput::make('transportation_allowance')
                                    ->prefix('SAR')
                                    ->numeric(),
                                Forms\Components\TextInput::make('food_allowance')
                                    ->prefix('SAR')
                                    ->numeric(),
                            ]),
                    ]),
                Forms\Components\TextInput::make('remarks')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('file_link')
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
                    ->toggleable()
                    ->label('Employee no.')
                    ->numeric()
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee.full_name')
                    ->toggleable()
                    ->label('Employee name')
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('employeeJob.job_title')
                    ->toggleable()
                    ->label('Job title')
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration_in_years')
                    ->toggleable()
                    ->label('Duration')
                    ->state(function (Contract $record) {
                        return $record->duration_string;
                    })
                    ->numeric()
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->toggleable()
                    ->date()
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->toggleable()
                    ->date()
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('paper_contract_end_date')
                    ->toggleable()
                    ->date()
                    ->placeholder('-')
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('basic_salary')
                    ->toggleable()
                    ->label('Basic salary (SAR)')
                    ->numeric()
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('housing_allowance')
                    ->toggleable()
                    ->label('Housing allowance (SAR)')
                    ->numeric()
                    ->copyable()
                    ->sortable()
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('transportation_allowance')
                    ->toggleable()
                    ->label('Transportation allowance (SAR)')
                    ->numeric()
                    ->copyable()
                    ->sortable()
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('food_allowance')
                    ->toggleable()
                    ->label('Food allowance (SAR)')
                    ->numeric()
                    ->copyable()
                    ->sortable()
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('remarks')
                    ->toggleable()
                    ->copyable()
                    ->placeholder('-')
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->extraAttributes([
                        'style' => 'min-width: 200px',
                    ]),
                Tables\Columns\TextColumn::make('file_link')
                    ->toggleable()
                    ->url(fn(Contract $record) => $record->file_link)
                    ->color('info')
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
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
                SelectFilter::make('employeeJob_id')
                    ->label('Job title')
                    ->multiple()
                    ->relationship('employeeJob', 'job_title')
                    ->preload()
                    ->searchable(),
                QueryBuilder::make()
                    ->constraints([
                        DateConstraint::make('start_date')
                            ->icon('heroicon-o-calendar'),
                        DateConstraint::make('end_date')
                            ->icon('heroicon-o-calendar'),
                        DateConstraint::make('paper_contract_end_date')
                            ->icon('heroicon-o-calendar'),
                        NumberConstraint::make('duration_in_years')
                            ->icon('heroicon-o-hashtag')
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
            'index' => Pages\ListContracts::route('/'),
            'create' => Pages\CreateContract::route('/create'),
            'view' => Pages\ViewContract::route('/{record}'),
            'edit' => Pages\EditContract::route('/{record}/edit'),
        ];
    }
}
