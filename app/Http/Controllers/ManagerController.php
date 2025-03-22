<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class ManagerController extends Controller
{
    // Dashboard for managers
    public function dashboard()
    {
        $totalTasks = Task::count();
        $pendingTasks = Task::where('status', 'pending')->count();
        $inProgressTasks = Task::where('status', 'in progress')->count();
        $completedTasks = Task::where('status', 'completed')->count();
        $tasks = Task::paginate(10);

        return view('manager.dashboard', compact('totalTasks', 'pendingTasks', 'inProgressTasks', 'completedTasks', 'tasks'));
    }


    // List tasks that the manager is responsible for (e.g., team tasks)
    public function tasks()
    {
        // For simplicity, let's assume manager sees all tasks.
        // In a real application, you'd filter tasks by team or assign a manager_id to tasks.
        $tasks = Task::all();
        return view('manager.tasks', compact('tasks'));
    }
}
