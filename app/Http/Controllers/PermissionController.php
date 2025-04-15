<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {

        $roles = Role::all();
        $permissions = Permission::orderBy('module_name')->get()->groupBy('module_name');
        return view('admin.permission.index', compact('permissions', 'roles'));
    }

    public function update(Role $role,Request $request)
    {
        $role->syncPermissions($request->id);
    }
}
