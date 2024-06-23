<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $degrees = [
            'BS Computer Science',
            'BS Information Technology',
            'BS Civil Engineering',
            'BS Mechanical Engineering',
            'BS Electrical Engineering',
            'BS Financial Management',
            'BS Accountancy',
            'BS Business Administration',
        ];

        foreach ($degrees as $degree) {
            \App\Models\Degree::create([
                'degree' => $degree,
            ]);
        }
    }
}
