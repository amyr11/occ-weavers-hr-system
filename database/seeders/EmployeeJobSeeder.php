<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobs = [
            'Software Engineer',
            'Painter',
            'Civil Engineer',
            'Autocad Operator',
            'Architect',
            'Electrician',
            'Plumber',
            'Welder',
            'Mason',
            'Carpenter',
            'HR Secretary',
            'HR Manager',
        ];

        foreach ($jobs as $job) {
            \App\Models\EmployeeJob::create([
                'job_title' => $job,
            ]);
        }
    }
}
