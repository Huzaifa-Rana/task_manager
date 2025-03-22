@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>{{ $task ? 'Edit Task' : 'Create New Task' }}</h1>
    <form action="{{ $task ? route('tasks.update') : route('tasks.store') }}" method="POST">
        @csrf
        @if($task)
            <input type="hidden" name="id" value="{{ $task->id }}">
        @endif
        <div class="mb-3">
            <label for="title" class="form-label">Task Title:</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $task->title ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea name="description" id="description" rows="3" class="form-control">{{ old('description', $task->description ?? '') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date:</label>
            <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date', $task->due_date ?? '') }}">
        </div>
        <div class="mb-3">
            <label for="priority" class="form-label">Priority:</label>
            <select name="priority" id="priority" class="form-control">
                <option value="low" {{ old('priority', $task->priority ?? 'medium')=='low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ old('priority', $task->priority ?? 'medium')=='medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ old('priority', $task->priority ?? 'medium')=='high' ? 'selected' : '' }}>High</option>
            </select>
        </div>
        @if($task) 
        <!-- Only show status on edit -->
        <div class="mb-3">
            <label for="status" class="form-label">Status:</label>
            <select name="status" id="status" class="form-control">
                <option value="pending" {{ old('status', $task->status)=='pending' ? 'selected' : '' }}>Pending</option>
                <option value="in progress" {{ old('status', $task->status)=='in progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ old('status', $task->status)=='completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
        @endif
        <div class="mb-3">
            <label for="category_id" class="form-label">Category:</label>
            <select name="category_id" id="category_id" class="form-control">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $task->category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="assignee_id" class="form-label">Assign To:</label>
            <select name="assignee_id" id="assignee_id" class="form-control">
                <option value="">Select User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('assignee_id', $task->assignee_id ?? '') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>
        @if($allTasks->count() > ($task ? 1 : 0))
        <!-- Only show Dependent Task if there are other tasks available -->
        <div class="mb-3">
            <label for="dependent_task_id" class="form-label">Dependent Task:</label>
            <select name="dependent_task_id" id="dependent_task_id" class="form-control">
                <option value="">None</option>
                @foreach($allTasks as $depTask)
                    @if(!$task || ($depTask->id != $task->id))
                    <option value="{{ $depTask->id }}" {{ old('dependent_task_id', $task->dependent_task_id ?? '') == $depTask->id ? 'selected' : '' }}>
                        {{ $depTask->title }}
                    </option>
                    @endif
                @endforeach
            </select>
        </div>
        @endif
        <button type="submit" class="btn btn-primary">{{ $task ? 'Update Task' : 'Create Task' }}</button>
    </form>
</div>
@endsection
