<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\InsuranceClass;
use App\Utils\HijriUtil;
use Carbon\Carbon;
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
        $iqamaStartRange = Carbon::create(2024, 9, 1);
        $iqamaEndRange = Carbon::create(2025, 12, 31);
        $iqamaGregorian = $this->faker->dateTimeBetween($iqamaStartRange, $iqamaEndRange)->format('Y-m-d');
        $iqamaHijri = HijriUtil::toHijri($iqamaGregorian);

        return [
            'insurance_class_id' => InsuranceClass::all()->random()->id,
            'country_id' => Country::all()->random()->id,
            'full_name' => $this->faker->name(),
            'birthdate' => $this->faker->dateTimeBetween('-70 years', '-25 years')->format('Y-m-d'),
            'mobile_number' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'college_graduation_date' => $this->faker->date(),
            'labor_office_number' => $this->faker->unique()->numberBetween(1000, 9999),
            'iban_number' => $this->faker->unique()->numberBetween(1000, 9999),
            'iqama_number' => $this->faker->unique()->numberBetween(1000, 9999),
            'iqama_job_title' => $this->faker->jobTitle(),
            'iqama_expiration_hijri' => $iqamaHijri,
            'passport_number' => $this->faker->unique()->numberBetween(1000, 9999),
            'passport_date_issue' => $this->faker->date(),
            'passport_expiration' => $this->faker->date(),
            'sce_expiration' => $this->faker->date(),
            'company_start_date' => $this->faker->date(),
        ];
    }
}
