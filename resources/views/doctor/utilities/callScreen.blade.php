<link rel="stylesheet" href="{{ asset('css/doctor/utilities/callScreen.css')}}">
<div class="call-screen" id="call-screen">
    <div class="header-div">
        <img src="{{asset('assets/logo-w-text.svg') }}" class="page-logo">
    </div>
    <div class="call-body">
        <div>
            @if(isset($patientDetails['pic']))
                <img src="{{ $patientDetails['pic'] }}" class="profile-call-img">
            @else
                <img src="{{ asset('assets/avatar.png') }}" id="profile-call-img" class="profile-call-img">
            @endif
            
            @if(isset($patientDetails['name']))
                <p class="patient-call-name">{{ $patientDetails['name'] }}</p>
            @else
                <p class="patient-call-name" id="patient-call-name">Ghelorie P. Manondo</p>
            @endif
            <p class="call-status" id="call-status"></p>
            <button class="end-call" id="end-call" onclick="endCall()"><img src="{{ asset('assets/end-call-icon.svg') }}"></button>
        </div>
    </div>
</div>

<script type="module">
    import { ref, onChildAdded, child, get, update, remove } from '/js/doctor/firebase_connection.js';

    window.endCall =  async function () {
        document.getElementById('call-screen').style.display = "none";
        document.getElementById('call-modal-container').style.display = "none";

        stopRingtone();
        const channelRef = ref(database, `agoraChannels/${callKey}`);
        localAudioTrack.stop();
        localAudioTrack.close();
        await client.leave();

        remove(channelRef)
            .then(() =>{
                console.log("Channel Deleted Successfully");
            })
            .catch((error) => {
                console.log("Error Deleting Node");
            });

        // console.log("THis is the callKey" + callKey);
    }
</script>