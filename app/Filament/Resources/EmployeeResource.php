<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use App\Models\EmployeeStatus;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\RelationshipConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\RelationshipConstraint\Operators\IsRelatedToOperator;
use Filament\Tables\Filters\QueryBuilder\Constraints\SelectConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Personal Information')
                    ->schema([
                        Grid::make([
                            'md' => 4,
                        ])
                            ->schema([
                                TextInput::make('first_name')
                                    ->required(),
                                TextInput::make('middle_name')
                                    ->required(),
                                TextInput::make('last_name')
                                    ->required(),
                                TextInput::make('suffix'),
                            ]),
                        Grid::make([
                                'md' => 3,
                            ])
                                ->schema([
                                    DatePicker::make('birthdate')
                                        ->required(),
                                    TextInput::make('mobile_number')
                                        ->required(),
                                    TextInput::make('email')
                                        ->email()
                                        ->required(),
                                ]),
                        TextInput::make('photo_link'),
                            ]),
                Section::make('Education')
                    ->schema([
                        DatePicker::make('college_graduation_date')
                            ->required(),
                    ]),
                Section::make('Government information')
                    ->schema([
                        Grid::make([
                                'md' => 2,
                            ])
                                ->schema([
                                    TextInput::make('labor_office_number')
                                        ->required(),
                                    TextInput::make('iban_number')
                                        ->label('IBAN Number')
                                        ->required(),
                                ]),
                        Grid::make([
                                'md' => 3,
                            ])
                                ->schema([
                                    TextInput::make('iqama_number')
                                        ->label('IQAMA Number')
                                        ->required(),
                                    TextInput::make('iqama_job_title')
                                        ->label('IQAMA Job Title')
                                        ->required(),
                                    DatePicker::make('iqama_expiration')
                                        ->label('IQAMA Expiration')
                                        ->required(),
                                ]),
                        Grid::make([
                                'md' => 3,
                            ])
                                ->schema([
                                    TextInput::make('passport_number')
                                        ->required(),
                                    DatePicker::make('passport_date_issue')
                                        ->required(),
                                    DatePicker::make('passport_expiration')
                                        ->required(),
                                ]),
                        Grid::make([
                                'md' => 2,
                            ])
                                ->schema([
                                    DatePicker::make('sce_expiration')
                                        ->label('SCE Expiration')
                                        ->required(),
                                    TextInput::make('insurance_classification')
                                        ->required(),
                                ]),
                    ]),
                Section::make('Company information')
                    ->schema([
                        Grid::make([
                                'md' => 2,
                            ])
                                ->schema([
                                    DatePicker::make('company_start_date')
                                        ->required(),
                                    Select::make('employee_status_id')
                                        ->relationship('employeeStatus', 'status')
                                        ->default(1)
                                        ->required(),
                                    TextInput::make('max_leave_days')
                                        ->required(),
                                    TextInput::make('current_leave_days')
                                        ->required(),
                                ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee_number')
                    ->label('No.')
                    ->copyable()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('employeeStatus.status')
                    ->label('Status')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('full_name')
                    ->copyable()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('age')
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('mobile_number')
                    ->label('Mobile no.')
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('labor_office_number')
                    ->label('Labor Office no.')
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('iban_number')
                    ->label('IBAN no.')
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('iqama_number')
                    ->label('IQAMA no.')
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('iqama_job_title')
                    ->label('IQAMA Job Title')
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('iqama_expiration')
                    ->label('IQAMA Expiration')
                    ->copyable()
                    ->date()
                    ->sortable(),
                TextColumn::make('passport_number')
                    ->label('Passport no.')
                    ->copyable()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('passport_date_issue')
                    ->date()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('passport_expiration')
                    ->date()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('sce_expiration')
                    ->label('SCE Expiration')
                    ->copyable()
                    ->date()
                    ->sortable(),
                TextColumn::make('insurance_classification')
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('company_start_date')
                    ->date()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('max_leave_days')
                    ->copyable()
                    ->sortable(),
                TextColumn::make('current_leave_days')
                    ->copyable()
                    ->sortable(),
            ])
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        NumberConstraint::make('employee_number')
                            ->icon('heroicon-o-hashtag'),
                        RelationshipConstraint::make('employeeStatus')
                            ->icon('heroicon-o-bars-3')
                            ->selectable(
                                IsRelatedToOperator::make()
                                ->titleAttribute('status')
                            ),
                        TextConstraint::make('full_name')
                            ->icon('heroicon-o-user'),
                        NumberConstraint::make('age')
                            ->icon('heroicon-o-user'),
                        TextConstraint::make('mobile_number')
                            ->icon('heroicon-o-user'),
                        TextConstraint::make('email')
                            ->icon('heroicon-o-user'),
                        DateConstraint::make('college_graduation_date')
                            ->icon('heroicon-o-calendar'),
                        TextConstraint::make('labor_office_number')
                            ->icon('heroicon-o-hashtag'),
                        TextConstraint::make('iban_number')
                            ->label('IBAN Number')
                            ->icon('heroicon-o-hashtag'),
                        TextConstraint::make('iqama_number')
                            ->label('IQAMA Number')
                            ->icon('heroicon-o-hashtag'),
                        TextConstraint::make('iqama_job_title')
                            ->label('IQAMA Job Title')
                            ->icon('heroicon-o-briefcase'),
                        DateConstraint::make('iqama_expiration')
                            ->label('IQAMA Expiration')
                            ->icon('heroicon-o-calendar'),
                        TextConstraint::make('passport_number')
                            ->icon('heroicon-o-hashtag'),
                        DateConstraint::make('passport_date_issue')
                            ->icon('heroicon-o-calendar'),
                        DateConstraint::make('passport_expiration')
                            ->icon('heroicon-o-calendar'),
                        DateConstraint::make('sce_expiration')
                            ->label('SCE Expiration')
                            ->icon('heroicon-o-calendar'),
                        TextConstraint::make('insurance_classification')
                            ->icon('heroicon-o-hashtag'),
                        DateConstraint::make('company_start_date')
                            ->icon('heroicon-o-calendar'),
                        NumberConstraint::make('max_leave_days')
                            ->icon('heroicon-o-hashtag'),
                        NumberConstraint::make('current_leave_days')
                            ->icon('heroicon-o-hashtag'),
                    ])
            ], layout: FiltersLayout::AboveContent)
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
