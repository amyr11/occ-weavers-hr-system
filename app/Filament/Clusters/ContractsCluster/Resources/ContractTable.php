<?php

namespace App\Filament\Clusters\ContractsCluster\Resources;

use App\Filament\Exports\ContractExporter;
use App\Filament\Imports\ContractImporter;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Contract;
use App\Utils\TableUtil;
use Filament\Actions\ImportAction;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions;

class ContractTable
{
	public static function getSchema()
	{
		return [
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
						->createOptionForm(function () {
							return [
								Forms\Components\TextInput::make('job_title')
									->label('Job title')
									->required(),
							];
						}),
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
		];
	}

	public Column $employee_number;
	public Column $employee_full_name;
	public Column $employeeJob_job_title;
	public Column $duration_in_years;
	public Column $start_date;
	public Column $end_date;
	public Column $paper_contract_end_date;
	public Column $basic_salary;
	public Column $housing_allowance;
	public Column $transportation_allowance;
	public Column $food_allowance;
	public Column $remarks;
	public Column $file_link;
	public Column $created_at;
	public Column $updated_at;

	public function __construct()
	{
		$this->employee_number = Tables\Columns\TextColumn::make('employee_number')
			->toggleable()
			->label('Employee no.')
			->searchable(isIndividual: true, isGlobal: false)
			->copyable()
			->placeholder('-')
			->sortable();

		$this->employee_full_name = Tables\Columns\TextColumn::make('employee.full_name')
			->toggleable()
			->label('Employee name')
			->searchable(isIndividual: true, isGlobal: false)
			->copyable()
			->placeholder('-')
			->sortable();

		$this->employeeJob_job_title = Tables\Columns\TextColumn::make('employeeJob.job_title')
			->toggleable()
			->label('Job title')
			->copyable()
			->placeholder('-')
			->sortable();

		$this->duration_in_years = Tables\Columns\TextColumn::make('duration_in_years')
			->toggleable()
			->label('Duration')
			->state(function (Contract $record) {
				return $record->duration_string;
			})
			->numeric()
			->placeholder('-')
			->copyable()
			->sortable();

		$this->start_date = Tables\Columns\TextColumn::make('start_date')
			->toggleable()
			->date()
			->placeholder('-')
			->copyable()
			->sortable();

		$this->end_date = Tables\Columns\TextColumn::make('end_date')
			->toggleable()
			->date()
			->placeholder('-')
			->copyable()
			->sortable();

		$this->paper_contract_end_date = Tables\Columns\TextColumn::make('paper_contract_end_date')
			->toggleable()
			->date()
			->placeholder('-')
			->copyable()
			->sortable();

		$this->basic_salary = Tables\Columns\TextColumn::make('basic_salary')
			->toggleable()
			->label('Basic salary (SAR)')
			->numeric()
			->placeholder('-')
			->copyable()
			->sortable();

		$this->housing_allowance = Tables\Columns\TextColumn::make('housing_allowance')
			->toggleable()
			->label('Housing allowance (SAR)')
			->numeric()
			->copyable()
			->sortable()
			->placeholder('-');

		$this->transportation_allowance = Tables\Columns\TextColumn::make('transportation_allowance')
			->toggleable()
			->label('Transportation allowance (SAR)')
			->numeric()
			->copyable()
			->sortable()
			->placeholder('-');

		$this->food_allowance = Tables\Columns\TextColumn::make('food_allowance')
			->toggleable()
			->label('Food allowance (SAR)')
			->numeric()
			->copyable()
			->sortable()
			->placeholder('-');

		$this->remarks = Tables\Columns\TextColumn::make('remarks')
			->toggleable()
			->copyable()
			->placeholder('-')
			->searchable(isIndividual: true, isGlobal: false)
			->extraAttributes([
				'style' => 'min-width: 200px',
			]);

		$this->file_link = Tables\Columns\TextColumn::make('file_link')
			->toggleable()
			->url(fn(Contract $record) => $record->file_link)
			->color('info')
			->placeholder('-');

		$this->created_at = Tables\Columns\TextColumn::make('created_at')
			->dateTime()
			->sortable()
			->toggleable();

		$this->updated_at = Tables\Columns\TextColumn::make('updated_at')
			->dateTime()
			->sortable()
			->toggleable();
	}

	public static function getColumns(?array $columns = null)
	{
		$table = new ContractTable();

		return $columns ?? [
			$table->employee_number,
			$table->employee_full_name,
			$table->employeeJob_job_title,
			$table->duration_in_years,
			$table->start_date,
			$table->end_date,
			$table->paper_contract_end_date,
			$table->basic_salary,
			$table->housing_allowance,
			$table->transportation_allowance,
			$table->food_allowance,
			$table->remarks,
			$table->file_link,
			$table->created_at,
			$table->updated_at,
		];
	}


	public static function getFilters()
	{
		return [
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
		];
	}

	public static function getActions()
	{
		return [
			Tables\Actions\ViewAction::make(),
			Tables\Actions\EditAction::make(),
		];
	}

	public static function getBulkActions()
	{
		return [
			Tables\Actions\DeleteBulkAction::make(),
			Tables\Actions\BulkActionGroup::make([
				TableUtil::getUpdateBulkAction(
					column: 'employee_job_id',
					icon: 'heroicon-o-briefcase',
					label: 'Job Title',
					form: [
						Forms\Components\Select::make('employee_job_id')
							->relationship('employeeJob', 'job_title')
							->label('Job title')
							->searchable()
							->preload()
							->createOptionForm(function () {
								return [
									Forms\Components\TextInput::make('job_title')
										->label('Job title')
										->required(),
								];
							})
							->required(),
					],
				),
				TableUtil::getUpdateBulkAction(
					column: 'housing_allowance',
					icon: 'heroicon-o-home',
					label: 'Housing Allowance',
					form: [
						Forms\Components\TextInput::make('housing_allowance')
							->prefix('SAR')
							->numeric(),
					],
				),
				TableUtil::getUpdateBulkAction(
					column: 'transportation_allowance',
					icon: 'heroicon-o-truck',
					label: 'Transportation Allowance',
					form: [
						Forms\Components\TextInput::make('transportation_allowance')
							->prefix('SAR')
							->numeric(),
					],
				),
				TableUtil::getUpdateBulkAction(
					column: 'food_allowance',
					icon: 'heroicon-o-shopping-cart',
					label: 'Food Allowance',
					form: [
						Forms\Components\TextInput::make('food_allowance')
							->prefix('SAR')
							->numeric(),
					],
				),
			])
				->label('Edit')
				->icon('heroicon-o-pencil'),
			ExportBulkAction::make()
				->icon('heroicon-o-arrow-down-tray')
				->exporter(ContractExporter::class),
		];
	}

	public static function getTable(Table $table, ?array $columns = null): Table
	{
		return $table
			->searchOnBlur()
			->defaultSort('start_date', 'desc')
			->columns(ContractTable::getColumns($columns))
			->filters(ContractTable::getFilters(), layout: FiltersLayout::Modal)
			->filtersFormWidth(MaxWidth::TwoExtraLarge)
			->actions(ContractTable::getActions(), position: ActionsPosition::BeforeColumns)
			->bulkActions(ContractTable::getBulkActions());
	}

	public static function getHeaderActions(): array
	{
		return [
			ImportAction::make()
				->icon('heroicon-o-arrow-up-tray')
				->importer(ContractImporter::class),
			Actions\CreateAction::make(),
		];
	}
}
