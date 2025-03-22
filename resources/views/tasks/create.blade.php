@extends('layouts.app')

@section('content')
    <h1>Create New Task</h1>
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Task Title:</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea name="description" id="description" rows="3" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date:</label>
            <input type="date" name="due_date" id="due_date" class="form-control">
        </div>
        <div class="mb-3">
            <label for="priority" class="form-label">Priority:</label>
            <select name="priority" id="priority" class="form-control">
                <option value="low">Low</option>
                <option value="medium" selected>Medium</option>
                <option value="high">High</option>
            </select>
        </div>
        <!-- Add fields for category, dependencies, etc. as needed -->
        <button type="submit" class="btn btn-primary">Create Task</button>
    </form>
@endsection
