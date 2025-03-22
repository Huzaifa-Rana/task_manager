@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Manager Dashboard</h1>

    <!-- Summary Cards -->
    <div class="row">
        <!-- Total Team Tasks Card -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Team Tasks</h5>
                    <p class="card-text">{{ $totalTasks }}</p>
                </div>
            </div>
        </div>
        <!-- Pending Tasks Card -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Pending Tasks</h5>
                    <p class="card-text">{{ $pendingTasks }}</p>
                </div>
            </div>
        </div>
        <!-- In-Progress Tasks Card -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">In-Progress</h5>
                    <p class="card-text">{{ $inProgressTasks }}</p>
                </div>
            </div>
        </div>
        <!-- Completed Tasks Card -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Completed Tasks</h5>
                    <p class="card-text">{{ $completedTasks }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="mb-4">
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Task
        </a>
        <a href="{{ route('manager.tasks') }}" class="btn btn-secondary">
            <i class="fas fa-tasks"></i> View Team Tasks
        </a>
    </div>

    <!-- Ajax Search Input for Manager Tasks -->
    <div class="mb-3">
        <input type="text" id="manager-task-search" class="form-control" placeholder="Search team tasks...">
    </div>

    <!-- Task List Table -->
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
              <th>Actions</th>
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
        <h2>Team Tasks Calendar</h2>
        <div id="manager-calendar"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Ajax search for manager tasks
    $('#manager-task-search').on('keyup', function() {
        let query = $(this).val();
        $.ajax({
            url: "{{ route('tasks.search') }}",
            method: 'GET',
            data: { query: query },
            success: function(data) {
                $('#manager-task-list tbody').html(data);
            },
            error: function() {
                console.log('Search error');
            }
        });
    });
    
    // Initialize FullCalendar for manager calendar
    $('#manager-calendar').fullCalendar({
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
