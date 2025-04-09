@extends('index')

@section('title', 'Doctor Dashboard')

@section('content')
        <link rel="stylesheet" href="{{ asset('css/doctor/dashboard.css') }}">
        <div class="container">
            <div class="admin-header">
                <p class="dash-text">Dashboard</p>
                <img src="{{asset('assets/logo-w-text.svg') }}" class="page-logo">
            </div>
            <div class="first-container">
                <div class="welcome-div" style="background-image: url('{{ asset('assets/admin-dash.png')}}')">
                    <p class="welcome-text">Welcome Dr. {{$doctorData['name']}}</p>
                    <div class="toProfile-btn">
                        <a href="{{ route('docProfile')}}" style="text-decoration: none;"><button >View Profile</button></a>    
                    </div>
                </div>
                <div class="patient-count-div">
                    <div class="patient-counter-icon-div">
                        <img class="patient-img" src="{{ asset('assets/patient-icon.svg') }}">
                    </div>
                    <div class="patient-counter-details-div">
                        <p class="counter-header">Patients</p>
                        <p class="counter-data">{{ $patientCount }}</p>
                    </div>
                </div>
                <div class="request-count-div">
                    <div class="request-counter-icon-div">
                        <img class="request-img" src="{{ asset('assets/requests-icon.svg') }}">
                    </div>
                    <div class="request-counter-details-div">
                        <p class="counter-header">Requests</p>
                        <p class="counter-data">{{ $requestCount }}</p>
                    </div>
                </div>
                <div class="appointments-count-div">
                    <div class="appointments-counter-icon-div">
                        <img class="appointments-img" src="{{ asset('assets/calendar-icon.svg') }}">
                    </div>
                    <div class="appointments-counter-details-div">
                        <p class="counter-header">Appointments</p>
                        <p class="counter-data">{{ $appointmentCount }}</p>
                    </div>
                </div>
            </div>
            <div class="main-body-container">
                <div class="main-body-left">
                    <div class="left-body-header-container">
                        <p class="left-body-headers">Upcoming Appointments</p>
                        <p class="left-body-link"><a href="{{ route('viewAppointments')}}">See All</a></p>
                    </div>
                    <div class = "dash-appointments-container">
                        @foreach($appointmentList as $apts)
                            <div class="appointment-wrapper">
                                <div class="indicator-div" style="background-color: {{ $apts['appointmentColor']}};"></div>
                                <div class="appointment-details-div">
                                    <p class="apppointment-name">{{ $apts['appointmentPatient'] }}</p>
                                    <p class="apppointment-title">{{ $apts['appointmentTitle'] }}</p>
                                </div>
                                <div class="appointment-date-div">
                                    <p class="apppointment-date">{{ $apts['appointmentDate'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                     <div class="left-body-header-container">
                        <p class="left-body-headers">Patient Request</p>
                        <p class="left-body-link"><a href="{{ route('showAppointments')}}">See All</a></p>
                    </div>
                    <div class="request-appointments-container">

                    </div>
                </div>
                <div class="main-body-right">

                </div>
            </div>

        </div>
            {{-- <form method="POST" action=" {{ route('sampleData')}} ">
                @csrf
                <button>Sample questions</button>
            </form> --}}
        </div>
 @endsection