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
            'Bachelor of Science in Computer Science',
            'Bachelor of Science in Information Technology',
            'Bachelor of Science in Civil Engineering',
            'Bachelor of Science in Mechanical Engineering',
            'Bachelor of Science in Electrical Engineering',
            'Bachelor of Science in Financial Management',
            'Bachelor of Science in Accountancy',
            'Bachelor of Science in Business Administration',
        ];

        foreach ($degrees as $degree) {
            \App\Models\Degree::create([
                'degree' => $degree,
            ]);
        }
    }
}
