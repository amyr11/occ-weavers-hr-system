<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Degree;
use App\Models\EducationLevel;
use App\Models\InsuranceClass;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $education_level = EducationLevel::all()->random();
        $degree_id = $education_level->level === 'Bachelor\'s Degree' ? Degree::all()->random()->id: null;

        return [
            'education_level_id' => $education_level->id,
            'degree_id' => $degree_id,
            'insurance_class_id' => InsuranceClass::all()->random()->id,
            'country_id' => Country::all()->random()->id,
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'suffix' => $this->faker->randomElement([$this->faker->suffix(), null]),
            'birthdate' => $this->faker->dateTimeBetween('-50 years', '-25 years')->format('Y-m-d'),
            'mobile_number' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'photo_link' => $this->faker->imageUrl(),
            'college_graduation_date' => $this->faker->date(),
            'labor_office_number' => $this->faker->unique()->numberBetween(1000, 9999),
            'iban_number' => $this->faker->unique()->numberBetween(1000, 9999),
            'iqama_number' => $this->faker->unique()->numberBetween(1000, 9999),
            'iqama_job_title' => $this->faker->jobTitle(),
            'iqama_expiration' => $this->faker->date(),
            'passport_number' => $this->faker->unique()->numberBetween(1000, 9999),
            'passport_date_issue' => $this->faker->date(),
            'passport_expiration' => $this->faker->date(),
            'sce_expiration' => $this->faker->date(),
            'company_start_date' => $this->faker->date(),
            'max_leave_days' => 21,
        ];
    }
}
