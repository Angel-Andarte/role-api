<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'habilitado'],
            ['name' => 'deshabilitado'],
        ];

        foreach ($statuses as $status) {
            Status::updateOrCreate(
                ['name' => $status['name']],
                ['name' => $status['name']]
            );
        }
    }
}
