@extends('layouts.app')

@section('content')
    <h1>Edit Comment for Task: {{ $task->title }}</h1>

    <form action="{{ route('comments.update', [$task->id, $comment->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="comment" class="form-label">Comment:</label>
            <textarea name="comment" id="comment" rows="3" class="form-control" required>{{ $comment->comment }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Comment</button>
    </form>
@endsection
