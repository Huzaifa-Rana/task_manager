@extends('layouts.app')

@section('content')
    <h1>Task Calendar</h1>
    <div id="calendar"></div>
@endsection

@section('scripts')
<script type="module">
    import { Calendar } from '@fullcalendar/core';
    import dayGridPlugin from '@fullcalendar/daygrid';

    document.addEventListener('DOMContentLoaded', function() {
        let calendarEl = document.getElementById('calendar');
        let calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin],
            initialView: 'dayGridMonth',
            // Additional settings and events can be loaded here via Ajax
        });
        calendar.render();
    });
</script>
@endsection
