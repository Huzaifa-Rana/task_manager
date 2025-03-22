@forelse($tasks as $task)
<tr>
  <td>{{ $task->title }}</td>
  <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : 'No Due Date' }}</td>
  <td>{{ ucfirst($task->priority) }}</td>
  <td>{{ ucfirst($task->status) }}</td>
  <td>
    <!-- Edit Button with Font Awesome Icon -->
    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-secondary">
      <i class="fas fa-edit"></i> Edit
    </a>
    <!-- Delete Button triggers modal -->
    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
      @csrf
      @method('DELETE')
      <button type="button" class="btn btn-sm btn-danger delete-task">
        <i class="fas fa-trash"></i> Delete
      </button>
    </form>
  </td>
</tr>
@empty
<tr>
  <td colspan="5" class="text-center">No tasks found.</td>
</tr>
@endforelse
