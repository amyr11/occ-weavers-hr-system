<?php

namespace App\Utils;

use Filament\Tables;

class TableUtil
{
	public static function getUpdateBulkAction($column, $icon, $label, $color = null, $form = null, $action = null): Tables\Actions\BulkAction
	{
		return Tables\Actions\BulkAction::make($column)
			->label($label)
			->requiresConfirmation()
			->color($color ?? null)
			->icon($icon)
			->deselectRecordsAfterCompletion()
			->action($action ?? function ($records, array $data): void {
				foreach ($records as $record) {
					$record->update($data);
				}
			})
			->form($form ?? []);
	}
}
