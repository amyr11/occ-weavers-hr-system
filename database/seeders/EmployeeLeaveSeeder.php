<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeeLeave;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeLeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();

        // First, for each employee, create 1 leave
        $employees->each(function ($employee) {
            EmployeeLeave::factory()->create([
                'employee_number' => $employee->employee_number,
            ]);
        });;
    }
}
