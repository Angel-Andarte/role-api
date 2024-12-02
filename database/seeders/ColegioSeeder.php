<?php

namespace Database\Seeders;

use App\Models\Colegio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColegioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Colegio::updateOrCreate(
            ['nombre_colegio' => 'Puelmapu'],
            ['status_id' => 1]
        );

        Colegio::updateOrCreate(
            ['nombre_colegio' => 'Pablo Neruda'],
            ['status_id' => 2]
        );
    }
}
