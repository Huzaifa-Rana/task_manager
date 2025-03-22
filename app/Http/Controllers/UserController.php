<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class UserController extends Controller
{
    // User dashboard
    public function dashboard()
    {
        // You can show personal stats (e.g., count of assigned tasks)
        $user = auth()->user();
        $assignedTasks = Task::where('user_id', $user->id)->count();
        return view('user.dashboard', compact('assignedTasks'));
    }

    // List tasks assigned to the logged-in user
    public function tasks()
    {
        $user = auth()->user();
        $tasks = Task::where('user_id', $user->id)->get();
        return view('user.tasks', compact('tasks'));
    }
}
