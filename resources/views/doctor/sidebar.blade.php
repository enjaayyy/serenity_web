<div class="sidebar">
    <div>
        <img src = "{{ asset('assets/logo.png') }}" class="logo">   
        
    </div>
    <div class="main-info">
        <div class="profile-pics">
            @if(empty($doctorData['pic']))
            <img src ="{{ asset('assets/avatar.png') }}" class="default-pp">
             @else
            <img src ="{{ $doctorData['pic'] }}" class="profile-pic-enabled">
            @endif
        </div>
        <p class="doc-name">{{ $doctorData['name'] }}</p>
        <p class="doc-job">{{ $doctorData['prof'] }}</p>
    </div>
    <a href="{{ route('docDashboard') }}" style="text-decoration: none;">
        <div class="dashboard">
            <button class="dashboard-btn">
            <img src="{{ asset('assets/houseicon.png') }}" class="dash-logo">
            <p>Dashboard</p>
        </button>
    </div>
    </a>
    
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
    <form action="{{ route('logout') }}" method="POST">
        @csrf
    <div class="logout">
        <button class="logout-btn">
        <img src="{{ asset('assets/logout.png') }}" class="logout-logo">
        <p>Log out</p>
        </button>
    </div>
    </form>
    

</div>
