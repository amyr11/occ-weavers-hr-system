<?php

namespace App\Observers;

use App\Models\Contract;
use App\Models\Employee;

class ContractObserver
{
    private function setEmployeeCurrentJobTitle(Employee $employee): void
    {
        $latestContract = $employee->contracts()->latest('end_date')->first();
        $employee->employee_job_id = $latestContract ? $latestContract->employee_job_id : null;
        $employee->save();
    }
    
    /**
     * Handle the Contract "created" event.
     */
    public function created(Contract $contract): void
    {
        $this->setEmployeeCurrentJobTitle($contract->employee);
    }

    /**
     * Handle the Contract "updated" event.
     */
    public function updated(Contract $contract): void
    {
        $this->setEmployeeCurrentJobTitle($contract->employee);
    }

    /**
     * Handle the Contract "deleted" event.
     */
    public function deleted(Contract $contract): void
    {
        $this->setEmployeeCurrentJobTitle($contract->employee);
    }

    /**
     * Handle the Contract "restored" event.
     */
    public function restored(Contract $contract): void
    {
        $this->setEmployeeCurrentJobTitle($contract->employee);
    }

    /**
     * Handle the Contract "force deleted" event.
     */
    public function forceDeleted(Contract $contract): void
    {
        $this->setEmployeeCurrentJobTitle($contract->employee);
    }
}
