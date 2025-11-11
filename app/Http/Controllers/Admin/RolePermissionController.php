<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::with('permissions')->get();
            // dd($roles);
            return response()->json(['data' => $roles]);
        }
        $permissions = Permission::all();
        return view('templates.template1.admin.role-permission', compact(['permissions']));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . ($request->roleId ?? 'NULL') . ',id',
            'permissions' => 'array|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        $role = Role::updateOrCreate(
            ['id' => $request->roleId],
            ['name' => $request->name, 'guard_name' => 'web']
        );

        $role->syncPermissions($request->permissions ?? []);

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return response()->json(['status' => true, 'message' => $request->id ? 'Role updated!' : 'Role created!']);
    }
    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        return response()->json(['status' => true, 'role' => $role]);
    }

    public function destroy($id)
    {
        Role::findOrFail($id)->delete();
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        return response()->json(['status' => true, 'message' => 'Role deleted successfully!']);
    }
}
