<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\ProjectAssignment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();

        // First, for each employee, create 1 project assignment
        $employees->each(function ($employee) {
            ProjectAssignment::factory()->create([
                'employee_number' => $employee->employee_number,
            ]);
        });
    }
}
