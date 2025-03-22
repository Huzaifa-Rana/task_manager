@extends('layouts.app')

@section('content')
    <h1>Task Timeline</h1>
    <!-- Calendar container -->
    <div id="calendar"></div>
@endsection

@section('scripts')
<script type="module">
    // Import FullCalendar modules using ES module syntax
    import { Calendar } from '@fullcalendar/core';
    import dayGridPlugin from '@fullcalendar/daygrid';

    document.addEventListener('DOMContentLoaded', function() {
        let calendarEl = document.getElementById('calendar');

        let calendar = new Calendar(calendarEl, {
            plugins: [ dayGridPlugin ],
            initialView: 'dayGridMonth',
            events: {
                url: "{{ route('tasks.timeline.data') }}",
                failure: function() {
                    alert('There was an error while fetching events!');
                }
            },
            eventClick: function(info) {
                // Prevent the browser from following the URL automatically
                info.jsEvent.preventDefault();
                // Open the task detail page in a new tab if the event has a URL
                if (info.event.url) {
                    window.open(info.event.url, '_blank');
                }
            }
        });

        // Render the calendar
        calendar.render();
    });
</script>
@endsection
