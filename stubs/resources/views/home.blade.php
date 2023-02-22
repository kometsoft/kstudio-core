@extends('layouts.dashboard') @section('content')
<div class="container-fluid p-0">
	<h4 class="mb-3">Dashboard</h4>

	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">{{ __('Dashboard') }}</div>

				<div class="card-body">
					@if (session('status'))
					<div class="alert alert-success" role="alert">
						{{ session('status') }}
					</div>
					@endif

					{{ __('You are logged in!') }}
				</div>
			</div>
		</div>
	</div>

	<div id="dashboard-calendar"></div>
</div>

@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.js"></script> 

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('dashboard-calendar');
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
            // events: bookings
            events: [
            {
                title: 'All Day Event',
                start: '2022-05-01',
            },
            {
                title: 'Long Event',
                start: '2022-05-07',
            },
            {
                groupId: 999,
                title: 'Repeating Event',
                start: '2022-05-09'
            },
            {
                groupId: 999,
                title: 'Repeating Event',
                start: '2022-05-16',
                icon: 'ti ti-alien'
            },
            {
                title: 'Conference',
                start: '2022-05-11',
            },
            {
                title: 'Meeting',
                start: '2022-05-12',
            },
            {
                title: 'Lunch',
                color: 'red',
                icon: 'ti ti-user',
                start: '2022-05-12'
            },
            {
                title: 'Meeting',
                color: 'yellow',
                start: '2022-05-12'
            },
            {
                title: 'Happy Hour',
                start: '2022-05-12'
            },
            {
                title: 'Dinner',
                start: '2022-05-12'
            },
            {
                title: 'Birthday Party',
                start: '2022-05-13'
            },
            {
                title: 'Click for Google',
                url: 'http://google.com/',
                start: '2022-05-28'
            }
            ]
        });
        setTimeout(function(){
            calendar.render();
        })
      });
</script>
@endpush

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.css" rel="stylesheet" /> 
@endpush