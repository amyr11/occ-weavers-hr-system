<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectAssignment>
 */
class ProjectAssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_number' => Employee::all()->random()->employee_number,
            'project_id' => Project::all()->random()->id,
            'transfer_date' => $this->faker->date(),
            'transfer_memo_link' => $this->faker->url(),
        ];
    }
}
