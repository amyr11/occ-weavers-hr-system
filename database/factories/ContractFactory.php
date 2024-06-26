<?php

namespace Database\Factories;

use App\Models\Contract;
use App\Models\Employee;
use App\Models\EmployeeJob;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $employee = Employee::all()->random();
        $lastRecord = Contract::where('employee_number', $employee->employee_number)->latest('end_date')->first();
        if ($lastRecord) {
            $start_date = Carbon::parse($lastRecord->end_date)->addYear()->format('Y-m-d');
        } else {
            $start_date = $this->faker->date();
        }
        // 1 or 2 years after the start date
        $end_date = Carbon::parse($start_date)->addYears($this->faker->randomElement([1, 2]))->format('Y-m-d');

        return [
            'employee_number' => Employee::all()->random()->employee_number,
            'employee_job_id' => EmployeeJob::all()->random()->id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'basic_salary' => $this->faker->randomFloat(2),
            'housing_allowance' => $this->faker->randomFloat(2),
            'transportation_allowance' => $this->faker->randomFloat(2),
            'food_allowance' => $this->faker->randomFloat(2),
            'remarks' => $this->faker->text(),
            'file_link' => $this->faker->url(),
        ];
    }
}
