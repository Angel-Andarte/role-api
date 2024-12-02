<?php

namespace Database\Seeders;

use App\Models\Mes;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            StatusSeeder::class,
            ColegioSeeder::class,
            YearSeeder::class,
            MesSeeder::class,
            ColegioSeeder::class,
        ]);
    }
}
