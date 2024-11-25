<?php

namespace App\Http\Controllers\V1\Estudiantes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{

    /**
     * Listar roles.
     */

     public function listRoles()
     {
         $roles = Role::all();
         return response()->json($roles, 200);
     }

     /**
      * Crear rol.
      */

     public function createRole(Request $request)
     {
         $request->validate([
             'name' => 'required|unique:roles',
         ]);

         $role = Role::create(['name' => $request->name]);

         return response()->json($role, 201);
     }

     /**
      * Eliminar rol.
      */

     public function deleteRole($id)
     {
         $role = Role::findOrFail($id);
         $role->delete();

         return response()->json(['message' => 'Role deleted successfully'], 200);
     }

     /**
      * Obtener permisos.
      */

     public function listPermissions()
     {
         $permissions = Permission::all();
         return response()->json($permissions, 200);
     }

     /**
      * Crear permiso.
      */

     public function createPermission(Request $request)
     {
         $request->validate([
             'name' => 'required|unique:permissions',
         ]);

         $permission = Permission::create(['name' => $request->name]);

         return response()->json($permission, 201);
     }

     /**
      * Eliminar permiso.
      */

     public function deletePermission($id)
     {
         $permission = Permission::findOrFail($id);
         $permission->delete();

         return response()->json(['message' => 'Permission deleted successfully'], 200);
     }

     /**
      * Asignar permiso a rol.
      */

     public function assignPermissionToRole(Request $request)
     {
         $request->validate([
             'role_id' => 'required|exists:roles,id',
             'permission_id' => 'required|exists:permissions,id',
         ]);

         $role = Role::findById($request->role_id);
         $permission = Permission::findById($request->permission_id);

         $role->givePermissionTo($permission);

         return response()->json(['message' => 'Permission assigned to role successfully'], 200);
     }

     /**
      * Revocar permiso a rol.
      */

     public function revokePermissionFromRole(Request $request)
     {
         $request->validate([
             'role_id' => 'required|exists:roles,id',
             'permission_id' => 'required|exists:permissions,id',
         ]);

         $role = Role::findById($request->role_id);
         $permission = Permission::findById($request->permission_id);

         $role->revokePermissionTo($permission);

         return response()->json(['message' => 'Permission revoked from role successfully'], 200);
     }

     /**
      * Asignar rol a usuario.
      */

     public function assignRoleToUser(Request $request)
     {
         $request->validate([
             'user_id' => 'required|exists:users,id',
             'role_id' => 'required|exists:roles,id',
         ]);

         $user = User::findOrFail($request->user_id);
         $role = Role::findById($request->role_id);

         $user->assignRole($role);

         return response()->json(['message' => 'Role assigned to user successfully'], 200);
     }

     /**
      * Revocar rol a usuario.
      */

     public function revokeRoleFromUser(Request $request)
     {
         $request->validate([
             'user_id' => 'required|exists:users,id',
             'role_id' => 'required|exists:roles,id',
         ]);

         $user = User::findOrFail($request->user_id);
         $role = Role::findById($request->role_id);

         $user->removeRole($role);

         return response()->json(['message' => 'Role revoked from user successfully'], 200);
     }

     /**
      * Obtener los roles asignados a un usuario
      */

     public function getUserRoles($userId)
     {
         $user = User::findOrFail($userId);

         return response()->json([
             'roles' => $user->getRoleNames(),
         ], 200);
     }

     /**
      * Obtener los permisos asignados a un usuario, ya sea via rol o directamente.
      */

     public function getUserPermissions($userId)
     {
         $user = User::findOrFail($userId);

         return response()->json([
             'permissions' => $user->getAllPermissions(),
         ], 200);
     }

     /**
      * verificar si el usuario tiene un rol en especifico.
      */

     public function checkUserRole(Request $request, $userId)
     {
         $request->validate([
             'role' => 'required|string',
         ]);

         $user = User::findOrFail($userId);

         return response()->json([
             'has_role' => $user->hasRole($request->role),
         ], 200);
     }

     /**
      * Verificar si el usuario tiene un permiso en especifico
      */

     public function checkUserPermission(Request $request, $userId)
     {
         $request->validate([
             'permission' => 'required|string',
         ]);

         $user = User::findOrFail($userId);

         return response()->json([
             'has_permission' => $user->hasPermissionTo($request->permission),
         ], 200);
     }
}
