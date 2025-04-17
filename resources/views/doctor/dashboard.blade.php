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
                        @if(isset($appointmentList) && is_array($appointmentList))
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
                        @else
                            <div class="alt-request-container">
                                <p>No Appointments available</p>
                            </div>
                        @endif
                    </div>
                    <div class="left-body-header-container">
                        <p class="left-body-headers">Patient Request</p>
                        <p class="left-body-link"><a href="{{ route('showAppointments')}}">See All</a></p>
                    </div>
                    <div class="request-appointments-container">
                        @if(isset($requestList) && is_array($requestList))
                            @foreach($requestList as $reqs)
                                <div class="requests-wrapper">
                                    <div class="req-profile-container">
                                        @if($reqs['img'] == null)
                                            <img src ="{{ asset('assets/avatar.png') }}" class="default-req-img">
                                        @else
                                            <img src ="{{ $reqs['img'] }}" class="default-req-img">
                                        @endif
                                    </div>
                                    <div class="reqs-details">
                                        <p class="reqs-patient-name">{{ $reqs['name']}}</p>
                                            <div class="request-condition-container">
                                                <p>Conditions:&nbsp;</p>
                                                @if(isset($reqs['conditions']) && is_array($reqs['conditions']))
                                                    @foreach($reqs['conditions'] as $req)
                                                        <p>{{ $req }} &nbsp;</p>
                                                    @endforeach 
                                                @endif
                                            </div>
                                    </div>
                                    <div class="request-date-div">
                                        <p>{{ $reqs['timestamp']}} </p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="alt-request-container">
                                <p>No requests available</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="main-body-right">
                    <div class="right-body-header-container">
                        <p class="left-body-headers">Patient Condition Summary</p>
                    </div>
                    <div class="pie-chart-container">
                        <canvas id="patient-summary-pie-chart"></canvas>
                    </div>  
                </div>
            </div>

        </div>
            {{-- <form method="POST" action=" {{ route('sampleData')}} ">
                @csrf
                <button>Sample questions</button>
            </form> --}}
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        {{-- <script src="{{ asset('js/doctor/dashboardChart.js') }}"></script> --}}
        <script>
            // let x  = @json($ptscount);
            // console.log("number of pts patients " + x);
            // document.addEventListener("DOMContentLoaded", function(){
            //    pie();
            // })  
        </script>
 @endsection