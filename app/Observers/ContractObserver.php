<?php

namespace App\Observers;

use App\Models\Contract;
use App\Models\Employee;

class ContractObserver
{
    private function updateEmployeeContractDates(Contract $contract): void
    {
        $employee = $contract->employee;
        $latestContract = $employee->contracts()->latest('end_date')->first();

        $employee->employee_job_id = $latestContract ? $latestContract->employee_job_id : null;
        $employee->electronic_contract_start_date = $latestContract ? $latestContract->start_date : null;
        $employee->electronic_contract_end_date = $latestContract ? $latestContract->end_date : null;
        $employee->paper_contract_end_date = $latestContract ? $latestContract->paper_contract_end_date : null;

        $employee->save();
    }

    /**
     * Handle the Contract "created" event.
     */
    public function created(Contract $contract): void
    {
        $this->updateEmployeeContractDates($contract);
    }

    /**
     * Handle the Contract "updated" event.
     */
    public function updated(Contract $contract): void
    {
        $this->updateEmployeeContractDates($contract);
    }

    /**
     * Handle the Contract "deleted" event.
     */
    public function deleted(Contract $contract): void
    {
        $this->updateEmployeeContractDates($contract);
    }

    /**
     * Handle the Contract "restored" event.
     */
    public function restored(Contract $contract): void
    {
        $this->updateEmployeeContractDates($contract);
    }

    /**
     * Handle the Contract "force deleted" event.
     */
    public function forceDeleted(Contract $contract): void
    {
        $this->updateEmployeeContractDates($contract);
    }
}
