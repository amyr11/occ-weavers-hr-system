<?php

use App\Models\Employee;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule::call(function () {
//     // Increment the current_leave_days of all employees by the max_leave_days
//     $employees = Employee::all();
//     foreach ($employees as $employee) {
//         $employee->current_leave_days += $employee->max_leave_days;
//         $employee->save();
//     }
// })
//     ->yearly();