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

        $employeeLeave->remaining_leave_days = $employee->current_leave_days;
        $employeeLeave->saveQuietly();
    }

    /**
     * Handle the EmployeeLeave "updated" event.
     */
    public function updated(EmployeeLeave $employeeLeave): void
    {
        // Modify the current_leave_days of the employee
        $employee = $employeeLeave->employee;
        $employee->current_leave_days += $employeeLeave->getOriginal('duration_in_days') - $employeeLeave->duration_in_days;

        $employeeLeave->remaining_leave_days = $employee->current_leave_days;

        // Only one toggle is allowed between arrived and visa_expired
        if ($employeeLeave->isDirty('arrived') && $employeeLeave->arrived) {
            $employeeLeave->visa_expired = false;
            $employee->visa_expired_date = null;
        } elseif ($employeeLeave->isDirty('visa_expired')) {
            if ($employeeLeave->visa_expired) {
                $employeeLeave->arrived = false;
                $employee->visa_expired_date = $employeeLeave->visa_expiration;
            } else {
                $employee->visa_expired_date = null;
            }
        }


        $employee->save();
        $employeeLeave->saveQuietly();
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

        $employeeLeave->remaining_leave_days = $employee->current_leave_days;
        $employeeLeave->saveQuietly();
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
