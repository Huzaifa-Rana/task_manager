@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Task Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $task->title }}</h5>
            <p class="card-text">{{ $task->description }}</p>
            <p class="card-text"><strong>Due Date:</strong> {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : 'N/A' }}</p>
            <p class="card-text"><strong>Priority:</strong> {{ ucfirst($task->priority) }}</p>
            <p class="card-text"><strong>Status:</strong> {{ ucfirst($task->status) }}</p>
            <p class="card-text"><strong>Category:</strong> {{ $task->category ? $task->category->name : 'N/A' }}</p>
            <p class="card-text"><strong>Assigned To:</strong> {{ $task->assignee ? $task->assignee->name : 'Not Assigned' }}</p>
            <p class="card-text"><strong>Dependent Task:</strong> {{ $task->dependency ? $task->dependency->title : 'None' }}</p>
        </div>
    </div>
    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
