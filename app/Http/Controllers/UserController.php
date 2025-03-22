<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class UserController extends Controller
{
    // User dashboard
    public function dashboard()
    {
        // Get tasks assigned to the authenticated user
        $tasks = Task::where('assignee_id', auth()->id())->paginate(10);
        $assignedTasks = $tasks->total();

        return view('user.dashboard', compact('tasks', 'assignedTasks'));
    }


    // List tasks assigned to the logged-in user
    public function tasks()
    {
        $tasks = Task::where('assignee_id', auth()->id())->paginate(10);
        return view('user.tasks', compact('tasks'));
    }
}
