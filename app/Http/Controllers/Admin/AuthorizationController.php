<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AuthorizationController extends Controller
{
    public function index()
    {
        return view('admin.authorization.index', [
            'roles' => Role::where('name', '!=', 'Super Admin')->with('permissions')->get(),
            'permissions' => Permission::all()
        ]);
    }

    public function storeRole()
    {
        // Validate request
        $this->validate(request(), [
            'name' => ['required', Rule::unique('roles')],
            'permissions' => ['array', 'required']
        ]);

        // Create role
        $role = Role::create(request()->only('name'));
        $role->syncPermissions(request('permissions'));
        return back()->with('success', 'Role created successfully');
    }

    public function updateRole(Role $role)
    {
         // Validate request
         $this->validate(request(), [
            'name' => ['required', Rule::unique('roles')->ignore($role->id)],
            'permissions' => ['array', 'required']
        ]);

        // Update role
        $role->update(request()->only('name'));
        $role->syncPermissions(request('permissions'));
        return back()->with('success', 'Role updated successfully');
    }

    public function destroyRole(Role $role)
    {
        // Check if role has users
        if ($role->users()->count() > 0){
            return back()->with('error', 'Can\'t delete role, administrators associated');
        }
        // remove all permissions
        $role->syncPermissions([]);

        // delete role
        $role->delete();
        return back()->with('success', 'Role deleted successfully');
    }
}
