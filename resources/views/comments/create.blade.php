@extends('layouts.app')

@section('content')
    <h1>Add Comment for Task: {{ $task->title }}</h1>

    <form action="{{ route('comments.store', $task->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="comment" class="form-label">Comment:</label>
            <textarea name="comment" id="comment" rows="3" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Comment</button>
    </form>
@endsection
