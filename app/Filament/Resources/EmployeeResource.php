<?php

namespace App\Filament\Resources;

use App\Filament\Exports\EmployeeExporter;
use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Actions\ExportAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\RelationshipConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\RelationshipConstraint\Operators\IsRelatedToOperator;
use Filament\Tables\Filters\QueryBuilder\Constraints\SelectConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPdf\Facades\Pdf;

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
                        Grid::make([
                                'md' => 2,
                            ])
                                ->schema([
                                    Select::make('country_id')
                                        ->relationship('country', 'name')
                                        ->searchable()
                                        ->required(),
                                    TextInput::make('photo_link'),
                                ]),
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
                                    Select::make('insurance_class_id')
                                        ->relationship('insuranceClass', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->required(),
                                ]),
                        Grid::make([
                                'md' => 3,
                            ])
                                ->schema([
                                    DatePicker::make('final_exit_date'),
                                    DatePicker::make('visa_expired_date'),
                                    DatePicker::make('transferred_date'),
                                ]),
                        Grid::make([
                                'md' => 2,
                            ])
                                ->schema([
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
            ->searchOnBlur()
            ->defaultSort('status', 'asc')
            ->recordClasses(function (Model $record) {
                if ($record->final_exit_date != null) {
                    return 'border-l-4 bg-[#ffe6e6] !border-l-danger-500 dark:bg-[#403030] hover:bg-[#fad7d7] dark:hover:bg-[#4d3535]';
                }

                if ($record->visa_expired_date != null) {
                    return 'border-l-4 bg-[#fff5e6] !border-l-warning-500 dark:bg-[#403b30] hover:bg-[#faecd7] dark:hover:bg-[#665633]';
                }

                if ($record->transferred_date != null) {
                    return 'border-l-4 bg-[#e6f0ff] !border-l-blue-500 dark:bg-[#303940] hover:bg-[#d7e8fa] dark:hover:bg-[#335066]';
                }                

                return null;
            })
            ->columns([
                TextColumn::make('employee_number')
                    ->label('No.')
                    ->toggleable()
                    ->copyable()
                    ->searchable()
                    ->sortable()
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->extraAttributes([
                        'style' => 'min-width: 150px',
                    ]),
                TextColumn::make('status')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('full_name')
                    ->copyable()
                    ->toggleable()
                    ->searchable()
                    ->sortable()
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->extraAttributes([
                        'style' => 'min-width: 200px',
                    ]),
                TextColumn::make('country.name')
                    ->label('Country')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('age')
                    ->copyable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('email')
                    ->copyable()
                    ->toggleable()
                    ->sortable()
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->extraAttributes([
                        'style' => 'min-width: 200px',
                    ]),
                TextColumn::make('mobile_number')
                    ->label('Mobile no.')
                    ->toggleable()
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->copyable()
                    ->sortable()
                    ->extraAttributes([
                        'style' => 'min-width: 200px',
                    ]),
                TextColumn::make('labor_office_number')
                    ->label('Labor Office no.')
                    ->toggleable()
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->copyable()
                    ->sortable()
                    ->extraAttributes([
                        'style' => 'min-width: 200px',
                    ]),
                TextColumn::make('iban_number')
                    ->label('IBAN no.')
                    ->toggleable()
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->copyable()
                    ->sortable()
                    ->extraAttributes([
                        'style' => 'min-width: 200px',
                    ]),
                TextColumn::make('iqama_number')
                    ->label('IQAMA no.')
                    ->toggleable()
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->copyable()
                    ->sortable()
                    ->extraAttributes([
                        'style' => 'min-width: 200px',
                    ]),
                TextColumn::make('iqama_job_title')
                    ->label('IQAMA Job Title')
                    ->toggleable()
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->copyable()
                    ->sortable()
                    ->extraAttributes([
                        'style' => 'min-width: 200px',
                    ]),
                TextColumn::make('iqama_expiration')
                    ->label('IQAMA Expiration')
                    ->toggleable()
                    ->copyable()
                    ->date()
                    ->sortable(),
                TextColumn::make('passport_number')
                    ->label('Passport no.')
                    ->toggleable()
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->copyable()
                    ->sortable()
                    ->extraAttributes([
                        'style' => 'min-width: 200px',
                    ]),
                TextColumn::make('passport_date_issue')
                    ->date()
                    ->toggleable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('passport_expiration')
                    ->date()
                    ->toggleable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('sce_expiration')
                    ->label('SCE Expiration')
                    ->toggleable()
                    ->copyable()
                    ->date()
                    ->sortable(),
                TextColumn::make('insuranceClass.name')
                    ->copyable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('company_start_date')
                    ->date()
                    ->toggleable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('final_exit_date')
                    ->date()
                    ->toggleable()
                    ->copyable()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('visa_expired_date')
                    ->date()
                    ->toggleable()
                    ->copyable()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('transferred_date')
                    ->date()
                    ->toggleable()
                    ->copyable()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('max_leave_days')
                    ->copyable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('current_leave_days')
                    ->copyable()
                    ->toggleable()
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
                    ->multiple()
                    ->options([
                        'Active' => 'Active',
                        'Final Exit' => 'Final Exit',
                        'Visa Expired' => 'Visa Expired',
                        'Transferred' => 'Transferred',
                    ]),
                SelectFilter::make('country_id')
                    ->multiple()
                    ->label('Country')
                    ->relationship('country', 'name')
                    ->options(function () {
                        return \App\Models\Country::pluck('name', 'id');
                    })
                    ->searchable(),
                SelectFilter::make('insurance_class_id')
                    ->multiple()
                    ->label('Insurance class')
                    ->relationship('insuranceClass', 'name')
                    ->options(function () {
                        return \App\Models\InsuranceClass::pluck('name', 'id');
                    }),
                QueryBuilder::make()
                    ->constraints([
                        // NumberConstraint::make('employee_number')
                        //     ->icon('heroicon-o-hashtag'),
                        // TextConstraint::make('full_name')
                        //     ->icon('heroicon-o-user'),
                        NumberConstraint::make('age')
                            ->icon('heroicon-o-hashtag'),
                        // TextConstraint::make('mobile_number')
                        //     ->icon('heroicon-o-user'),
                        // TextConstraint::make('email')
                        //     ->icon('heroicon-o-user'),
                        DateConstraint::make('college_graduation_date')
                            ->icon('heroicon-o-calendar'),
                        // TextConstraint::make('labor_office_number')
                        //     ->icon('heroicon-o-hashtag'),
                        // TextConstraint::make('iban_number')
                        //     ->label('IBAN Number')
                        //     ->icon('heroicon-o-hashtag'),
                        // TextConstraint::make('iqama_number')
                        //     ->label('IQAMA Number')
                        //     ->icon('heroicon-o-hashtag'),
                        // TextConstraint::make('iqama_job_title')
                        //     ->label('IQAMA Job Title')
                        //     ->icon('heroicon-o-briefcase'),
                        DateConstraint::make('iqama_expiration')
                            ->label('IQAMA Expiration'),
                        //     ->icon('heroicon-o-calendar'),
                        // TextConstraint::make('passport_number')
                        //     ->icon('heroicon-o-hashtag'),
                        DateConstraint::make('passport_date_issue')
                            ->icon('heroicon-o-calendar'),
                        DateConstraint::make('passport_expiration')
                            ->icon('heroicon-o-calendar'),
                        DateConstraint::make('sce_expiration')
                            ->label('SCE Expiration')
                            ->icon('heroicon-o-calendar'),
                        DateConstraint::make('company_start_date')
                            ->icon('heroicon-o-calendar'),
                        DateConstraint::make('final_exit_date')
                            ->icon('heroicon-o-calendar'),
                        DateConstraint::make('visa_expired_date')
                            ->icon('heroicon-o-calendar'),
                        DateConstraint::make('transferred_date')
                            ->icon('heroicon-o-calendar'),
                        NumberConstraint::make('max_leave_days')
                            ->icon('heroicon-o-hashtag'),
                        NumberConstraint::make('current_leave_days')
                            ->icon('heroicon-o-hashtag'),
                    ])
            ], layout: FiltersLayout::Modal)
            ->filtersFormWidth(MaxWidth::TwoExtraLarge)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('file_information_sheet')
                    ->label('PDF')
                    ->color('danger')
                    ->icon('heroicon-o-document')
                    ->url(fn (Employee $employee) => route('file-information-sheet', $employee)),
            ], position: ActionsPosition::BeforeColumns)
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\BulkActionGroup::make([
                    self::getUpdateBulkAction('final_exit_date', 'heroicon-o-calendar', 'Final Exit Date'),
                    self::getUpdateBulkAction('visa_expired_date', 'heroicon-o-calendar', 'Visa Expired Date'),
                    self::getUpdateBulkAction('transferred_date', 'heroicon-o-calendar', 'Transferred Date'),
                ])
                    ->label('Edit')
                    ->icon('heroicon-o-pencil'),
                ExportBulkAction::make()
                    ->icon('heroicon-o-arrow-down-tray')
                    ->exporter(EmployeeExporter::class),
            ]);
    }
    
    private static function getUpdateBulkAction($column, $icon, $label, $action = null): Tables\Actions\BulkAction
    {
        return Tables\Actions\BulkAction::make($column)
            ->label($label)
            ->requiresConfirmation()
            ->icon($icon)
            ->deselectRecordsAfterCompletion()
            ->action($action ?? function ($records, array $data): void {
                foreach ($records as $record) {
                    $record->update($data);
                }
            })
            ->form(fn ($records) => [
                DatePicker::make($column)
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
