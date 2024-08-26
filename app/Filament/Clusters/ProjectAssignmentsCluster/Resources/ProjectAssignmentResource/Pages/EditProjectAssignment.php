<?php

namespace App\Filament\Clusters\ProjectAssignmentsCluster\Resources\ProjectAssignmentResource\Pages;

use App\Filament\Clusters\ProjectAssignmentsCluster\Resources\ProjectAssignmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectAssignment extends EditRecord
{
    protected static string $resource = ProjectAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
