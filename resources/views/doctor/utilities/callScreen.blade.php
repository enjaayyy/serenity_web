<link rel="stylesheet" href="{{ asset('css/doctor/utilities/callScreen.css')}}">
<div class="call-screen" id="call-screen">
    <div class="header-div">
        <img src="{{asset('assets/logo-w-text.svg') }}" class="page-logo">
    </div>
    <div class="call-body">
        <div>
            <img src="{{ asset('assets/avatar.png') }}" class="profile-img">
            @if(isset($patientDetails['name']))
                <p class="patient-call-name">{{ $patientDetails['name'] }}</p>
            @else
                <p class="patient-call-name" id="patient-call-name"></p>
            @endif
            <button class="end-call" id="end-call" onclick="endCall()"><img src="{{ asset('assets/end-call-icon.svg') }}"></button>
        </div>
    </div>
</div>

<script>
    function endCall(){
        document.getElementById('call-screen').style.display = "none";
    }
</script>