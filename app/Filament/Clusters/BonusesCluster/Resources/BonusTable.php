<?php

namespace App\Filament\Clusters\BonusesCluster\Resources;

use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeResource\Pages\ViewEmployee;
use App\Filament\Exports\BonusExporter;
use App\Filament\Exports\ContractExporter;
use App\Filament\Imports\BonusImporter;
use App\Filament\Imports\ContractImporter;
use App\Models\Bonus;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Contract;
use App\Models\Employee;
use App\Utils\TableUtil;
use Faker\Core\Number;
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
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Pluralizer;

class BonusTable
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
			Section::make('Bonus Details')
				->schema([
					Grid::make([
						'md' => 2,
					])
						->schema([
							Forms\Components\TextInput::make('bonus')
								->label('Bonus')
								->numeric()
								->required(),
							Forms\Components\DatePicker::make('date_received')
								->required(),
						])
				]),
		];
	}

	public Column $employee_number;
	public Column $employee_full_name;
	public Column $bonus;
	public Column $date_received;
	public Column $created_at;
	public Column $updated_at;

	public function __construct()
	{
		$this->employee_number = TextColumn::make('employee_number')
			->label('Employee no.')
			->searchable(isIndividual: true, isGlobal: true)
			->toggleable()
			->sortable();

		$this->employee_full_name = TextColumn::make('employee.full_name')
			->label('Employee name')
			->searchable(isIndividual: true, isGlobal: true)
			->toggleable()
			->sortable();

		$this->bonus = TextColumn::make('bonus')
			->label('Bonus')
			->numeric()
			->toggleable()
			->sortable();

		$this->date_received = TextColumn::make('date_received')
			->label('Date received')
			->date()
			->toggleable()
			->sortable();

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
		$table = new self();

		return $columns ?? [
			$table->employee_number,
			$table->employee_full_name,
			$table->bonus,
			$table->date_received,
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
			QueryBuilder::make()
				->constraints([
					DateConstraint::make('date_received')
						->label('Date received')
						->icon('heroicon-o-calendar'),
					NumberConstraint::make('bonus')
						->label('Bonus')
						->icon('heroicon-o-currency-dollar'),
				]),
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
			ExportBulkAction::make()
				->icon('heroicon-o-arrow-down-tray')
				->exporter(BonusExporter::class),
		];
	}

	public static function getTable(Table $table, ?array $columns = null): Table
	{
		return $table
			->recordUrl(
				fn(Bonus $record): string => ViewEmployee::getUrl([$record->employee_number]),
			)
			->searchOnBlur()
			->defaultSort('start_date', 'desc')
			->columns(self::getColumns($columns))
			->filters(self::getFilters(), layout: FiltersLayout::Modal)
			->filtersFormWidth(MaxWidth::TwoExtraLarge)
			->actions(self::getActions(), position: ActionsPosition::BeforeColumns)
			->bulkActions(self::getBulkActions())
			->defaultSort('date_received', 'desc');
	}

	public static function getHeaderActions(): array
	{
		return [
			ImportAction::make()
				->icon('heroicon-o-arrow-up-tray')
				->importer(BonusImporter::class),
			Actions\CreateAction::make(),
		];
	}
}
