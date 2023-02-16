@extends('layouts.dashboard') @section('content')
    <div class="container-fluid p-0">
        <h4 class="mb-3">{{ $calendar->name }}</h4>

        <div class="row justify-content-center">
            <div id="calendar"></div>
        </div>

    </div>
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calevent = @json($event);
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    start: 'prev,today,next',
                    center: 'title',
                    end: 'dayGridMonth,dayGridWeek,listWeek'
                },
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true
                },
                events: calevent

            });
            setTimeout(function() {
                calendar.render();
            })
        });
    </script>
@endpush

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.css" rel="stylesheet" />
@endpush
