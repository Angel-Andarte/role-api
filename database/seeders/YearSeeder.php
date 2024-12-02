<?php

namespace Database\Seeders;

use App\Models\Year;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class YearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $years = [
            ['year' => 2023, 'status_id' => 2],
            ['year' => 2024, 'status_id' => 1],
        ];

        foreach ($years as $year) {
            Year::updateOrCreate(['year' => $year['year']], $year);
        }
    }
}
