<?php

namespace App\Filament\Clusters\ProjectAssignmentsCluster\Resources;

use App\Filament\Exports\ProjectAssignmentExporter;
use App\Filament\Imports\ProjectAssignmentImporter;
use App\Utils\TableUtil;
use Filament\Actions\ImportAction;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Set;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions;

class ProjectAssignmentTable
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
								->createOptionForm(function () {
									return [
										Forms\Components\TextInput::make('project_name')
											->label('Project name')
											->required(),
									];
								})
								->required(),
							Forms\Components\DatePicker::make('transfer_date')
								->required(),
						])
				]),
			Forms\Components\TextInput::make('transfer_memo_link')
				->maxLength(255)
				->default(null),
		];
	}

	public Column $employee_number;
	public Column $employee_full_name;
	public Column $project_project_name;
	public Column $transfer_date;
	public Column $transfer_memo_link;

	public function __construct()
	{
		$this->employee_number = Tables\Columns\TextColumn::make('employee_number')
			->toggleable()
			->label('Employee no.')
			->searchable(isIndividual: true, isGlobal: false)
			->copyable()
			->sortable();

		$this->employee_full_name = Tables\Columns\TextColumn::make('employee.full_name')
			->toggleable()
			->label('Employee name')
			->searchable(isIndividual: true, isGlobal: false)
			->copyable()
			->sortable();

		$this->project_project_name = Tables\Columns\TextColumn::make('project.project_name')
			->searchable(isIndividual: true, isGlobal: false)
			->toggleable()
			->sortable();

		$this->transfer_date = Tables\Columns\TextColumn::make('transfer_date')
			->toggleable()
			->date()
			->sortable();

		$this->transfer_memo_link = Tables\Columns\TextColumn::make('transfer_memo_link')
			->toggleable()
			->url(fn($record) => $record->transfer_memo_link)
			->color('info');
	}

	public static function getColumns(?array $columns = null)
	{
		$table = new ProjectAssignmentTable();

		return $columns ?? [
			$table->employee_number,
			$table->employee_full_name,
			$table->project_project_name,
			$table->transfer_date,
			$table->transfer_memo_link,
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
					column: 'project_id',
					icon: 'heroicon-o-building-office-2',
					label: 'Project',
					form: [
						Forms\Components\Select::make('project_id')
							->relationship('project', 'project_name')
							->searchable()
							->preload()
							->createOptionForm(function () {
								return [
									Forms\Components\TextInput::make('project_name')
										->label('Project name')
										->required(),
								];
							})
							->required(),
					],
				),
			])
				->label('Edit')
				->icon('heroicon-o-pencil'),
			ExportBulkAction::make()
				->icon('heroicon-o-arrow-down-tray')
				->exporter(ProjectAssignmentExporter::class),
		];
	}

	public static function getTable(Table $table, ?array $columns = null): Table
	{
		return $table
			->searchOnBlur()
			->defaultSort('transfer_date', 'desc')
			->columns(ProjectAssignmentTable::getColumns($columns))
			->filters(ProjectAssignmentTable::getFilters(), layout: FiltersLayout::Modal)
			->filtersFormWidth(MaxWidth::TwoExtraLarge)
			->actions(ProjectAssignmentTable::getActions(), position: ActionsPosition::BeforeColumns)
			->bulkActions(ProjectAssignmentTable::getBulkActions());
	}

	public static function getHeaderActions(): array
	{
		return [
			ImportAction::make()
				->icon('heroicon-o-arrow-up-tray')
				->importer(ProjectAssignmentImporter::class),
			Actions\CreateAction::make(),
		];
	}
}
