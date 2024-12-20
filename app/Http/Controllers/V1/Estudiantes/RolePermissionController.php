<?php

namespace App\Http\Controllers\V1\Estudiantes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * @OA\Tag(
 *     name="Roles y Permisos",
 *     description="Gestión de roles y permisos"
 * )
 */

class RolePermissionController extends Controller
{

    // listado de roles

     public function listRoles()
     {
         $roles = Role::all();
         return response()->json($roles, 200);
     }

     //Crear un rol
     public function createRole(Request $request)
     {
         $request->validate([
             'name' => 'required|unique:roles',
         ]);

         $role = Role::create(['name' => $request->name]);

         return response()->json($role, 201);
     }

     //Eliminar un rol
     public function deleteRole($id)
     {
         $role = Role::findOrFail($id);

         foreach ($role->users as $user) {
            $user->removeRole($role);
         }

         $role->permissions()->detach();

         $role->delete();

         return response()->json(['message' => 'Role deleted successfully'], 200);
     }

     //Listar permisos
     public function listPermissions()
     {
         $permissions = Permission::all();
         return response()->json($permissions, 200);
     }

     //Crear un permiso
     public function createPermission(Request $request)
     {
         $request->validate([
             'name' => 'required|unique:permissions',
         ]);

         $permission = Permission::create(['name' => $request->name]);

         return response()->json($permission, 201);
     }

     // eliminar un permiso
     public function deletePermission($id)
     {
         $permission = Permission::findOrFail($id);
         $permission->delete();

         return response()->json(['message' => 'Permission deleted successfully'], 200);
     }

     //Asignar permiso a un rol
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

     //Revocar permiso de un rol
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

     // Asignar rol a un usuario
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

     //Revocar rol de un usuario
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
     * @OA\Get(
     *     path="/api/users/{userId}/roles",
     *     summary="Obtener roles de un usuario",
     *     tags={"Users"},
     *     description="Devuelve la lista de roles asignados a un usuario específico.",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         description="ID del usuario",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de roles del usuario",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="roles",
     *                 type="array",
     *                 @OA\Items(type="string", example="Admin")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */

     public function getUserRoles($userId)
     {
         $user = User::findOrFail($userId);

         return response()->json([
             'roles' => $user->getRoleNames(),
         ], 200);
     }

    /**
     * @OA\Get(
     *     path="/api/users/{userId}/permissions",
     *     summary="Obtener permisos de un usuario",
     *     tags={"Users"},
     *     description="Devuelve la lista de permisos asignados a un usuario, ya sea a través de roles o directamente.",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         description="ID del usuario",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de permisos del usuario",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="permissions",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="name", type="string", example="edit-posts"),
     *                     @OA\Property(property="guard_name", type="string", example="web"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-26T12:34:56Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-26T12:34:56Z")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */


     public function getUserPermissions($userId)
     {
         $user = User::findOrFail($userId);

         return response()->json([
             'permissions' => $user->getAllPermissions(),
         ], 200);
     }

    //Verificar si un usuario tiene un rol específico

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

     //Verificar si un usuario tiene un permiso específico

     public function checkUserPermission(Request $request, $userId)
     {
         $request->validate([
             'permission' => 'required|string',
         ]);

         $user = User::findOrFail($userId);

         return response()->json([
            'has_permission' => $user->can($request->permission),
         ], 200);
     }
}
