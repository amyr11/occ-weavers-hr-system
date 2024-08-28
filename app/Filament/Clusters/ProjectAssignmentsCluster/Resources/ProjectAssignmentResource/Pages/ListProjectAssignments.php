<?php

namespace App\Filament\Clusters\ProjectAssignmentsCluster\Resources\ProjectAssignmentResource\Pages;

use App\Filament\Clusters\ProjectAssignmentsCluster\Resources\ProjectAssignmentResource;
use App\Filament\Clusters\ProjectAssignmentsCluster\Resources\ProjectAssignmentTable;
use Filament\Resources\Pages\ListRecords;

class ListProjectAssignments extends ListRecords
{
    protected static string $resource = ProjectAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return ProjectAssignmentTable::getHeaderActions();
    }
}
