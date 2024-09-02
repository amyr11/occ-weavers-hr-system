<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources;

use App\Filament\Clusters\EmployeesCluster\Resources\EmployeeResource\Pages\ViewEmployee;
use App\Filament\Exports\EmployeeLeaveExporter;
use App\Filament\Imports\EmployeeLeaveImporter;
use Filament\Tables\Columns\ToggleColumn;
use App\Models\EmployeeLeave;
use App\Utils\TableUtil;
use Carbon\Carbon;
use Filament\Actions\ImportAction;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables;
use Illuminate\Support\Pluralizer;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\MaxWidth;
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
use Illuminate\Database\Eloquent\Model;

class EmployeeLeaveTable
{
	public static function getSchema()
	{
		return [
			Placeholder::make('updated_at')
				->content(fn(Model $record): string => $record->updated_at->format('M d, Y H:i:s')),
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
						'md' => 2,
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
								->debounce(800)
								->required(),
							Forms\Components\DatePicker::make('visa_expiration')
								->required()
								->live()
								->debounce(800)
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
					Forms\Components\Toggle::make('visa_expired')
						->default(false),
				]),
			Forms\Components\TextInput::make('request_file_link')
				->maxLength(255)
				->default(null),
		];
	}

	public Column $employee_number;
	public Column $employee_full_name;
	public Column $contact_number;
	public Column $status;
	public Column $start_date;
	public Column $end_date;
	public Column $duration_in_days;
	public Column $remaining_leave_days;
	public Column $visa_expiration;
	public Column $visa_duration_in_days;
	public Column $visa_remaining_days;
	public Column $request_file_link;
	public Column $arrived;
	public Column $visa_expired;
	public Column $created_at;
	public Column $updated_at;

	public function __construct()
	{
		$this->employee_number = Tables\Columns\TextColumn::make('employee_number')
			->toggleable()
			->label('Employee no.')
			->searchable(isIndividual: true, isGlobal: true)
			->placeholder('-')
			->sortable();

		$this->employee_full_name = Tables\Columns\TextColumn::make('employee.full_name')
			->toggleable()
			->label('Employee name')
			->searchable(isIndividual: true, isGlobal: true)
			->copyable()
			->placeholder('-')
			->sortable();

		$this->contact_number = Tables\Columns\TextColumn::make('contact_number')
			->toggleable()
			->searchable(isIndividual: true, isGlobal: true)
			->placeholder('-')
			->copyable()
			->sortable();

		$this->arrived = ToggleColumn::make('arrived')
			->toggleable()
			->toggledHiddenByDefault();

		$this->visa_expired = ToggleColumn::make('visa_expired')
			->toggleable()
			->toggledHiddenByDefault();

		$this->status = Tables\Columns\TextColumn::make('status')
			->placeholder('-')
			->toggleable()
			->toggledHiddenByDefault()
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
			->sortable();

		$this->start_date = Tables\Columns\TextColumn::make('start_date')
			->placeholder('-')
			->toggleable()
			->label('Departure date')
			->date()
			->copyable()
			->sortable();

		$this->end_date = Tables\Columns\TextColumn::make('end_date')
			->placeholder('-')
			->toggleable()
			->label('Return date')
			->date()
			->copyable()
			->sortable();

		$this->duration_in_days = Tables\Columns\TextColumn::make('duration_in_days')
			->placeholder('-')
			->toggleable()
			->label('Leave duration')
			->state(fn(EmployeeLeave $record) => $record->duration_in_days ? "{$record->duration_in_days} " . Pluralizer::plural('day', $record->duration_in_days) : null)
			->placeholder('-')
			->copyable();

		$this->remaining_leave_days = Tables\Columns\TextColumn::make('leave_remaining_days')
			->toggleable()
			->label('Leave remaining days')
			->state(fn(EmployeeLeave $record) => $record->leave_remaining_days ? "{$record->leave_remaining_days} " . Pluralizer::plural('day', $record->leave_remaining_days) : null)
			->placeholder('-')
			->copyable();

		$this->visa_expiration = Tables\Columns\TextColumn::make('visa_expiration')
			->placeholder('-')
			->toggleable()
			->date()
			->copyable()
			->sortable();

		$this->visa_duration_in_days = Tables\Columns\TextColumn::make('visa_duration_in_days')
			->placeholder('-')
			->toggleable()
			->label('Visa duration')
			->state(fn(EmployeeLeave $record) => "{$record->visa_duration_in_days} " . Pluralizer::plural('day', $record->visa_duration_in_days))
			->copyable();

		$this->visa_remaining_days = Tables\Columns\TextColumn::make('visa_remaining_days')
			->toggleable()
			->label('Visa remaining days')
			->state(fn(EmployeeLeave $record) => $record->visa_remaining_days != null ? ("{$record->visa_remaining_days} " . Pluralizer::plural('day', $record->visa_remaining_days)) : null)
			->placeholder('-')
			->copyable();

		$this->request_file_link = Tables\Columns\TextColumn::make('request_file_link')
			->toggleable()
			->url(fn(EmployeeLeave $record) => $record->request_file_link)
			->color('info')
			->placeholder('-');

		$this->created_at = Tables\Columns\TextColumn::make('created_at')
			->toggleable()
			->copyable()
			->dateTime()
			->sortable();

		$this->updated_at = Tables\Columns\TextColumn::make('updated_at')
			->toggleable()
			->copyable()
			->dateTime()
			->sortable();
	}

	public static function getColumns(?array $columns = null)
	{
		$table = new EmployeeLeaveTable();
		return $columns ?? [
			$table->employee_number,
			$table->employee_full_name,
			$table->contact_number,
			$table->status,
			$table->arrived,
			$table->visa_expired,
			$table->start_date,
			$table->end_date,
			$table->duration_in_days,
			$table->remaining_leave_days,
			$table->visa_expiration,
			$table->visa_duration_in_days,
			$table->visa_remaining_days,
			$table->request_file_link,
			$table->created_at,
			$table->updated_at,
		];
	}

	public static function getBulkActions()
	{
		return [
			Tables\Actions\DeleteBulkAction::make(),
			Tables\Actions\BulkActionGroup::make([
				Tables\Actions\BulkAction::make('Mark as arrived')
					->requiresConfirmation()
					->color('info')
					->icon('heroicon-o-check-circle')
					->deselectRecordsAfterCompletion()
					->action(fn(Collection $records) => $records->each(fn($record) => $record->update(['arrived' => true]))),
				Tables\Actions\BulkAction::make('Mark as visa expired')
					->requiresConfirmation()
					->color('danger')
					->icon('heroicon-o-exclamation-triangle')
					->deselectRecordsAfterCompletion()
					->action(fn(Collection $records) => $records->each(fn($record) => $record->update(['visa_expired' => true]))),
				Tables\Actions\BulkAction::make('Clear status')
					->requiresConfirmation()
					->color('gray')
					->icon('heroicon-o-arrow-uturn-down')
					->deselectRecordsAfterCompletion()
					->action(fn(Collection $records) => $records->each(fn($record) => $record->update(['arrived' => false, 'visa_expired' => false]))),
			])
				->label('Change status')
				->icon('heroicon-o-check-circle'),
			ExportBulkAction::make()
				->icon('heroicon-o-arrow-down-tray')
				->exporter(EmployeeLeaveExporter::class),
		];
	}

	public static function getFilters($statusOptions)
	{
		$statusOptions = $statusOptions ?? [
			'Visa expired (Resolved)' => 'Visa expired (Resolved)',
			'Arrived (Resolved)' => 'Arrived (Resolved)',
			'On vacation' => 'On vacation',
			'For vacation' => 'For vacation',
			'Visa expired' => 'Visa expired',
			'Arrival expected' => 'Arrival expected',
		];

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
			SelectFilter::make('status')
				->options($statusOptions)
				->multiple()
				->hidden(condition: $statusOptions === []),
			QueryBuilder::make()
				->constraints([
					DateConstraint::make('start_date')
						->label('Departure date')
						->icon('heroicon-o-calendar'),
					DateConstraint::make('end_date')
						->label('Return date')
						->icon('heroicon-o-calendar'),
					DateConstraint::make('visa_expiration')
						->label('Visa expiration')
						->icon('heroicon-o-calendar'),
					NumberConstraint::make('duration_in_days')
						->icon('heroicon-o-hashtag'),
					NumberConstraint::make('visa_duration_in_days')
						->icon('heroicon-o-hashtag'),
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

	public static function getTable(Table $table, ?array $columns = null, ?array $statusOptions = null)
	{
		return $table
			->recordUrl(
				fn(EmployeeLeave $record): string => ViewEmployee::getUrl([$record->employee_number]),
			)
			->searchOnBlur()
			->defaultSort('start_date', 'desc')
			->columns(EmployeeLeaveTable::getColumns(columns: $columns))
			->filters(EmployeeLeaveTable::getFilters(statusOptions: $statusOptions), layout: FiltersLayout::Modal)
			->filtersFormWidth(MaxWidth::TwoExtraLarge)
			->actions(EmployeeLeaveTable::getActions())
			->actions(EmployeeLeaveTable::getActions(), position: ActionsPosition::BeforeColumns)
			->bulkActions(EmployeeLeaveTable::getBulkActions())
			->defaultSort('start_date', 'desc');
	}

	public static function getHeaderActions()
	{
		return [
			ImportAction::make()
				->icon('heroicon-o-arrow-up-tray')
				->importer(EmployeeLeaveImporter::class),
			Actions\CreateAction::make(),
		];
	}
}
