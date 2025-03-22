@foreach($tasks as $task)
    <tr>
        <td>{{ $task->title }}</td>
        <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : 'No Due Date' }}</td>
        <td>{{ ucfirst($task->priority) }}</td>
        <td>{{ ucfirst($task->status) }}</td>
        <td>{{ $task->category ? $task->category->name : 'N/A' }}</td>
        <td>
            @if($task->assignee)
                {{ $task->assignee->name }}
            @else
                Not Assigned
            @endif
        </td>
        <td>
            @if($task->assignee)
                {{ $task->assignee->getRoleNames()->first() }}
            @else
                N/A
            @endif
        </td>
        <td>
            @if($task->dependency)
                {{ $task->dependency->title }}
            @else
                None
            @endif
        </td>
        @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager')))
            <td>
                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-sm btn-danger delete-task">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </td>
        @else
            <td>
                <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-info">
                    <i class="fas fa-eye"></i> View
                </a>
            </td>
        @endif
    </tr>
@endforeach

@if($tasks->isEmpty())
    <tr>
        <td colspan="{{ auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager')) ? 9 : 8 }}" class="text-center">No tasks found.</td>
    </tr>
@endif
