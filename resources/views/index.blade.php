<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <script src="https://download.agora.io/sdk/release/AgoraRTC_N-4.23.1.js"></script>
    <script type="module" src="{{ asset("js/doctor/firebase_connection.js")}}"></script>
    <script>
        const incomingCallAudio = new Audio("{{ asset('assets/audio/call-sound.mp3')}}");
        incomingCallAudio.loop = true;
        
        let callerName;
        let callToken;
        let callData;
        let client;
        let callKey;
        let localAudioTrack;
        const APP_ID = "3a7bf343ec50426697144687e52dfac6"; 
        const userInteraction = true;

        function stopRingtone() {
            incomingCallAudio.pause();
            incomingCallAudio.currentTime = 0; 
        }
    </script>
    <script type="module">
        
    </script>
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
                        <div class="admin-manage-tab">
                            <p class="name">Manage Users</p>
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
                                <a href="{{ route('viewReports') }}" style="text-decoration: none;">
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
                        </div>
                        @elseif(session('user') === 'doctor')
                        <div class="main-info">
                            <div class="avatar-container">
                                @if(empty($doctorData['pic']))
                                <img src ="{{ asset('assets/avatar.png') }}" class="default-pp">
                                @else
                                <img src ="{{ $doctorData['pic'] }}">
                                @endif
                                <p class="doc-name">{{ $doctorData['name'] }}</p>
                                <p class="doc-job">{{ $doctorData['prof'] }}</p>
                            </div>
                        </div>
                        <div class="dashboard-tab-container">
                            <a href="{{ route('docDashboard') }}" style="text-decoration: none;">
                                    <button class="dashboard-btn">
                                    <img src="{{ asset('assets/dashboard-icon.svg') }}" class="icon1">
                                    <p>Dashboard</p>
                                </button>
                            </a>
                        </div>
                        <div class="profile-tab-container">
                            <a href="{{ route('docProfile') }}" style="text-decoration: none;">
                                    <button class="profile-btn">
                                    <img src="{{ asset('assets/account-icon.svg') }}" class="icon8">
                                    <p>Profile</p>
                                    </button> 
                            </a>
                        </div>
                        <div class="patients-tab-container">
                            <a href="{{ route('viewPatients') }}" style="text-decoration: none;">
                                    <button class="patient-btn">
                                    <img src="{{ asset('assets/patient-icon.svg') }}" class="icon3">
                                    <p>My Patients</p>
                                    </button>
                            </a>
                        </div>
                        <div class="requests-tab-container">
                            <a href="{{ route('showAppointments') }}" style="text-decoration: none;">
                                <button class="request-btn">
                                <img src="{{ asset('assets/requests-icon.svg') }}" class="icon4">
                                <p>Requests</p>
                                </button>
                            </a>
                        </div>
                        <div class="appointments">
                            <a href="{{ route('viewAppointments') }}" style="text-decoration: none;">
                                <button class="appointment-btn">
                                <img src="{{ asset('assets/calendar-icon.svg') }}" class="icon9">
                                <p>Appointments</p>
                                </button>
                            </a>
                        </div>
                        <script type="module">
                            import { ref, onChildAdded, child, get, update } from '/js/doctor/firebase_connection.js';

                            async function listenForCalls(){
                                const docID = "{{ $doctorData['docID'] }}";
                                const callListener = ref(database, `agoraChannels/`);
                                
                                onChildAdded(callListener, async (snapshot) => {
                                    
                                    callKey = snapshot.key;

                                    const [doctorID, patientID] = callKey.split("-");
                                    
                                    if(callKey.includes(docID)){
                                        // console.log("you are being called, Channel name" + callKey);
                                        if(userInteraction){
                                            incomingCallAudio.play();
                                        }

                                        const callRef = child(callListener, callKey);
                                        const callSnapshot = await get(callRef);
                                        callData = callSnapshot.val();

                                        const patientDataRef = ref(database, `administrator/users/${patientID}`);
                                        const patientSnapshot = await get(patientDataRef);
                                        const patientValues = patientSnapshot.val();
                                        console.log(callData); 

                                        callerName = patientValues.full_name;

                                        let profileContainer = document.getElementById('call-image-container');

                                        let pImg = document.createElement('img');
                                        pImg.src = patientValues.profile_image;
                                        pImg.classList.add("call-profile-img");
                                        profileContainer.appendChild(pImg);

                                        callToken = callData.token;
                                        document.getElementById('call-modal-container').style.display = "inline-flex";
                                        document.getElementById('call-patient-name').innerText = patientValues.full_name;
                                    }
                                    else{
                                        document.getElementById('call-modal-container').style.display = "none";
                                        profileContainer.innerHTML = " ";
                                    }
                                })
                            }

                            listenForCalls();
                        </script>
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
        @include('doctor.utilities.profileuploadcard')
        @include('doctor.utilities.incommingCallModal')
        <div class="content">
            @yield('content')
        </div>
    </div>
</body>
</html>
