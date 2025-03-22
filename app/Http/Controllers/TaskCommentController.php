<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskComment;
use Illuminate\Support\Facades\Auth;

class TaskCommentController extends Controller
{
    /**
     * Display a listing of the comments for a specific task.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\View\View
     */
    public function index(Task $task)
    {
        // Fetch all comments for the task, along with the user details for each comment
        $comments = $task->comments()->with('user')->get();
        return view('comments.index', compact('task', 'comments'));
    }

    /**
     * Show the form for creating a new comment for a task.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\View\View
     */
    public function create(Task $task)
    {
        return view('comments.create', compact('task'));
    }

    /**
     * Store a newly created comment for a task in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Task $task)
    {
        // Validate the input; the comment field is required.
        $request->validate([
            'comment' => 'required|string',
        ]);

        // Create the comment related to the task and associate it with the logged-in user
        $task->comments()->create([
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return redirect()->route('tasks.show', $task->id)
            ->with('success', 'Comment added successfully.');
    }

    /**
     * Show the form for editing the specified comment.
     *
     * @param  \App\Models\Task  $task
     * @param  \App\Models\TaskComment  $comment
     * @return \Illuminate\View\View
     */
    public function edit(Task $task, TaskComment $comment)
    {
        return view('comments.edit', compact('task', 'comment'));
    }

    /**
     * Update the specified comment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @param  \App\Models\TaskComment  $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Task $task, TaskComment $comment)
    {
        // Validate the updated comment text
        $request->validate([
            'comment' => 'required|string',
        ]);

        // Ensure that only the comment owner can update it (or an admin, if desired)
        if (Auth::id() !== $comment->user_id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $comment->update([
            'comment' => $request->comment,
        ]);

        return redirect()->route('tasks.show', $task->id)
            ->with('success', 'Comment updated successfully.');
    }

    /**
     * Remove the specified comment from storage.
     *
     * @param  \App\Models\Task  $task
     * @param  \App\Models\TaskComment  $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Task $task, TaskComment $comment)
    {
        // Allow deletion only if the user is the owner or an admin
        if (Auth::id() !== $comment->user_id && Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $comment->delete();

        return redirect()->route('tasks.show', $task->id)
            ->with('success', 'Comment deleted successfully.');
    }
}
