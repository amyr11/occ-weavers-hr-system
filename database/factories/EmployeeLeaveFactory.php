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
        $end_date = $this->faker->dateTimeBetween($start_date, $start_date . ' + 30 days')->format('Y-m-d');
        return [
            'request_file_link' => 'https://youtu.be/dQw4w9WgXcQ',
            'employee_number' => Employee::all()->random()->employee_number,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
    }
}
