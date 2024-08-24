<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmployeeLeave;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeeLeave>
 */
class EmployeeLeaveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $employee = Employee::where('current_leave_days', '>', 0)->inRandomOrder()->first();

        // Define the date range
        $startRange = Carbon::create(2023, 1, 1);
        $endRange = Carbon::create(2024, 12, 31);

        $lastRecord = EmployeeLeave::where('employee_number', $employee->employee_number)->latest('end_date')->first();

        if ($lastRecord) {
            $start_date = Carbon::parse($lastRecord->end_date)->addYear();
            // Ensure the start date is within the specified range
            $start_date = $start_date->greaterThan($endRange) ? $endRange : $start_date;
            $start_date = $start_date->lessThan($startRange) ? $startRange : $start_date;
        } else {
            $start_date = $this->faker->dateTimeBetween($startRange, $endRange)->format('Y-m-d');
        }

        // Calculate end date
        $end_date = $this->faker->dateTimeBetween($start_date, $start_date . " + {$employee->current_leave_days} days")->format('Y-m-d');
        $end_date = Carbon::parse($end_date)->greaterThan($endRange) ? $endRange : $end_date;
        $end_date = Carbon::parse($end_date)->lessThan($startRange) ? $start_date : $end_date;

        // Calculate visa duration and expiration
        $visa_duration = Carbon::parse($start_date)->diffInDays(Carbon::parse($end_date)) + 30;
        $visa_expiration = Carbon::parse($end_date)->addDays($visa_duration);

        return [
            'request_file_link' => 'https://youtu.be/dQw4w9WgXcQ',
            'employee_number' => $employee->employee_number,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'visa_duration_in_days' => $visa_duration,
            'visa_expiration' => $visa_expiration,
            'contact_number' => $this->faker->phoneNumber,
        ];
    }
}
