<?php

namespace Database\Seeders;

use App\Models\Contract;
use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();

        // First, for each employee, create 1 contract
        $employees->each(function ($employee) {
            Contract::factory()->create([
                'employee_number' => $employee->employee_number,
            ]);
        });

        // Then, create 50 more random contracts
        Contract::factory()->count(50)->create();
    }
}
