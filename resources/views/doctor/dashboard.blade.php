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

        </div>
            {{-- <form method="POST" action=" {{ route('sampleData')}} ">
                @csrf
                <button>Sample questions</button>
            </form> --}}
        </div>
 @endsection