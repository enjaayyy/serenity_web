<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
</head>
<body>
    <div class="page-container">
        <div class = "sideBar">
            <div>
                </div>
                <div class = "sidebar-content">
                    @if(session('user') === 'admin')
                    <div class="avatar-container">
                        <img src ="{{ asset('assets/avatar.png') }}" class="avatar">
                        <p class="name">Administrator</p>
                    </div>  
                        <div class="dashboard-tab-container">
                            <a href="{{ route('adminDashboard') }}" style="text-decoration: none;">
                                    <button class="dashboard-btn">
                                    <img src ="{{ asset('assets/dashboard-icon.svg') }}" class="icon1">
                                    <p class="icon1-txt">Dashboard</p>
                                    </button>
                             </a>
                        </div>
                        <p class="user-txt">Manage Users</p>
                        <div class="doctors-tab-container">
                            <a href="{{ route('doctors') }}" style = "text-decoration:none;">
                                <button class="doctor-btn">
                                <img src ="{{ asset('assets/doctor-icon.svg') }}" class="icon2">
                                <p class="icon2-txt">Doctors</p>
                                </button>
                            </a>
                        </div>
                        <div class="patient-container">
                            <a href="{{ route('patients') }}" style = "text-decoration: none;">
                                    <button class="patient-btn">
                                    <img src ="{{ asset('assets/patient-icon.svg') }}" class="icon3">
                                    <p class="icon3-txt">Patients</p>
                                    </button>
                            </a>
                        </div>
                        <div class="request-container">
                            <a href="{{ route('adminRequests') }}" style = "text-decoration: none;">
                                <button class="request-btn">
                                <img src ="{{ asset('assets/requests-icon.svg') }}" class="icon4">
                                <p class="icon4-txt">Requests</p>
                                </button>  
                            </a>
                        </div>
                            <div class="reports-container">
                                <button class="reports-btn">
                                <img src ="{{ asset('assets/report-icon.svg') }}" class="icon5">
                                <p class="icon5-txt">Reports</p>
                                </button>
                            </div>    
                        <div class="archive-container">
                            <a href="{{ route('archive') }}" style="text-decoration: none;">
                                <button class="archive-btn">
                                <img src ="{{ asset('assets/archive-icon.svg') }}" class="icon6">
                                <p class="icon6-txt">Archive</p>
                                </button>
                            </a>
                        </div> 
                        @elseif(session('user') === 'doctor')
                        <div class="main-info">
                            <div class="profile-pics">
                                @if(empty($doctorData['pic']))
                                <img src ="{{ asset('assets/avatar.png') }}" class="default-pp">
                                @else
                                <img src ="{{ $doctorData['pic'] }}">
                                @endif
                            </div>
                            <p class="doc-name">{{ $doctorData['name'] }}</p>
                            <p class="doc-job">{{ $doctorData['prof'] }}</p>
                        </div>
                        <div class="dashboard-tab-container">
                            <a href="{{ route('docDashboard') }}" style="text-decoration: none;">
                                    <button class="dashboard-btn">
                                    <img src="{{ asset('assets/dashboard-icon.svg') }}" class="icon1">
                                    <p>Dashboard</p>
                                </button>
                            </a>
                        </div>
                        <a href="{{ route('docProfile') }}" style="text-decoration: none;">
                            <div class="profile">
                                <button class="profile-btn">
                                <img src="{{ asset('assets/profile-logo.png') }}" class="profile-logo">
                                <p>Profile</p>
                                </button> 
                            </div>
                        </a>
                        
                        <a href="{{ route('viewPatients') }}" style="text-decoration: none;">
                            <div class="patients">
                                <button class="patient-btn">
                                <img src="{{ asset('assets/patientlogo.png') }}" class="patients-logo">
                                <p>My Patients</p>
                                </button>
                            </div>
                        </a>
                        <a href="{{ route('showRequests') }}" style="text-decoration: none;">
                        <div class="requests">
                            <button class="requests-btn">
                            <img src="{{ asset('assets/patientlogo.png') }}" class="requests-logo">
                            <p>Requests</p>
                            </button>
                        </div>
                        </a>
                        <div class="appointments">
                            <button class="appointment-btn">
                            <img src="{{ asset('assets/calendar.png') }}" class="appointment-logo">
                            <p>Appointments</p>
                            </button>
                        </div>
                        @endif
                        <div class="logout-container">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="logout-btn">
                                    <img src ="{{ asset('assets/logout-icon.svg') }}" class="icon7">
                                    <p class="icon7-txt">Log out</p>
                                </button>
                            </form>  
                        </div>  
                </div>
        </div>
        <div class="content">
            @yield('content')
        </div>
    </div>
    
</body>
</html>
