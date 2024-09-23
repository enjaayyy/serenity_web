let rtc = {
    localAudioTrack: null,
    client: null
};

let options = {
    appId: "3a7bf343ec50426697144687e52dfac6",
    channel: "njalbeos", // Generate dynamic channel names
    token: "007eJxTYHC81mZbJz6X3//RbZOpIbEF/QEzwg1EpkostskP+P689aECg3GieVKasYlxarKpgYmRmZmluaGJiZmFeaqpUUpaYrIZ/7fHaQ2BjAynE61ZGBkgEMTnYMjLSsxJSs0vZmAAAGogIBQ=", // Fetch dynamically from backend
    uid: 123 // Dynamically assigned UID
};

// Function to start the call
async function startCall() {
    rtc.client = AgoraRTC.createClient({ mode: "rtc", codec: "vp8" });
    rtc.client.on("user-published", async (user, mediaType) => {
        await rtc.client.subscribe(user, mediaType);
        if (mediaType === "audio") {
            const remoteAudioTrack = user.audioTrack;
            remoteAudioTrack.play();
        }
    });

    rtc.client.on("user-unpublished", async (user) => {
        await rtc.client.unsubscribe(user);
    });

    // Join the channel and publish local audio
    await rtc.client.join(options.appId, options.channel, options.token, options.uid);
    rtc.localAudioTrack = await AgoraRTC.createMicrophoneAudioTrack();
    await rtc.client.publish([rtc.localAudioTrack]);

    console.log("Joined the channel and published audio");

    // Send data to Firebase (e.g., call metadata)
    // sendCallDataToFirebase();
}

// Function to leave the call
// async function leaveCall() {
//     rtc.localAudioTrack.close();
//     await rtc.client.leave();
//     console.log("Left the call");
// }

// Function to send call data to Firebase
function sendCallDataToFirebase() {
   const callData = {
        channel: "njalbeos", // Example channel name
        uid: options.uid,
        token: options.token // Example token
    };

    fetch('/generate-token', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(callData)
    })
    .then(response => response.json())
    .then(data => console.log('Success:', data))
    .catch((error) => console.error('Error:', error));
}

// Set up event listeners
document.getElementById("join").onclick = startCall;
// document.getElementById("leave").onclick = leaveCall;
