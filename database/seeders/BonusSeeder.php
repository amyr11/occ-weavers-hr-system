<?php

namespace Database\Seeders;

use App\Models\Bonus;
use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BonusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();

        // First, for each employee, create 1 bonus
        $employees->each(function ($employee) {
            Bonus::factory()->create([
                'employee_number' => $employee->employee_number,
            ]);
        });;
    }
}
