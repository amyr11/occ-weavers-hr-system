<?php

namespace App\Observers;

use App\Models\EmployeeLeave;

class EmployeeLeaveObserver
{
    /**
     * Handle the EmployeeLeave "created" event.
     */
    public function created(EmployeeLeave $employeeLeave): void
    {
        // Modify the current_leave_days of the employee
        $employee = $employeeLeave->employee;
        $employee->current_leave_days -= $employeeLeave->duration_in_days;
        $employee->save();
    }

    /**
     * Handle the EmployeeLeave "updated" event.
     */
    public function updated(EmployeeLeave $employeeLeave): void
    {
        // Modify the current_leave_days of the employee
        $employee = $employeeLeave->employee;
        $employee->current_leave_days += $employeeLeave->getOriginal('duration_in_days') - $employeeLeave->duration_in_days;
        $employee->save();
    }

    /**
     * Handle the EmployeeLeave "deleted" event.
     */
    public function deleted(EmployeeLeave $employeeLeave): void
    {
        // Modify the current_leave_days of the employee
        $employee = $employeeLeave->employee;
        $employee->current_leave_days += $employeeLeave->duration_in_days;
        $employee->save();
    }

    /**
     * Handle the EmployeeLeave "restored" event.
     */
    public function restored(EmployeeLeave $employeeLeave): void
    {
        // Modify the current_leave_days of the employee
        $employee = $employeeLeave->employee;
        $employee->current_leave_days -= $employeeLeave->duration_in_days;
        $employee->save();
    }

    /**
     * Handle the EmployeeLeave "force deleted" event.
     */
    public function forceDeleted(EmployeeLeave $employeeLeave): void
    {
        // Modify the current_leave_days of the employee
        $employee = $employeeLeave->employee;
        $employee->current_leave_days += $employeeLeave->duration_in_days;
        $employee->save();
    }
}
