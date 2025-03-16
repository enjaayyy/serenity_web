@extends('index')

@section('title', 'doctor-patient-appointments')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/doctor/appointments.css') }}">
    <div class="container">
      <div class="admin-header">
          <p class="dash-text">Appointments</p>
          <img src="{{asset('assets/logo-w-text.svg') }}" class="page-logo">
      </div>
      <div class="main-content">
        <div id='calendar' class="calendar"></div>
        <div id='appointments' class="appointments-container">
          <div class="schedules-container" id="schedules-container">

          </div>
          <button id="add-event" class="add-event">
            Add Event
          </button>
        </div>
      </div>
    </div>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script src="{{ asset('js/doctor/addschedule.js') }}"></script>
    <script>
      let calendar;
      document.addEventListener('DOMContentLoaded', function() {
        let calendarEl = document.getElementById('calendar');
        let calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth'
        });
        calendar.render();

        // displayCalendarSchedules(calendar);

        let addEvent = document.getElementById('add-event');
        addEvent.addEventListener("click", function(){
          addSchedule();
            
        })
      });

    </script>


@endsection