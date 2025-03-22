@extends('layouts.app')

@section('content')
    <h1>Comments for Task: {{ $task->title }}</h1>

    <a href="{{ route('comments.create', $task->id) }}" class="btn btn-primary mb-3">Add Comment</a>

    @if($comments->count())
        <ul class="list-group">
            @foreach($comments as $comment)
                <li class="list-group-item">
                    <strong>{{ $comment->user->name }}:</strong> {{ $comment->comment }}
                    <div class="float-end">
                        <a href="{{ route('comments.edit', [$task->id, $comment->id]) }}" class="btn btn-sm btn-secondary">Edit</a>
                        <form action="{{ route('comments.destroy', [$task->id, $comment->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p>No comments yet.</p>
    @endif
@endsection
