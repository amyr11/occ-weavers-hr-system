<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $educationLevels = [
            'High School',
            'Bachelor\'s Degree',
        ];

        foreach ($educationLevels as $level) {
            \App\Models\EducationLevel::create([
                'level' => $level,
            ]);
        }
    }
}
