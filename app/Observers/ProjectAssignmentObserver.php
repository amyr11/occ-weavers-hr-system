<?php

namespace App\Observers;

use App\Models\Employee;
use App\Models\ProjectAssignment;

class ProjectAssignmentObserver
{
    private function setEmployeeCurrentProject(Employee $employee): void
    {
        $latestProjectAssignment = $employee->projectAssignments()->latest('transfer_date')->first();
        $employee->project_id = $latestProjectAssignment ? $latestProjectAssignment->project_id : null;
        $employee->save();
    }
    
    /**
     * Handle the ProjectAssignment "created" event.
     */
    public function created(ProjectAssignment $projectAssignment): void
    {
        $this->setEmployeeCurrentProject($projectAssignment->employee);
    }

    /**
     * Handle the ProjectAssignment "updated" event.
     */
    public function updated(ProjectAssignment $projectAssignment): void
    {
        $this->setEmployeeCurrentProject($projectAssignment->employee);
    }

    /**
     * Handle the ProjectAssignment "deleted" event.
     */
    public function deleted(ProjectAssignment $projectAssignment): void
    {
        $this->setEmployeeCurrentProject($projectAssignment->employee);
    }

    /**
     * Handle the ProjectAssignment "restored" event.
     */
    public function restored(ProjectAssignment $projectAssignment): void
    {
        $this->setEmployeeCurrentProject($projectAssignment->employee);
    }

    /**
     * Handle the ProjectAssignment "force deleted" event.
     */
    public function forceDeleted(ProjectAssignment $projectAssignment): void
    {
        $this->setEmployeeCurrentProject($projectAssignment->employee);
    }
}
