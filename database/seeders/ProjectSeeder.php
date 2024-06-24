<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            'Delta Marriott Hotel',
            'Novotel Hotel',
            'Silver Sands Beach Resort',
            'Poulty Processing Plant (PPP 4) in Hail Area',
            'Premiere Food Factory II in Riyadh - Alkharj',
            'Mercedes Benz Flagship Showroom',
        ];

        foreach ($projects as $project) {
            \App\Models\Project::create([
                'project_name' => $project,
            ]);
        }
    }
}
