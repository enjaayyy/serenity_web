<div class = "sideBar">
        <div>
            <img src = "{{ asset('assets/logo.png') }}" class="logo">   
            </div>
            <div class = "avatar-container">
                <img src ="{{ asset('assets/avatar.png') }}" class="avatar">
                <p class="name">Administrator</p>
                    <a href="{{ route('adminDashboard') }}" style="text-decoration: none;">
                        <div class="dashboard-container">
                            <button class="dashboard-btn">
                            <img src ="{{ asset('assets/houseicon.png') }}" class="icon1">
                            <p class="icon1-txt">Dashboard</p>
                            </button>
                        </div>
                    </a>
                        <p class="user-txt">Manage Users</p>
                        <div class="doctors-container">
                            <button class="doctor-btn">
                            <img src ="{{ asset('assets/doctorlogo.png') }}" class="icon2">
                            <p class="icon2-txt">Doctors</p>
                            </button>
                        </div>
                         <div class="patient-container">
                            <button class="patient-btn">
                            <img src ="{{ asset('assets/patientlogo.png') }}" class="icon3">
                            <p class="icon3-txt">Patients</p>
                            </button>
                        </div>
                        <a href="{{ route('adminRequests') }}" style = "text-decoration: none;">
                        <div class="dashboard-container">
                            <button class="dashboard-btn">
                            <img src ="{{ asset('assets/houseicon.png') }}" class="icon1">
                            <p class="icon1-txt">Requests</p>
                            </button>  
                        </div>
                        </a>
                         <div class="dashboard-container">
                            <button class="dashboard-btn">
                            <img src ="{{ asset('assets/houseicon.png') }}" class="icon1">
                            <p class="icon1-txt">Reports</p>
                            </button>
                        </div>    
                        <a href="{{ route('login') }}" style = "text-decoration: none;"> 
                         <div class="logout-container">
                            <button class="logout-btn">
                            <img src ="{{ asset('assets/logout.png') }}" class="icon5">
                            <p class="icon5-txt">Log out</p>
                            </button>
                        </div>        
                        </a>
            </div>
    </div>