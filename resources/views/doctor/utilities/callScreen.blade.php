<link rel="stylesheet" href="{{ asset('css/doctor/utilities/callScreen.css')}}">
<div class="call-screen" id="call-screen">
    <div class="header-div">
        <img src="{{asset('assets/logo-w-text.svg') }}" class="page-logo">
    </div>
    <div class="call-body">
        <div>
            <img src="{{ asset('assets/avatar.png') }}" class="profile-img">
            <p class="patient-call-name">{{ $patientDetails['name'] }}</p>
        </div>

    </div>
</div>