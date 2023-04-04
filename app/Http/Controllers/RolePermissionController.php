<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;

class RolePermissionController extends Controller
{
    public function index(Request $request)
    {
        $role = Role::findOrFail($request->role_id);
        $role->permission()->attach($request->permission_id);
        return response()->json(['message' => 'Permission attached to role'], 201);
    }
}
