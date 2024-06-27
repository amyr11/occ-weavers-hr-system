<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectAssignmentResource\Pages;
use App\Filament\Resources\ProjectAssignmentResource\RelationManagers;
use App\Models\ProjectAssignment;
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
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectAssignmentResource extends Resource
{
    protected static ?string $model = ProjectAssignment::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?int $navigationSort = 4;

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
                Section::make('Project assignment details')
                    ->schema([
                        Grid::make([
                            'md' => 2,
                        ])
                            ->schema([
                                Forms\Components\Select::make('project_id')
                                    ->relationship('project', 'project_name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Forms\Components\DatePicker::make('transfer_date')
                                    ->required(),
                            ])
                    ]),
                Forms\Components\TextInput::make('transfer_memo_link')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('transfer_date', 'desc')
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
                Tables\Columns\TextColumn::make('project.project_name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('transfer_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('transfer_memo_link')
                    ->url(fn ($record) => $record->transfer_memo_link)
                    ->color('info')
                    ->searchable(),
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
                SelectFilter::make('project_id')
                    ->label('Project')
                    ->multiple()
                    ->relationship('project', 'project_name')
                    ->preload(),
                QueryBuilder::make()
                    ->constraints([
                        DateConstraint::make('transfer_date')
                            ->icon('heroicon-o-calendar'),
                    ])
            ], layout: FiltersLayout::Modal)
            ->filtersFormWidth(MaxWidth::TwoExtraLarge)
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
            'index' => Pages\ListProjectAssignments::route('/'),
            'create' => Pages\CreateProjectAssignment::route('/create'),
            'view' => Pages\ViewProjectAssignment::route('/{record}'),
            'edit' => Pages\EditProjectAssignment::route('/{record}/edit'),
        ];
    }
}
