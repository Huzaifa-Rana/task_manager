<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    // Dashboard showing overall system stats
    public function dashboard()
    {
        // For example, you might want to count total users, tasks, etc.
        $totalUsers = User::count();
        $totalTasks = \App\Models\Task::count();
        return view('admin.dashboard', compact('totalUsers', 'totalTasks'));
    }

    // Show all users for management
    public function users()
    {
        $users = User::all();
        $roles = Role::all();
        return view('admin.users', compact('users', 'roles'));
    }

    // Change a user's role
    public function changeRole(Request $request, User $user)
    {
        // Validate the incoming role
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        // Remove existing roles and assign the new role
        $user->syncRoles([$request->role]);
        return redirect()->back()->with('success', 'User role updated successfully.');
    }
}
