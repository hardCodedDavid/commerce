<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Admin\NotificationController;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.admins.index',[
            'admins' => Admin::all(),
            'roles' => Role::where('name', '!=', 'Super Admin')->get()
        ]);
    }

    public function store()
    {
        // Validate request
        $this->validate(request(), [
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('admins')],
            'role' => ['required']
        ]);

        // Find role
        $role = Role::find(request('role'));
        if (!$role) {
            return back()->with('error', 'Role not found');
        }

        // Generate login password
        $password = Str::random(8);
        $hashedPassword = Hash::make($password);

        // Create admin
        $data = request()->only('name', 'email');
        $data['password'] = $hashedPassword;
        $admin = Admin::create($data);

        // Assign role and send email notification
        $admin->assignRole($role);
        NotificationController::sendAdminRegistrationEmailNotification($admin, $password);
        return back()->with('success', 'Admin created successfully');
    }

    public function update(Admin $admin)
    {
        // Validate request
        $this->validate(request(), [
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('admins')->ignore($admin->id)],
            'role' => ['required']
        ]);

         // Find role
         $role = Role::find(request('role'));
         if (!$role) {
            return back()->with('error', 'Role not found');
         }

        // Update admin
        $admin->update(request()->only('name', 'email'));
        $admin->syncRoles($role);
        return back()->with('success', 'Admin updated successfully');
    }

    public function destroy(Admin $admin)
    {
        // Remove roles
        $admin->syncRoles([]);

        // Delete admin
        $admin->delete();
        return back()->with('success', 'Admin deleted successfully');
    }
}
