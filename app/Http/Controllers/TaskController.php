<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\User;

class TaskController extends Controller
{

    // Display list of tasks (viewable by all roles)
    public function index()
    {
        // For admin/manager, show all tasks; for user, filter by assigned user
        if (auth()->user()->hasRole('user')) {
            $tasks = Task::where('assignee_id', auth()->id())->paginate(10);
        } else {
            $tasks = Task::paginate(10);
        }
        return view('dashboard', compact('tasks'));
    }

    // Show the form for creating a new task (admins/managers only)
    public function create()
    {
        $categories = Category::all();
        $users = User::all();
        $allTasks = Task::all(); // for dependency selection
        return view('tasks.form', [
            'task' => null,
            'categories' => $categories,
            'users' => $users,
            'allTasks' => $allTasks
        ]);
    }

    // Store a newly created task (admins/managers only)
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'due_date'          => 'nullable|date',
            'priority'          => 'required|in:low,medium,high',
            'status'            => 'nullable|in:pending,in progress,completed',
            'category_id'       => 'nullable|exists:categories,id',
            'assignee_id'       => 'nullable|exists:users,id',
            'dependent_task_id' => 'nullable|exists:tasks,id',
        ]);

        // Set default status if not provided
        if (!isset($data['status'])) {
            $data['status'] = 'pending';
        }
        $data['user_id'] = auth()->id();

        Task::create($data);

        return redirect()->route('dashboard')->with('success', 'Task created successfully.');
    }


    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }


    // Show the form for editing an existing task (admins/managers only)
    public function edit(Task $task)
    {
        $categories = Category::all();
        $users = User::all();
        $allTasks = Task::where('id', '!=', $task->id)->get(); // Exclude current task for dependency
        return view('tasks.form', [
            'task' => $task,
            'categories' => $categories,
            'users' => $users,
            'allTasks' => $allTasks
        ]);
    }



    // Remove the specified task from storage
    public function destroy(Task $task)
    {
        // Only allow deletion if the user is an admin or the owner of the task
        if (Auth::user()->role !== 'admin' && Auth::id() !== $task->user_id) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized action.');
        }

        $task->delete();
        return redirect()->route('dashboard')->with('success', 'Task deleted successfully.');
    }

    //  Extra Features

    public function search(Request $request)
    {
        $query = $request->query('query');
        $tasks = Task::where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->paginate(10);

        $table = view('tasks.partials.task_rows', compact('tasks'))->render();
        $pagination = $tasks->links()->render();

        return response()->json(['table' => $table, 'pagination' => $pagination]);
    }
    public function update(Request $request)
    {
        $data = $request->validate([
            'id'                => 'required|exists:tasks,id',
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'due_date'          => 'nullable|date',
            'priority'          => 'required|in:low,medium,high',
            'status'            => 'required|in:pending,in progress,completed',
            'category_id'       => 'nullable|exists:categories,id',
            'assignee_id'       => 'nullable|exists:users,id',
            'dependent_task_id' => 'nullable|exists:tasks,id',
        ]);

        $task = Task::findOrFail($data['id']);
        $task->update($data);
        return redirect()->route('dashboard')->with('success', 'Task updated successfully.');
    }






    public function timeline()
    {
        // Get all tasks with due dates (you can add more filtering if needed)
        $tasks = Task::whereNotNull('due_date')->get();

        // Map tasks to FullCalendar event format
        $events = $tasks->map(function ($task) {
            return [
                'title' => $task->title,
                'start' => $task->due_date,  // FullCalendar accepts ISO date strings
                'url'   => route('tasks.show', $task->id),  // Link to the task detail page
            ];
        });

        // Return events in JSON format
        return response()->json($events);
    }
}
