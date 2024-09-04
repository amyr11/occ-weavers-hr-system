<?php

namespace Database\Seeders;

use App\Models\Bonus;
use App\Models\Project;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,
            InsuranceClassSeeder::class,
            ProjectSeeder::class,
            EmployeeJobSeeder::class,
            EmployeeSeeder::class,
            ContractSeeder::class,
            EmployeeLeaveSeeder::class,
            BonusSeeder::class,
        ]);
    }
}
