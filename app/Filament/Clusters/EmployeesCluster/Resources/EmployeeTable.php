<?php

namespace App\Filament\Clusters\EmployeesCluster\Resources;

use App\Filament\Clusters\EmployeesCluster\Resources\EmployeesClusterResource\RelationManagers\BonusesRelationManager;
use App\Filament\Clusters\EmployeesCluster\Resources\EmployeesClusterResource\RelationManagers\ContractsRelationManager;
use App\Filament\Clusters\EmployeesCluster\Resources\EmployeesClusterResource\RelationManagers\LeavesRelationManager;
use App\Filament\Clusters\EmployeesCluster\Resources\EmployeesClusterResource\RelationManagers\ProjectAssignmentsRelationManager;
use App\Filament\Exports\EmployeeExporter;
use App\Filament\Imports\EmployeeImporter;
use App\Models\Employee;
use App\Utils\TableUtil;
use Carbon\Carbon;
use Closure;
use Filament\Actions\ImportAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Pluralizer;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Spatie\LaravelPdf\Enums\Format;

use function Spatie\LaravelPdf\Support\pdf;

class EmployeeTable
{
	public static function getSchema()
	{
		return [
			Section::make('Personal Information')
				->icon('heroicon-o-user')
				->collapsible()
				->schema([
					FileUpload::make('image')
						->image()
						->avatar()
						->imageEditor()
						->moveFiles()
						->directory('employee-images')
						->visibility('private')
						->maxSize(8000)
						->previewable()
						->downloadable(),
					Grid::make([
						'md' => 3,
					])
						->schema([
							TextInput::make('full_name')
								->columnSpan(2)
								->required(),
							TextInput::make('employee_number')
								->label('Employee no.')
						]),
					Grid::make([
						'md' => 3,
					])
						->schema([
							Select::make('country_id')
								->relationship('country', 'name')
								->preload()
								->createOptionForm(function () {
									return [
										TextInput::make('name')
											->label('Country')
											->required(),
									];
								})
								->searchable(),
							TextInput::make('mobile_number'),
							TextInput::make('email')
								->email(),
						]),
					Grid::make([
						'md' => 2,
					])
						->schema([
							DatePicker::make('birthdate'),
							TextInput::make('age')
								->numeric()
								->hiddenOn(['create'])
								->disabled(),
						]),
				]),
			Section::make('Company information')
				->icon('heroicon-o-building-office')
				->collapsible()
				->schema([
					Grid::make([
						'md' => 2,
					])
						->schema([
							Select::make('employee_job_id')
								->label('Current job title')
								->relationship('employeeJob', 'job_title')
								->disabled(),
							Select::make('project_id')
								->label('Current project')
								->relationship('project', 'project_name')
								->preload()
								->searchable()
								->createOptionForm(function () {
									return [
										TextInput::make('project_name')
											->label('Project Name')
											->required(),
									];
								}),
						]),
					Grid::make([
						'md' => 4,
					])
						->schema([
							DatePicker::make('electronic_contract_start_date')
								->disabled(),
							DatePicker::make('electronic_contract_end_date')
								->disabled(),
							DatePicker::make('paper_contract_start_date')
								->disabled(),
							DatePicker::make('paper_contract_end_date')
								->disabled(),
						]),
					Grid::make([
						'md' => 2,
					])
						->schema([
							DatePicker::make('company_start_date'),
							Select::make('insurance_class_id')
								->relationship('insuranceClass', 'name')
								->searchable()
								->preload()
								->createOptionForm(function () {
									return [
										TextInput::make('name')
											->label('Insurance Class')
											->required(),
									];
								}),
						]),
					Grid::make([
						'md' => 3,
					])
						->schema([
							DatePicker::make('final_exit_date'),
							DatePicker::make('visa_expired_date'),
							DatePicker::make('transferred_date'),
						]),
				]),
			Section::make('Government information')
				->icon('heroicon-o-identification')
				->collapsible()
				->schema([
					Grid::make([
						'md' => 2,
					])
						->schema([
							TextInput::make('labor_office_number'),
							TextInput::make('iban_number')
								->label('IBAN Number'),
						]),
					Grid::make([
						'md' => 4,
					])
						->schema([
							TextInput::make('iqama_number')
								->label('IQAMA Number'),
							TextInput::make('iqama_job_title')
								->label('IQAMA Job Title'),
							TextInput::make('iqama_expiration_hijri')
								->label('IQAMA Expiration (Hijri)')
								->placeholder('YYYY-MM-DD')
								->rules([
									fn(): Closure => function (string $attribute, $value, Closure $fail) {
										/**
										 * in the format Y-m-d
										 * year between 1000 and 1999
										 * month between 1 and 12
										 * day between 1 and 30
										 */
										if (!preg_match('/^(1[0-9]{3})-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $value)) {
											$fail('The ' . $attribute . ' is not in the correct format.');
										}
									},
								]),
							DatePicker::make('iqama_expiration_gregorian')
								->label('IQAMA Expiration (Gregorian)')
								->disabled()
								->hiddenOn(['create']),
						]),
					Grid::make([
						'md' => 3,
					])
						->schema([
							TextInput::make('passport_number'),
							DatePicker::make('passport_date_issue'),
							DatePicker::make('passport_expiration'),
						]),
					Grid::make([
						'md' => 2,
					])
						->schema([
							DatePicker::make('sce_expiration')
								->label('SCE Expiration'),
						]),
				]),
		];
	}

	public Column $employee_number;
	public Column $full_name;
	public Column $status;
	public Column $employeeJob_job_title;
	public Column $project_project_name;
	public Column $country_name;
	public Column $age;
	public Column $email;
	public Column $mobile_number;
	public Column $labor_office_number;
	public Column $iban_number;
	public Column $iqama_number;
	public Column $iqama_job_title;
	public Column $iqama_expiration_hijri;
	public Column $iqama_expiration_gregorian;
	public Column $iqama_expiration_remaining_days;
	public Column $passport_number;
	public Column $passport_date_issue;
	public Column $passport_expiration;
	public Column $sce_expiration;
	public Column $insuranceClass_name;
	public Column $company_start_date;
	public Column $electronic_contract_start_date;
	public Column $electronic_contract_end_date;
	public Column $paper_contract_start_date;
	public Column $paper_contract_end_date;
	public Column $final_exit_date;
	public Column $visa_expired_date;
	public Column $transferred_date;
	public Column $created_at;
	public Column $updated_at;

	public function __construct()
	{
		$this->employee_number = TextColumn::make('employee_number')
			->label('No.')
			->toggleable()
			->copyable()
			->placeholder('-')
			->searchable()
			->sortable()
			->searchable(isIndividual: true, isGlobal: true)
			->extraAttributes([
				'style' => 'min-width: 150px',
			]);

		$this->full_name = TextColumn::make('full_name')
			->copyable()
			->toggleable()
			->searchable()
			->placeholder('-')
			->sortable()
			->searchable(isIndividual: true, isGlobal: true)
			->extraAttributes([
				'style' => 'min-width: 200px',
			]);

		$this->status = TextColumn::make('status')
			->badge()
			->color(fn(string $state): string => match ($state) {
				'Active' => 'success',
				'Final Exit' => 'danger',
				'Visa Expired' => 'warning',
				'Transferred' => 'info',
				default => 'gray',
			})
			->toggleable()
			->placeholder('-')
			->sortable();

		$this->employeeJob_job_title = TextColumn::make('employeeJob.job_title')
			->label('Current job title')
			->placeholder('-')
			->toggleable()
			->sortable()
			->copyable();

		$this->project_project_name = TextColumn::make('project.project_name')
			->label('Current project')
			->placeholder('-')
			->toggleable()
			->sortable()
			->copyable();

		$this->country_name = TextColumn::make('country.name')
			->label('Country')
			->toggleable()
			->placeholder('-')
			->sortable();

		$this->age = TextColumn::make('age')
			->copyable()
			->toggleable()
			->placeholder('-')
			->sortable();

		$this->email = TextColumn::make('email')
			->copyable()
			->toggleable()
			->placeholder('-')
			->sortable()
			->searchable(isIndividual: true, isGlobal: true)
			->extraAttributes([
				'style' => 'min-width: 200px',
			]);

		$this->mobile_number = TextColumn::make('mobile_number')
			->label('Mobile no.')
			->toggleable()
			->placeholder('-')
			->searchable(isIndividual: true, isGlobal: true)
			->copyable()
			->sortable()
			->extraAttributes([
				'style' => 'min-width: 200px',
			]);

		$this->labor_office_number = TextColumn::make('labor_office_number')
			->label('Labor Office no.')
			->toggleable()
			->searchable(isIndividual: true, isGlobal: true)
			->copyable()
			->placeholder('-')
			->sortable()
			->extraAttributes([
				'style' => 'min-width: 200px',
			]);

		$this->iban_number = TextColumn::make('iban_number')
			->label('IBAN no.')
			->toggleable()
			->searchable(isIndividual: true, isGlobal: true)
			->copyable()
			->placeholder('-')
			->sortable()
			->extraAttributes([
				'style' => 'min-width: 200px',
			]);

		$this->iqama_number = TextColumn::make('iqama_number')
			->label('IQAMA no.')
			->toggleable()
			->searchable(isIndividual: true, isGlobal: true)
			->copyable()
			->placeholder('-')
			->sortable()
			->extraAttributes([
				'style' => 'min-width: 200px',
			]);

		$this->iqama_job_title = TextColumn::make('iqama_job_title')
			->label('IQAMA Job Title')
			->toggleable()
			->searchable(isIndividual: true, isGlobal: true)
			->copyable()
			->sortable()
			->placeholder('-')
			->extraAttributes([
				'style' => 'min-width: 200px',
			]);

		$this->iqama_expiration_hijri = TextColumn::make('iqama_expiration_hijri')
			->label('IQAMA Expiration (Hijri)')
			->toggleable()
			->copyable()
			->placeholder('-')
			->sortable();

		$this->iqama_expiration_gregorian = TextColumn::make('iqama_expiration_gregorian')
			->label('IQAMA Expiration (Gregorian)')
			->toggleable()
			->copyable()
			->date()
			->placeholder('-')
			->sortable();

		$this->iqama_expiration_remaining_days = TextColumn::make('iqama_expiration_remaining_days')
			->label('Remaining days (IQAMA expiration)')
			->state(fn(Employee $record) => $record->iqama_expiration_remaining_days != null ? "{$record->iqama_expiration_remaining_days} " . Pluralizer::plural('day', $record->iqama_expiration_remaining_days) : null)
			->placeholder('-')
			->toggleable()
			->toggledHiddenByDefault()
			->sortable();

		$this->passport_number = TextColumn::make('passport_number')
			->label('Passport no.')
			->toggleable()
			->searchable(isIndividual: true, isGlobal: true)
			->copyable()
			->placeholder('-')
			->sortable()
			->extraAttributes([
				'style' => 'min-width: 200px',
			]);

		$this->passport_date_issue = TextColumn::make('passport_date_issue')
			->date()
			->toggleable()
			->placeholder('-')
			->copyable()
			->sortable();

		$this->passport_expiration = TextColumn::make('passport_expiration')
			->date()
			->toggleable()
			->copyable()
			->placeholder('-')
			->sortable();

		$this->sce_expiration = TextColumn::make('sce_expiration')
			->label('SCE Expiration')
			->toggleable()
			->copyable()
			->placeholder('-')
			->date()
			->sortable();

		$this->insuranceClass_name = TextColumn::make('insuranceClass.name')
			->copyable()
			->toggleable()
			->placeholder('-')
			->sortable();

		$this->company_start_date = TextColumn::make('company_start_date')
			->date()
			->toggleable()
			->copyable()
			->placeholder('-')
			->sortable();

		$this->electronic_contract_start_date = TextColumn::make('electronic_contract_start_date')
			->date()
			->toggleable()
			->copyable()
			->placeholder('-')
			->sortable();

		$this->electronic_contract_end_date = TextColumn::make('electronic_contract_end_date')
			->date()
			->toggleable()
			->copyable()
			->placeholder('-')
			->sortable();

		$this->paper_contract_start_date = TextColumn::make('paper_contract_start_date')
			->date()
			->toggleable()
			->copyable()
			->placeholder('-')
			->sortable();

		$this->paper_contract_end_date = TextColumn::make('paper_contract_end_date')
			->date()
			->toggleable()
			->copyable()
			->placeholder('-')
			->sortable();

		$this->final_exit_date = TextColumn::make('final_exit_date')
			->date()
			->toggleable()
			->copyable()
			->placeholder('-')
			->sortable();

		$this->visa_expired_date = TextColumn::make('visa_expired_date')
			->date()
			->toggleable()
			->copyable()
			->placeholder('-')
			->sortable();

		$this->transferred_date = TextColumn::make('transferred_date')
			->date()
			->toggleable()
			->copyable()
			->placeholder('-')
			->sortable();

		$this->created_at = TextColumn::make('created_at')
			->copyable()
			->toggleable()
			->placeholder('-')
			->sortable();

		$this->updated_at = TextColumn::make('updated_at')
			->copyable()
			->toggleable()
			->placeholder('-')
			->sortable();
	}

	public static function getColumns(?array $columns = null)
	{
		$table = new EmployeeTable();

		return $columns ?? [
			$table->employee_number,
			$table->full_name,
			$table->status,
			$table->employeeJob_job_title,
			$table->project_project_name,
			$table->country_name,
			$table->age,
			$table->email,
			$table->mobile_number,
			$table->labor_office_number,
			$table->iban_number,
			$table->iqama_number,
			$table->iqama_job_title,
			$table->iqama_expiration_hijri,
			$table->iqama_expiration_gregorian,
			$table->iqama_expiration_remaining_days,
			$table->passport_number,
			$table->passport_date_issue,
			$table->passport_expiration,
			$table->sce_expiration,
			$table->insuranceClass_name,
			$table->company_start_date,
			$table->electronic_contract_start_date,
			$table->electronic_contract_end_date,
			$table->paper_contract_start_date,
			$table->paper_contract_end_date,
			$table->final_exit_date,
			$table->visa_expired_date,
			$table->transferred_date,
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
			SelectFilter::make('status')
				->multiple()
				->options([
					'Active' => 'Active',
					'Final Exit' => 'Final Exit',
					'Visa Expired' => 'Visa Expired',
					'Transferred' => 'Transferred',
				]),
			SelectFilter::make('employee_job_id')
				->label('Current job title')
				->multiple()
				->preload()
				->relationship('employeeJob', 'job_title')
				->options(function () {
					return \App\Models\EmployeeJob::pluck('job_title', 'id');
				}),
			SelectFilter::make('project_id')
				->label('Current project')
				->multiple()
				->preload()
				->relationship('project', 'project_name')
				->options(function () {
					return \App\Models\Project::pluck('project_name', 'id');
				}),
			SelectFilter::make('country_id')
				->multiple()
				->label('Country')
				->preload()
				->relationship('country', 'name')
				->options(function () {
					return \App\Models\Country::pluck('name', 'id');
				})
				->searchable(),
			SelectFilter::make('insurance_class_id')
				->label('Insurance Class')
				->multiple()
				->preload()
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
					DateConstraint::make('electronic_contract_start_date')
						->icon('heroicon-o-calendar'),
					DateConstraint::make('electronic_contract_end_date')
						->icon('heroicon-o-calendar'),
					DateConstraint::make('paper_contract_start_date')
						->icon('heroicon-o-calendar'),
					DateConstraint::make('paper_contract_end_date')
						->icon('heroicon-o-calendar'),
					DateConstraint::make('final_exit_date')
						->icon('heroicon-o-calendar'),
					DateConstraint::make('visa_expired_date')
						->icon('heroicon-o-calendar'),
					DateConstraint::make('transferred_date')
						->icon('heroicon-o-calendar'),
				])
		];
	}

	public static function getActions()
	{
		return [
			Tables\Actions\ViewAction::make(),
			Tables\Actions\EditAction::make(),
			Tables\Actions\Action::make('file_information_sheet')
				->label('PDF')
				->color('danger')
				->icon('heroicon-s-document')
				->action(function (Model $record) {
					return self::downloadPdf($record);
				}),
		];
	}

	public static function getViewHeaderActions(): array
	{
		return [
			Actions\Action::make('file_information_sheet')
				->label('PDF')
				->color('danger')
				->icon('heroicon-s-document')
				->action(function (Model $record) {
					return self::downloadPdf($record);
				}),
			Actions\EditAction::make(),
		];
	}

	public static function downloadPdf($record)
	{
		return response()->streamDownload(function () use ($record) {
			echo base64_decode(pdf()
				->view('pdf.file_information_sheet', ['employee' => $record])
				->format(Format::A4)
				->margins(5, 10, 5, 10)
				->base64());
		}, $record->employee_number . '-' . $record->full_name . '.pdf');
	}

	public static function getBulkActions()
	{
		return [
			Tables\Actions\DeleteBulkAction::make(),
			Tables\Actions\BulkActionGroup::make([
				TableUtil::getUpdateBulkAction(
					column: 'final_exit_date',
					icon: 'heroicon-o-calendar',
					color: 'danger',
					label: 'Mark as Final Exit',
					form: [
						DatePicker::make('final_exit_date')
							->label('Final Exit Date')
							->required(),
					]
				),
				TableUtil::getUpdateBulkAction(
					column: 'visa_expired_date',
					color: 'warning',
					icon: 'heroicon-o-calendar',
					label: 'Mark as Visa Expired',
					form: [
						DatePicker::make('visa_expired_date')
							->label('Visa Expired Date')
							->required(),
					]
				),
				TableUtil::getUpdateBulkAction(
					column: 'transferred_date',
					color: 'info',
					icon: 'heroicon-o-calendar',
					label: 'Mark as Transferred',
					form: [
						DatePicker::make('transferred_date')
							->label('Transferred Date')
							->required(),
					]
				),
				TableUtil::getUpdateBulkAction(
					column: 'mark_as_active',
					color: 'primary',
					icon: 'heroicon-o-check-circle',
					label: 'Mark as Active',
					action: function ($records, array $data): void {
						foreach ($records as $record) {
							$record->update([
								'final_exit_date' => null,
								'visa_expired_date' => null,
								'transferred_date' => null,
							]);
						}
					}
				),
				TableUtil::getUpdateBulkAction(
					column: 'country_id',
					icon: 'heroicon-o-flag',
					label: 'Country',
					form: [
						Select::make('country_id')
							->relationship('country', 'name')
							->preload()
							->createOptionForm(function () {
								return [
									TextInput::make('name')
										->label('Country'),
								];
							})
							->searchable(),
					]
				),
				TableUtil::getUpdateBulkAction(
					column: 'insurance_class_id',
					icon: 'heroicon-o-lifebuoy',
					label: 'Insurance Class',
					form: [
						Select::make('insurance_class_id')
							->relationship('insuranceClass', 'name')
							->searchable()
							->preload()
							->createOptionForm(function () {
								return [
									TextInput::make('name')
										->label('Insurance Class'),
								];
							}),
					]
				),
			])
				->label('Edit')
				->icon('heroicon-o-pencil'),
			ExportBulkAction::make()
				->icon('heroicon-o-arrow-down-tray')
				->exporter(EmployeeExporter::class),
		];
	}

	public static function getTable(Table $table, ?array $columns = null): Table
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
			->columns(EmployeeTable::getColumns($columns))
			->filters(EmployeeTable::getFilters(), layout: FiltersLayout::Modal)
			->filtersFormWidth(MaxWidth::TwoExtraLarge)
			->actions(EmployeeTable::getActions(), position: ActionsPosition::BeforeColumns)
			->bulkActions(EmployeeTable::getBulkActions())
			->defaultSort('updated_at', 'desc');
	}

	public static function getHeaderActions(): array
	{
		return [
			ImportAction::make()
				->icon('heroicon-o-arrow-up-tray')
				->importer(EmployeeImporter::class),
			Actions\CreateAction::make(),
		];
	}

	public static function getRelations()
	{
		return [
			ContractsRelationManager::class,
			LeavesRelationManager::class,
			BonusesRelationManager::class,
		];
	}
}
