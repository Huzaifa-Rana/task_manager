<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // Display a listing of tasks
    public function index()
    {
        // Fetch tasks with related user and category data, paginated to 10 per page
        $tasks = Task::with('user', 'category')->paginate(10);
        return view('tasks.index', compact('tasks'));
    }


    // Show the form for creating a new task
    public function create()
    {
        return view('tasks.create');
    }

    // Store a newly created task in storage
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
            'priority'    => 'required|in:low,medium,high',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        Task::create([
            'title'       => $request->title,
            'description' => $request->description,
            'due_date'    => $request->due_date,
            'priority'    => $request->priority,
            'status'      => 'pending',
            'user_id'     => Auth::id(),
            'category_id' => $request->category_id,
        ]);

        // Redirect to the tasks.index view (dashboard)
        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }


    // Display the specified task
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    // Show the form for editing the specified task
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    // Update the specified task in storage
    public function update(Request $request, Task $task)
    {
        // Validate input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in progress,completed',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // Update the task
        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    // Remove the specified task from storage
    public function destroy(Task $task)
    {
        // Only allow deletion if the user is an admin or the owner of the task
        if (Auth::user()->role !== 'admin' && Auth::id() !== $task->user_id) {
            return redirect()->route('tasks.index')->with('error', 'Unauthorized action.');
        }

        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    //  Extra Features

    public function search(Request $request)
    {
        \Log::info("in search", [$request]);
        $query = $request->input('query');

        // Search tasks by title or description and paginate (10 per page)
        $tasks = Task::where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->paginate(10);

        // Render the partial view for the task rows
        $table = view('tasks.partials.task_rows', compact('tasks'))->render();
        // Render pagination links
        $pagination = $tasks->links()->render();

        return response()->json([
            'table' => $table,
            'pagination' => $pagination,
        ]);
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
