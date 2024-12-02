<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuarios
        $admin = User::updateOrCreate(
            ['rut' => '12345678-9'],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
            ]
        );

        $userTwo = User::updateOrCreate(
            ['rut' => '98765432-1'],
            [
                'name' => 'User Two',
                'email' => 'user2@example.com',
                'password' => Hash::make('password456'),
            ]
        );

        $userThree = User::updateOrCreate(
            ['rut' => '11223344-5'],
            [
                'name' => 'User Three',
                'email' => 'user3@example.com',
                'password' => Hash::make('password789'),
            ]
        );

        // Obtener roles
        $adminRole = Role::where('name', 'Apoderado')->first();
        $docenteRole = Role::where('name', 'Docente')->first();
        $estudianteRole = Role::where('name', 'Estudiante')->first();

        // Asignar roles
        $admin->roles()->attach($adminRole); // Asignar rol de apoderado al admin
        $userTwo->roles()->attach($docenteRole); // Asignar rol de docente al userTwo
        $userThree->roles()->attach($estudianteRole); // Asignar rol de estudiante al userThree
    }
}
