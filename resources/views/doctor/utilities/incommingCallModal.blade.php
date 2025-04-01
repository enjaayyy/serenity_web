<link rel="stylesheet" href="{{ asset('css/doctor/utilities/incommingCallModal.css')}}">
<div class="call-modal-container" id="call-modal-container">
   <div class="call-modal">
      <div class="call-image-container" id="call-image-container">

      </div>
      <div class="call-details-container">
         <p class="call-details-status">Incoming Call</p>
         <p class="call-patient-name" id="call-patient-name"> </p>
      </div>
      <div class="call-functions-container">
         <button class="call-accept" onclick="acceptCall()">Accept</button>
         <button class="call-decline" onclick="endCall()">Decline</button>
      </div>
   </div>
</div>
@include('doctor.utilities.callScreen')
<script>
   async function acceptCall(){
      document.getElementById('call-modal-container').style.display = "none";
      document.getElementById('call-image-container').innerHTML = " ";
      stopRingtone();

      document.getElementById('call-screen').style.display = 'block';
      document.getElementById('patient-call-name').innerText = callerName;
      try{
         client = AgoraRTC.createClient({ mode: "rtc", codec: "vp8" });
         await client.join(APP_ID, callKey, callToken, null);

         localAudioTrack = await AgoraRTC.createMicrophoneAudioTrack();
         
         if(localAudioTrack){
            await client.publish(localAudioTrack);
            console.log('Connection Successful, Microphone established');
         }
         else{
            console.log('Connection Failed');
         }

         client.on("user-published", async (user, mediaType) => {
            if (mediaType === "audio") {
               await client.subscribe(user, mediaType);
               const remoteAudioTrack = user.audioTrack;
               remoteAudioTrack.play();
               console.log(`Playing remote audio from user ${user.uid}`);
            }
         });

         client.on("user-unpublished", (user) => {
            console.log(`User ${user.uid} left the call.`);
         });
      } catch (error){
         console.error("Error starting the call:", error);
      }
      
   }
   function endCall(){
      document.getElementById('call-modal-container').style.display = "none";
      document.getElementById('call-image-container').innerHTML = " ";
      stopRingtone();
   }
</script>