<?php

namespace Database\Factories;

use App\Models\Employee;
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
        $start_date = $this->faker->date();
        $end_date = $this->faker->dateTimeBetween($start_date, $start_date . ' + 7 days')->format('Y-m-d');
        $days = \Carbon\Carbon::parse($start_date)->diffInDays(\Carbon\Carbon::parse($end_date)) + 1;

        // Choose an employee number with current_leave_days greater than or equal to $days
        $employee_number = Employee::where('current_leave_days', '>=', $days)->inRandomOrder()->first()->employee_number;

        return [
            'request_file_link' => 'https://youtu.be/dQw4w9WgXcQ',
            'employee_number' => $employee_number,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
    }
}
