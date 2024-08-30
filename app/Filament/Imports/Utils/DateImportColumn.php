<?php

namespace App\Filament\Imports\Utils;

use Carbon\Carbon;
use Closure;
use Filament\Actions\Imports\ImportColumn;

class DateImportColumn extends ImportColumn
{
	protected array | Closure $dataValidationRules = ['nullable', 'date'];

	public static function make(string $name): static
	{
		$static = parent::make($name);

		$static->castStateUsing = function ($state) {
			if ($state === null) {
				return null;
			}

			return Carbon::createFromFormat(config('app.date_format'), $state);
		};

		return $static;
	}
}
