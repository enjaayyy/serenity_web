@extends('index')

@section('title', 'doctor-patient-appointments')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/doctor/appointments.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="container">
      <div class="admin-header">
          <p class="dash-text">Appointments</p>
          <img src="{{asset('assets/logo-w-text.svg') }}" class="page-logo">
      </div>
      <div class="main-content">
        <div id='calendar' class="calendar"></div>
        <div id='appointments' class="appointments-container">
          @foreach($appointments as $apt)
            <div class="schedule-container" id="schedules-container">
              <div class="color-indicator">
                <div class="circle" style="background-color: {{ $apt['color'] }}"></div>
              </div>
              <div class="apt-details">
                <p class="apt-date">{{date('F j, Y', strtotime($apt['date']))}} {{date("g:i A", strtotime($apt['start']))}} - {{date("g:i A", strtotime($apt['end']))}}</p>
                  <p class="apt-title">{{$apt['title']}}</p>
                  <p class="apt-patient">- {{$apt['name']}}</p>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="add-button-container">
      <button onclick="openAddAppointmentModal()" class="add-sched-button">
        <img src={{ asset('assets/add-calendar-icon.svg') }}>
      </button>
    </div>
     @if(session("error"))
        <script>
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: "{{ session('error') }}",
            });
        </script>
      @elseif(session("success"))
        <script>
            Swal.fire({
              icon: 'success',
              title: 'Congratulations',
              text: "{{ session('success') }}",
            });
        </script>
      @endif
    @include('doctor.utilities.addAppointmentModal')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>
        // let x = @json($appointments);
        // console.log(x);
      let calendar;
      document.addEventListener('DOMContentLoaded', function() {
        let calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          headerToolbar: {
            left: 'prev,today,listWeek',
            center: 'title',  
            right: 'dayGridMonth,timeGridDay,next',
          },
          buttonText:{
            today: 'Today',
            list: 'List',
            month: 'Month',
            day: 'Day',
          }
        });
        calendar.render();
        getSchedulesForCalendar();

        
      });

      function openAddAppointmentModal(){
        document.getElementById('add-appointment-screen').style.display = "inline-flex";
      }

      function getSchedulesForCalendar(){
        let schedules = @json($appointments);
        // console.log(schedules);

        schedules.forEach(sKey => {
           calendar.addEvent({
              title: sKey.title,
              start: sKey.date + 'T' + sKey.start + ':00',
              end: sKey.date + 'T' + sKey.end + ':00',
              backgroundColor: sKey.color,
              classNames: ['events'],
            });
        })
      }

    </script>


@endsection