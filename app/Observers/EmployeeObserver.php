<?php

namespace App\Observers;

use App\Models\Employee;
use App\Utils\HijriUtil;

class EmployeeObserver
{
    private function convertHijriDatesToGregorian(Employee $employee): void
    {
        if ($employee->iqama_expiration_hijri != null & $employee->isDirty('iqama_expiration_hijri')) {
            // Convert Hijri dates to Gregorian dates
            $employee->iqama_expiration_gregorian = HijriUtil::toGregorian($employee->iqama_expiration_hijri);
        }
    }

    private function updateStatusDates(Employee $employee): void
    {
        // When 'final_exit_date' is set, set 'visa_expired_date' and 'transferred_date' to null and vice versa
        // Check which column is updated
        if ($employee->isDirty('final_exit_date')) {
            // If 'final_exit_date' is set, set 'visa_expired_date' and 'transferred_date' to null
            if ($employee->final_exit_date) {
                $employee->visa_expired_date = null;
                $employee->transferred_date = null;
            }
        } elseif ($employee->isDirty('visa_expired_date')) {
            // If 'visa_expired_date' is set, set 'final_exit_date' and 'transferred_date' to null
            if ($employee->visa_expired_date) {
                $employee->final_exit_date = null;
                $employee->transferred_date = null;
            }
        } elseif ($employee->isDirty('transferred_date')) {
            // If 'transferred_date' is set, set 'final_exit_date' and 'visa_expired_date' to null
            if ($employee->transferred_date) {
                $employee->final_exit_date = null;
                $employee->visa_expired_date = null;
            }
        }
    }

    /**
     * Handle the Employee "created" event.
     */
    public function created(Employee $employee): void
    {
        $this->convertHijriDatesToGregorian($employee);

        $employee->saveQuietly();
    }

    /**
     * Handle the Employee "updated" event.
     */
    public function updated(Employee $employee): void
    {
        $this->updateStatusDates($employee);
        $this->convertHijriDatesToGregorian($employee);

        $employee->saveQuietly();
    }

    /**
     * Handle the Employee "deleted" event.
     */
    public function deleted(Employee $employee): void
    {
        //
    }

    /**
     * Handle the Employee "restored" event.
     */
    public function restored(Employee $employee): void
    {
        //
    }

    /**
     * Handle the Employee "force deleted" event.
     */
    public function forceDeleted(Employee $employee): void
    {
        //
    }
}
