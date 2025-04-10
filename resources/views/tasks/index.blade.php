@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h1 class="mb-4">Task List</h1>

  <!-- Search Form with Button -->
  <form id="search-form" class="mb-3">
    <div class="input-group">
      <input type="text" id="task-search" name="query" class="form-control" placeholder="Search tasks...">
      <button type="submit" class="btn btn-primary">
        <i class="fas fa-search"></i> Search
      </button>
    </div>
  </form>

  <!-- Create Task Button (visible only to admin and manager) -->
  @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'manager']))
  <div class="mb-3">
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">
      <i class="fas fa-plus"></i> Create Task
    </a>
  </div>
  @endif

  <!-- Tasks Table -->
  <div id="task-list">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Title</th>
          <th>Due Date</th>
          <th>Priority</th>
          <th>Status</th>
          <th>Assigned To</th>
          <th>User Role</th>
          @if(auth()->check() && auth()->user()->hasAnyRole(['admin','manager']))
            <th>Actions</th>
          @endif
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
  // Ensure our script runs after the document is ready.
  $(document).ready(function() {
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

    // Delete modal handling.
    var deleteModalEl = document.getElementById('deleteModal');
    var deleteModal = new bootstrap.Modal(deleteModalEl);
    var deleteForm = null;
    $(document).on('click', '.delete-task', function(e) {
      e.preventDefault();
      deleteForm = $(this).closest('form');
      deleteModal.show();
    });
    $('#confirmDelete').on('click', function() {
      if (deleteForm) {
        deleteForm.submit();
      }
    });
  });
</script>
@endsection
