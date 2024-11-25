<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\V1\Estudiantes\RolePermissionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // Roles
    Route::get('/roles', [RolePermissionController::class, 'listRoles']);
    Route::post('/roles', [RolePermissionController::class, 'createRole']);
    Route::delete('/roles/{id}', [RolePermissionController::class, 'deleteRole']);

    // Permissions
    Route::get('/permissions', [RolePermissionController::class, 'listPermissions']);
    Route::post('/permissions', [RolePermissionController::class, 'createPermission']);
    Route::delete('/permissions/{id}', [RolePermissionController::class, 'deletePermission']);

    // Role-Permission
    Route::post('/roles/assign-permission', [RolePermissionController::class, 'assignPermissionToRole']);
    Route::post('/roles/revoke-permission', [RolePermissionController::class, 'revokePermissionFromRole']);

    // Role-User
    Route::post('/users/assign-role', [RolePermissionController::class, 'assignRoleToUser']);
    Route::post('/users/revoke-role', [RolePermissionController::class, 'revokeRoleFromUser']);
    Route::get('/users/{userId}/roles', [RolePermissionController::class, 'getUserRoles']);
    Route::get('/users/{userId}/permissions', [RolePermissionController::class, 'getUserPermissions']);
    Route::post('/users/{userId}/check-role', [RolePermissionController::class, 'checkUserRole']);
    Route::post('/users/{userId}/check-permission', [RolePermissionController::class, 'checkUserPermission']);
});




