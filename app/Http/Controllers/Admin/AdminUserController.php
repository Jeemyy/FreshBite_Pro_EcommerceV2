<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use App\Traits\LogsAdminActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    use LogsAdminActivity;

    public function index()
    {
        $admins = Admin::with('roles')->latest()->paginate(15);

        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('admin.admins.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $admin = Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if (! empty($validated['roles'])) {
            $admin->roles()->sync($validated['roles']);
        }

        $this->logActivity('admin_created', $admin, "Created admin user: {$admin->name}");

        return to_route('admin.admins.index')->with('success', 'Admin created successfully.');
    }

    public function edit(Admin $admin)
    {
        $roles = Role::all();
        $admin->load('roles');

        return view('admin.admins.edit', compact('admin', 'roles'));
    }

    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,'.$admin->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (! empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $admin->update($data);
        $admin->roles()->sync($validated['roles'] ?? []);

        $this->logActivity('admin_updated', $admin, "Updated admin user: {$admin->name}");

        return to_route('admin.admins.index')->with('success', 'Admin updated successfully.');
    }

    public function destroy(Admin $admin)
    {
        if ($admin->isSuperAdmin()) {
            return back()->with('error', 'Cannot delete Super Admin.');
        }

        $this->logActivity('admin_deleted', $admin, "Deleted admin user: {$admin->name}");
        $admin->roles()->detach();
        $admin->delete();

        return to_route('admin.admins.index')->with('success', 'Admin deleted successfully.');
    }
}
