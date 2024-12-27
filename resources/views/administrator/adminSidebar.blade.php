<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/administrator/sidebar.css') }}">
</head>
<body>
    <div class="page-container">
        <div class = "sideBar">
            <div>
                </div>
                <div class = "sidebar-content">
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
                                <img src ="{{ asset('assets/report-icon.svg') }}" class="icon7">
                                <p class="icon7-txt">Reports</p>
                                </button>
                            </div>    
                        <div class="archive-container">
                            <a href="{{ route('archive') }}" style="text-decoration: none;">
                                <button class="archive-btn">
                                <img src ="{{ asset('assets/archive.png') }}" class="icon6">
                                <p class="icon6-txt">Archive</p>
                                </button>
                            </a>
                        </div> 
                        <div class="logout-container">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="logout-btn">
                                    <img src ="{{ asset('assets/logout.png') }}" class="icon5">
                                    <p class="icon5-txt">Log out</p>
                                </button>
                            </form>  
                        </div>  
                </div>
        </div>
        <div class="content">
            {{-- @yield('content') --}}
        </div>
    </div>
    
</body>
</html>
