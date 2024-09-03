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
        $startRange = Carbon::create(2023, 1, 1);
        $endRange = Carbon::create(2026, 12, 31);

        $start_date = $this->faker->dateTimeBetween($startRange, $endRange)->format('Y-m-d');
        $end_date = Carbon::createFromFormat('Y-m-d', $start_date)->addYears($this->faker->randomElement([1, 2]))->format('Y-m-d');
        // Change the days a little bit on paper_contract_end_date from end_date
        $end_date_obj = Carbon::createFromFormat('Y-m-d', $end_date);
        $end_date_obj->addDays($this->faker->numberBetween(1, 30));
        $paper_end_date = $end_date_obj->format('Y-m-d');

        return [
            'employee_number' => Employee::all()->random()->employee_number,
            'employee_job_id' => EmployeeJob::all()->random()->id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'paper_contract_start_date' => $start_date,
            'paper_contract_end_date' => $paper_end_date,
            'basic_salary' => $this->faker->randomFloat(2),
            'housing_allowance' => $this->faker->randomFloat(2),
            'transportation_allowance' => $this->faker->randomFloat(2),
            'food_allowance' => $this->faker->randomFloat(2),
            'remarks' => $this->faker->text(),
            'file_link' => $this->faker->url(),
        ];
    }
}
