<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleController extends Controller
{
    public function index()
    {
        // Fetch all roles with their associated permissions
        $roles = Role::with('permissions')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);
        return redirect()->route('roles.index');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray(); // Get the IDs of the permissions assigned to the role
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id', // Validate that each permission ID exists
            'name' => 'required|string|max:255', // Validate that the name is required and a string
        ]);

        // Find the role by its ID
        $role = Role::findOrFail($id);

        // Update the role name
        $role->name = $request->name;
        $role->save(); // Save the updated name

        // Sync the permissions with the role
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        // Redirect back with a success message
        return redirect()->route('roles.index')->with('success', 'Role and permissions updated successfully.');
    }



    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('roles.index');
    }

    public function assignRole(Request $request)
    {
        $user = User::find($request->user_id);
        $user->assignRole($request->role);
        return redirect()->back();
    }
}

