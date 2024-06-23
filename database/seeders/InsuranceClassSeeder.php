<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InsuranceClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $insuranceClasses = [
            ['name' => 'Class A'],
            ['name' => 'Class B'],
            ['name' => 'Class C'],
            ['name' => 'Class D'],
        ];

        foreach ($insuranceClasses as $insuranceClass) {
            \App\Models\InsuranceClass::create($insuranceClass);
        }
    }
}
