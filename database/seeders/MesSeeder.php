<?php

namespace Database\Seeders;

use App\Models\Mes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meses = [
            ['name' => 'Enero', 'num_mes' => 1, 'status_id' => 1],
            ['name' => 'Febrero', 'num_mes' => 2, 'status_id' => 2],
        ];

        foreach ($meses as $mes) {
            Mes::updateOrCreate(
                ['num_mes' => $mes['num_mes']], $mes);
        }
    }
}
