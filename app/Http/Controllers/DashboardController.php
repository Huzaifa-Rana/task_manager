<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Calculate statistics (you can adjust these queries as needed)
        $totalTasks = Task::count();
        $pendingTasks = Task::where('status', 'pending')->count();
        $inProgressTasks = Task::where('status', 'in progress')->count();
        $completedTasks = Task::where('status', 'completed')->count();

        return view('dashboard', compact('totalTasks', 'pendingTasks', 'inProgressTasks', 'completedTasks'));
    }
}
