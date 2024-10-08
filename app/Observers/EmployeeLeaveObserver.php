<?php

namespace App\Observers;

use App\Models\EmployeeLeave;

class EmployeeLeaveObserver
{
    private function updateEmployeeStatus(EmployeeLeave $employeeLeave): void
    {
        $employee = $employeeLeave->employee;

        // Only one toggle is allowed between arrived and visa_expired
        if ($employeeLeave->isDirty('arrived') && $employeeLeave->arrived) {
            $this->setEmployeeStatus($employeeLeave, 'Arrived (Resolved)');
        } elseif ($employeeLeave->isDirty('visa_expired')) {
            if ($employeeLeave->visa_expired) {
                $this->setEmployeeStatus($employeeLeave, 'Visa expired (Resolved)');
            } else {
                $employee->visa_expired_date = null;
            }
        }
    }

    private function setEmployeeStatus(EmployeeLeave $employeeLeave, string $status)
    {
        $employee = $employeeLeave->employee;

        // Only one toggle is allowed between arrived and visa_expired
        if ($status == 'Arrived (Resolved)') {
            $employeeLeave->visa_expired = false;
            $employee->visa_expired_date = null;
        } elseif ($status == 'Visa expired (Resolved)') {
            $employeeLeave->arrived = false;
            $employee->visa_expired_date = $employeeLeave->visa_expiration;
        }
    }

    /**
     * Handle the EmployeeLeave "created" event.
     */
    public function created(EmployeeLeave $employeeLeave): void
    {
        $employee = $employeeLeave->employee;
        $this->updateEmployeeStatus($employeeLeave);
        $employeeLeave->calculateVisaDurationDays();

        $employee->save();
        $employeeLeave->saveQuietly();
    }

    /**
     * Handle the EmployeeLeave "updated" event.
     */
    public function updated(EmployeeLeave $employeeLeave): void
    {
        $employee = $employeeLeave->employee;
        $this->updateEmployeeStatus($employeeLeave);
        $employeeLeave->calculateVisaDurationDays();

        $employee->save();
        $employeeLeave->saveQuietly();
    }

    /**
     * Handle the EmployeeLeave "deleted" event.
     */
    public function deleted(EmployeeLeave $employeeLeave): void
    {
        $employee = $employeeLeave->employee;
        $employee->visa_expired_date = null;

        $employee->save();
    }

    /**
     * Handle the EmployeeLeave "restored" event.
     */
    public function restored(EmployeeLeave $employeeLeave): void
    {
        $employee = $employeeLeave->employee;
        $this->setEmployeeStatus($employeeLeave, $employeeLeave->status);

        $employee->save();
        $employeeLeave->saveQuietly();
    }

    /**
     * Handle the EmployeeLeave "force deleted" event.
     */
    public function forceDeleted(EmployeeLeave $employeeLeave): void
    {
        $employee = $employeeLeave->employee;
        $employee->visa_expired_date = null;

        $employee->save();
        $employeeLeave->saveQuietly();
    }
}
