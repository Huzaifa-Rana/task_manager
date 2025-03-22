@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Task Dashboard</h1>

    <!-- Summary Cards -->
    <div class="row">
        <!-- Total Tasks Card -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Tasks</h5>
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
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
            <i class="fas fa-tasks"></i> View All Tasks
        </a>
    </div>

    <!-- Calendar Preview -->
    <div class="mb-4">
        <h2>Upcoming Tasks Calendar</h2>
        <div id="calendar"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    // Initialize the FullCalendar
    $('#calendar').fullCalendar({
      // You can add any configuration options here
      weekends: true,
      // Fetch events from your timeline data route
      events: {
        url: "{{ route('tasks.timeline.data') }}",
        error: function() {
          alert('Error fetching calendar events.');
        }
      },
      eventClick: function(event, jsEvent, view) {
        jsEvent.preventDefault(); // Prevent default browser navigation
        if (event.url) {
          window.open(event.url, '_blank');
        }
      }
    });
  });
</script>
@endsection
