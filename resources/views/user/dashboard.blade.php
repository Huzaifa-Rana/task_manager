@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">User Dashboard</h1>

    <!-- Summary Card for Personal Tasks -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card bg-light">
                <div class="card-body">
                    <h5 class="card-title">Your Assigned Tasks</h5>
                    <p class="card-text">You have {{ $assignedTasks }} tasks assigned to you.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="mb-4">
        <a href="{{ route('user.tasks') }}" class="btn btn-secondary">
            <i class="fas fa-tasks"></i> View My Tasks
        </a>
    </div>

    <!-- Ajax Search Input for User Tasks -->
    <div class="mb-3">
        <input type="text" id="user-task-search" class="form-control" placeholder="Search your tasks...">
    </div>

    <!-- Tasks Table -->
  <div id="task-list">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Title</th>
          <th>Due Date</th>
          <th>Priority</th>
          <th>Status</th>
          <th>Category</th>
          <th>Assigned To</th>
          <th>User Role</th>
          <th>Dependent Task</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @include('tasks.partials.task_rows', ['tasks' => $tasks])
      </tbody>
    </table>
    <div id="pagination-links">
      {{ $tasks->links() }}
    </div>
  </div>

    <!-- Calendar Preview -->
    <div class="mb-4">
        <h2>Your Tasks Calendar</h2>
        <div id="user-calendar"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Ajax search for user tasks
    $('#user-task-search').on('keyup', function() {
        let query = $(this).val();
        $.ajax({
            url: "{{ route('tasks.search') }}",
            method: 'GET',
            data: { query: query },
            success: function(data) {
                $('#user-task-list tbody').html(data);
            },
            error: function() {
                console.log('Search error');
            }
        });
    });
    
    // Initialize FullCalendar for user calendar
    $('#user-calendar').fullCalendar({
        weekends: true,
        events: {
            url: "{{ route('tasks.timeline.data') }}",
            error: function() {
                alert('Error fetching calendar events.');
            }
        },
        eventClick: function(event, jsEvent, view) {
            jsEvent.preventDefault();
            if (event.url) {
                window.open(event.url, '_blank');
            }
        }
    });
});
</script>
@endsection
