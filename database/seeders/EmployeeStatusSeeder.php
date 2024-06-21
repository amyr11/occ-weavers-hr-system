<?php

namespace Database\Seeders;

use App\Models\EmployeeStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'Regular',
            'Final exit',
            'Visa expired',
            'Transferred',
        ];

        foreach ($statuses as $status) {
            EmployeeStatus::create([
                'status' => $status,
            ]);
        }
    }
}
