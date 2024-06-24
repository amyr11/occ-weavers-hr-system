<?php

namespace Database\Seeders;

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
        for ($i = 0; $i < 100; $i++) {
            EmployeeLeave::factory()->create();
        }
    }
}
