@extends('layouts.app')

@section('content')
    <h1>{{ $task->title }}</h1>
    <p>{{ $task->description }}</p>

    <!-- Display Dependency -->
    @if($task->dependency)
        <p><strong>Depends on:</strong> {{ $task->dependency->title }}</p>
    @endif

    <!-- Display Tasks that depend on this task -->
    @if($task->dependentTasks->count())
        <h3>Tasks depending on this task:</h3>
        <ul>
            @foreach($task->dependentTasks as $dependent)
                <li>{{ $dependent->title }}</li>
            @endforeach
        </ul>
    @endif
@endsection
