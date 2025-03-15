@extends('index')

@section('title', 'doctor-patient-appointments')

@section('content')
    <div id='calendar'></div>
    <button id="add-event">add event</button>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>

      document.addEventListener('DOMContentLoaded', function() {
        let calendarEl = document.getElementById('calendar');
        let calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth'
        });
        calendar.render();

        let addEvent = document.getElementById('add-event');
        addEvent.addEventListener("click", function(){
            calendar.addEvent({
                title: 'Meeting with John',
                start: '2025-03-20',
            });
        })
      });

    </script>


@endsection