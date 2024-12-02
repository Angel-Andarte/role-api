<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lista de roles y sus permisos asociados
        $rolesAndPermissions = [
            'Apoderado' => ['dash-apoderado', 'enviar-msj'],
            'Docente'   => ['dash-docente', 'agenda'],
            'Estudiante' => ['dash-docente', 'horario'],
        ];

        foreach ($rolesAndPermissions as $roleName => $permissions) {

            $role = Role::updateOrCreate(['name' => $roleName]);

            foreach ($permissions as $permissionName) {

                $permission = Permission::updateOrCreate(['name' => $permissionName]);


                $role->givePermissionTo($permission);
            }
        }
    }
}
