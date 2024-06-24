<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmployeeLeave;
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
        $lastRecord = EmployeeLeave::where('employee_number', $employee->employee_number)->latest('end_date')->first();
        if ($lastRecord) {
            $start_date = $this->faker->dateTimeBetween($lastRecord->end_date, '+ 1 year')->format('Y-m-d');
        } else {
            $start_date = $this->faker->date();
        }
        $end_date = $this->faker->dateTimeBetween($start_date, $start_date . " + {$employee->current_leave_days} days")->format('Y-m-d');

        return [
            'request_file_link' => 'https://youtu.be/dQw4w9WgXcQ',
            'employee_number' => $employee->employee_number,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
    }
}
