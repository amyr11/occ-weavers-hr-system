<?php

namespace App\Observers;

use App\Models\Contract;
use App\Models\Employee;

class ContractObserver
{
    private function updateEmployeeContractDates(Employee $employee): void
    {
        $latestContract = $employee->contracts()->latest('end_date')->first();
        $employee->employee_job_id = $latestContract ? $latestContract->employee_job_id : null;
        $employee->electronic_contract_start_date = $latestContract ? $latestContract->start_date : null;
        $employee->electronic_contract_end_date = $latestContract ? $latestContract->end_date : null;
        $employee->paper_contract_end_date = $latestContract ? $latestContract->paper_contract_end_date : null;
    }

    /**
     * Handle the Contract "created" event.
     */
    public function created(Contract $contract): void
    {
        $employee = $contract->employee;

        // Modify the current_leave_days of the employee
        $employee->addLeaves($employee->max_leave_days * $contract->getDurationInYears());

        $this->updateEmployeeContractDates($employee);

        $employee->save();
    }

    /**
     * Handle the Contract "updated" event.
     */
    public function updated(Contract $contract): void
    {
        $employee = $contract->employee;

        // Modify the current_leave_days of the employee
        $employee->addLeaves(($contract->getDurationInYears() - $contract->getOriginal('duration_in_years')) * $employee->max_leave_days);

        $this->updateEmployeeContractDates($employee);

        $employee->save();
    }

    /**
     * Handle the Contract "deleted" event.
     */
    public function deleted(Contract $contract): void
    {
        $employee = $contract->employee;

        // Modify the current_leave_days of the employee
        $employee->addLeaves(-$contract->getDurationInYears() * $employee->max_leave_days);

        $this->updateEmployeeContractDates($employee);

        $employee->save();
    }

    /**
     * Handle the Contract "restored" event.
     */
    public function restored(Contract $contract): void
    {
        $employee = $contract->employee;

        // Modify the current_leave_days of the employee
        $employee->addLeaves($employee->max_leave_days * $contract->getDurationInYears());

        $this->updateEmployeeContractDates($employee);

        $employee->save();
    }

    /**
     * Handle the Contract "force deleted" event.
     */
    public function forceDeleted(Contract $contract): void
    {
        $employee = $contract->employee;

        // Modify the current_leave_days of the employee
        $employee->addLeaves(-$contract->getDurationInYears() * $employee->max_leave_days);

        $this->updateEmployeeContractDates($employee);

        $employee->save();
    }
}
