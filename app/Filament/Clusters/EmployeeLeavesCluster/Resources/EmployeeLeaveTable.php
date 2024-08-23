<?php

namespace App\Filament\Clusters\EmployeeLeavesCluster\Resources;

use Filament\Tables\Columns\ToggleColumn;
use App\Models\EmployeeLeave;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables;
use Illuminate\Support\Pluralizer;
use Illuminate\Database\Eloquent\Collection;


class EmployeeLeaveTable
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
					Forms\Components\Toggle::make('visa_expired')
						->default(false),
				]),
			Forms\Components\TextInput::make('request_file_link')
				->maxLength(255)
				->default(null),
		];
	}

	public static function getColumns()
	{
		return [
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
			Tables\Columns\TextColumn::make('contact_number')
				->toggleable()
				->copyable()
				->sortable(),
			ToggleColumn::make('arrived')
				->toggleable(),
			ToggleColumn::make('visa_expired')
				->toggleable(),
			Tables\Columns\TextColumn::make('status')
				->toggleable()
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
				->toggleable()
				->label('Departure date')
				->date()
				->copyable()
				->sortable(),
			Tables\Columns\TextColumn::make('end_date')
				->toggleable()
				->label('Return date')
				->date()
				->copyable()
				->sortable(),
			Tables\Columns\TextColumn::make('duration_in_days')
				->toggleable()
				->label('Leave duration')
				->state(fn(EmployeeLeave $record) => "{$record->duration_in_days} " . Pluralizer::plural('day', $record->duration_in_days))
				->copyable(),
			Tables\Columns\TextColumn::make('remaining_leave_days')
				->toggleable()
				->label('Leave balance')
				->state(fn(EmployeeLeave $record) => "{$record->remaining_leave_days} " . Pluralizer::plural('day', $record->remaining_leave_days))
				->copyable(),
			Tables\Columns\TextColumn::make('visa_expiration')
				->toggleable()
				->date()
				->copyable()
				->sortable(),
			Tables\Columns\TextColumn::make('visa_duration_in_days')
				->toggleable()
				->label('Visa duration')
				->state(fn(EmployeeLeave $record) => "{$record->visa_duration_in_days} " . Pluralizer::plural('day', $record->visa_duration_in_days))
				->copyable(),
			Tables\Columns\TextColumn::make('visa_remaining_days')
				->toggleable()
				->label('Visa remaining days')
				->state(fn(EmployeeLeave $record) => $record->visa_remaining_days != null ? ("{$record->visa_remaining_days} " . Pluralizer::plural('day', $record->visa_remaining_days)) : null)
				->placeholder('-')
				->copyable(),
			Tables\Columns\TextColumn::make('request_file_link')
				->toggleable()
				->url(fn(EmployeeLeave $record) => $record->request_file_link)
				->color('info')
				->placeholder('-'),
			Tables\Columns\TextColumn::make('created_at')
				->toggleable()
				->copyable()
				->dateTime()
				->sortable(),
			Tables\Columns\TextColumn::make('updated_at')
				->toggleable()
				->copyable()
				->dateTime()
				->sortable(),
		];
	}

	public static function getBulkActions()
	{
		return [
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
		];
	}
}
