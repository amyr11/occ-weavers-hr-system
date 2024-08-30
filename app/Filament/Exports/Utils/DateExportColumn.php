<?php

namespace App\Filament\Exports\Utils;

use Filament\Actions\Exports\ExportColumn;

class DateExportColumn extends ExportColumn
{
	public static function make(string $name): static
	{
		$static = parent::make($name);

		$static->formatStateUsing(function ($state) {
			if ($state === null) {
				return null;
			}

			return $state->format(config('app.date_format'));
		});

		return $static;
	}
}
