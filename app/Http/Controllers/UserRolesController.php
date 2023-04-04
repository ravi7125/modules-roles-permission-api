<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRoles;

class UserRolesController extends Controller
{
    public function data(Request $request)
    {
        $user = User::find($request->user_id);
    $user->roles()->attach($request->role_id);
    return response()->json(['message' => 'Role is successfull attach to user'], 201);
    }
}
