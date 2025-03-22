@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h1 class="mb-4">Admin Dashboard</h1>

  <!-- Navigation Options -->
  <div class="mb-4">
    <a href="{{ route('admin.users') }}" class="btn btn-info">
      <i class="fas fa-users"></i> Manage Users & Assign Roles
    </a>
    <a href="{{ route('categories.index') }}" class="btn btn-warning">
      <i class="fas fa-folder-open"></i> Manage Categories
    </a>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">
      <i class="fas fa-plus"></i> Create & Assign Task
    </a>
  </div>

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

  <!-- Search Form -->
  <form id="search-form" class="mb-3">
    <div class="input-group">
      <input type="text" id="task-search" name="query" class="form-control" placeholder="Search tasks...">
      <button type="submit" class="btn btn-primary">
        <i class="fas fa-search"></i> Search
      </button>
    </div>
  </form>

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
    <h2>Upcoming Tasks Calendar</h2>
    <div id="admin-calendar"></div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this task?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-danger" id="confirmDelete">Yes, Delete</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    // Delete modal handling
    var deleteModalEl = document.getElementById('deleteModal');
    var deleteModal = new bootstrap.Modal(deleteModalEl);
    var deleteForm = null;

    // Function to perform AJAX search with pagination support.
    function performSearch(page = 1) {
      var query = $('#task-search').val();
      $.ajax({
        url: "{{ route('tasks.search') }}",
        method: 'GET',
        data: { query: query, page: page },
        success: function(data) {
          $('#task-list tbody').html(data.table);
          $('#pagination-links').html(data.pagination);
        },
        error: function(xhr) {
          console.log('Search error', xhr.responseText);
        }
      });
    }

    // Bind search form submission.
    $('#search-form').on('submit', function(e) {
      e.preventDefault();
      performSearch();
    });

    // Handle pagination link clicks.
    $(document).on('click', '#pagination-links a', function(e) {
      e.preventDefault();
      var page = $(this).attr('href').split('page=')[1];
      performSearch(page);
    });

    // Delete modal: Delegate click event for delete buttons.
    $(document).on('click', '.delete-task', function(e) {
      e.preventDefault();
      deleteForm = $(this).closest('form');
      deleteModal.show();
    });

    // Confirm deletion.
    $('#confirmDelete').on('click', function() {
      if (deleteForm) {
        deleteForm.submit();
      }
    });

    // Initialize FullCalendar for admin.
    $('#admin-calendar').fullCalendar({
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
