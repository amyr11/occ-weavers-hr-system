<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['name' => 'Saudi Arabia'],
            ['name' => 'Philippines'],
            ['name' => 'India'],
            ['name' => 'Pakistan'],
        ];

        for ($i = 0; $i < count($countries); $i++) {
            Country::create($countries[$i]);
        }
    }
}
