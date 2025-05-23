@extends('index')

@section('title', 'patient-profile')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/doctor/patientProfile.css') }}">
    <script>
        const chatID = "{{ $chatID }}"; 
    </script>
    <script type="module">
        import { ref, onChildAdded, child, get, update, signInWithPopup, GoogleAuthProvider } from '/js/doctor/firebase_connection.js';
         function listenForMessages() {
                    const messagesRef = ref(database, `administrator/chats/${chatID}`);

                    onChildAdded(messagesRef, (snapshot) => {
                        const message = snapshot.val();
                        
                        const chatContent = document.getElementById('chat-content');
                        const newMessageDiv = document.createElement('div');
                        newMessageDiv.style.display = "flex";
                        newMessageDiv.classList.add('message-container');

                        let profileImg = document.createElement('img');
                        const profileImgcontainer = document.createElement('div');
                        
                        const messageParagraph = document.createElement('p');
                            messageParagraph.textContent = message.message;

                        const paragraphDiv = document.createElement("div");
                            paragraphDiv.classList.add('message-div');

                        let formattedtimestamp = message.timestamp;
                        let date = new Date(message.timestamp);
                        formattedtimestamp = date.toLocaleString("en-us", {
                            month: "2-digit",
                            day: "2-digit",
                            year: "numeric",
                            hour: "2-digit",
                            minute: "2-digit",
                            hour12: true
                        });

                        const messageSent = document.createElement('p');
                            messageSent.textContent = formattedtimestamp;
                            messageSent.classList.add('time-sent');

                        const timeDiv = document.createElement('div');

                        const messagewrapper = document.createElement('div');
                        messagewrapper.classList.add('messagewrapper-container');

                        if (message.senderId === "{{ $doctorData['docID'] }}") {
                            newMessageDiv.style.justifyContent = "flex-end"; 
                            timeDiv.style.textAlign = "right";
                            paragraphDiv.style.backgroundColor = "#20C073";
                        } 
                        else {
                            newMessageDiv.style.justifyContent = "flex-start"; 
                            timeDiv.style.textAlign = "left";
                            paragraphDiv.style.backgroundColor = "#49B2FF";

                        }

                        timeDiv.appendChild(messageSent);
                        paragraphDiv.appendChild(messageParagraph);

                        messagewrapper.appendChild(timeDiv);
                        messagewrapper.appendChild(paragraphDiv);
                        
                        newMessageDiv.appendChild(messagewrapper);
                        chatContent.appendChild(newMessageDiv);


                        chatContent.scrollTop = chatContent.scrollHeight;
                    });
                }
                document.addEventListener("DOMContentLoaded", function() {
                    listenForMessages();
                });
    </script>
            <div class='container'>
                <div class="admin-header">
                    <p class="dash-text">Patient Profile</p>
                    <img src="{{asset('assets/logo-w-text.svg') }}" class="page-logo">
                </div>
                <div class="main-content" id="main-content" data-info='@json($patientDetails)'>
                    <div class="user-info-container">
                        <div class="user-info">
                            <div class="profile-pic-container">
                                @if($patientDetails['pic'])
                                    <img src="{{ $patientDetails['pic'] }}" class="profile-img">
                                @else
                                    <img src="{{ asset('assets/avatar.png') }}" class="profile-img">
                                @endif
                                <p class="patient-name">{{ $patientDetails['name'] }}</p>
                                <p class="patient-email">{{ $patientDetails['email'] }}</p>
                            </div>
                            <div class="mood-container" id="mood-container">

                            </div>
                            <div class="additional-user-info">
                                <p class="additional-user-info-header">Additional Information</p>
                                <div class="main-user-info">
                                    <p class="data-header">Username</p>
                                    <p class="main-data">{{ $patientDetails['username']}}</p>
                                    <p class="data-header">Sex</p>
                                    <p class="main-data">{{ $patientDetails['sex']}}</p>
                                    <p class="data-header">Birth Date</p>
                                    <p class="main-data">{{ $patientDetails['bday']}}</p>
                                    <p class="data-header">Phone no.</p>
                                    <p class="main-data">{{ $patientDetails['num']}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="analytics-container">
                        <div class="year-chart-div">
                            <div class="chart-container">
                                <p class="yearly-header">Yearly Results</p>
                                <canvas id="year-chart" width="10vw" height="5vh"></canvas>
                            </div>
                        </div>
                        <div class="breakdown-group">
                            <div class="analytics-box">
                                    <div class="conditions-group">
                                        @if(isset($patientDetails['condition']) && is_array($patientDetails['condition']))
                                            @foreach($patientDetails['condition'] as $condition)
                                                <button class="conditions-container" id="conditions-containers">
                                                    <p>{{ $condition }}</p>
                                                </button>
                                            @endforeach 
                                        @endif
                                    </div>
                                    <div class="main-analytics-container">
                                            <div class="chart-container">
                                                <p class="monthly-header">Monthly Results</p>
                                                <div class="month-functions">
                                                    <button class="back" id="back">
                                                        <img src="{{ asset('assets/arrow-left.svg')}}">
                                                    </button>
                                                    <p class="currentMonth" id="currentMonth"></p>
                                                    <button class="next" id="next">
                                                        <img src="{{ asset('assets/arrow-right.svg')}}">
                                                    </button>
                                                </div>
                                                <canvas id="month-chart"></canvas>
                                            </div>
                                            <p class="monthly-breakdown-header">Monthly Questionnaire Breakdown</p>
                                            <p class="monthly-breakdown-subheader">*This section is a breakdown of the total scores per category</p>
                                            <div class="chart-breakdown-container" id="chart-breakdown-container">
                                            </div>
                                    </div>
                            </div>
                            <script>
                                let c = @json($total);
                                console.log(c);
                            </script>
                            <div class="additional-info-container">
                                <div class="answered-questions-container">
                                    <div class="questionnaire-header-container">
                                        <p class="aqc-header">Questionnaire History</p>
                                    </div>
                                    <div class="questionnaire-history-container" id="questionnaire-history-container">

                                    </div>
                                </div>
                                <div class="notes-container">
                                    <div class="notes-header-container">
                                        <p class="notes-history-header">Notes History</p>
                                    </div>
                                    <div class="notes-history-container" id="notes-history-container">
                                        {{-- <script>
                                            let n = @json($patientDetails['notes']);
                                            console.log(n);
                                        </script> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="call-chat-container">
                <div class="function-buttons">
                    <div class="report-button-container">
                        <button class="report-button" type="button" onclick="openReportModal()">
                            <img src={{ asset('assets/report-icon.svg') }}>
                        </button>
                    </div>
                    <div class="add-button-container">
                        <button class="add-button" type="button" onclick="openNotesModal()">
                            <img src={{ asset('assets/plus-icon.svg') }}>
                        </button>
                    </div>
                    <div class="call-button-container">
                        <button onclick="openCall()" class="call-button">
                            <img src={{ asset('assets/call-icon.svg') }}>
                        </button>
                    </div>
                    <div class="mess-button-container">
                        <button onclick="openChat()" class="mess-button">
                            <img src={{ asset('assets/message-icon.svg') }}>
                        </button>
                    </div>
                </div>
                <div class="chat-screen" id="chat-screen" style="display: none;">
                    <div class="chat-div" id="chat-div" style="display: none;">
                        <div class="chat-header">
                            <button onclick="closeChat()">
                                <img src={{ asset('assets/arrow-left.svg') }}>
                            </button>
                            <p class="chat-name-header">{{ $patientDetails['name'] }}</p>
                        </div>
                        <div class="chat-ctnt" id="chat-content">
                        </div>
                        <div class="chat-input">
                            <input type="text" id="chat-input" class="chat-box">
                            <button onclick="sendMessage()">
                                <img src="{{ asset('assets/send-icon.svg') }}">
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @include('doctor.utilities.reportModal')
            @include('doctor.utilities.addNotesModal')
            @include('doctor.utilities.viewNotesModal')
            @include('doctor.utilities.callScreen')
            <link rel="stylesheet" href="{{ asset('css/doctor/utilities/viewquestionnaire.css') }}">
            <script src="https://cdn.jsdelivr.net/npm/chart.js"> </script>
            <script src="https://download.agora.io/sdk/release/AgoraRTC_N-4.23.1.js"></script>
            <script type="module">
                import { ref, onChildAdded, child, get, update, set, signInWithPopup, GoogleAuthProvider } from '/js/doctor/firebase_connection.js';
                let chartCondition;
                let channelName = "testChannel"; 
                let token = null;
                const firebaseURL = "https://asia-southeast1-serenity-c800c.cloudfunctions.net/generateTokenWeb";

                // console.log(token);
                // console.log(channelName);
                async function getToken() {
                    const user = window.auth.currentUser;
                    if(!user){
                        console.error("User not authenticated");
                        return null;
                    }

                    return await user.getIdToken();
                }


                window.openCall = async function openCall(){
                    document.getElementById('call-screen').style.display = 'block';

                    const idToken = await getToken();
                    if (!idToken) {
                        alert("User not authenticated");
                        return;
                    }

                    const response = await fetch(firebaseURL, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "Authorization": `Bearer ${idToken}`
                            },
                            body: JSON.stringify({
                                patientId: @json($patientDetails['patientID']),
                                callerName:  @json($doctorData['name']),
                            }),
                        });
                        try {
                        if(!response.ok){
                            throw new Error("Failed to fetch Token");
                        }

                        const data = await response.json();
                        // console.log(data);
                        token = data.token;
                        // console.log(token);
                        channelName = data.channelName;
                        // console.log(token);
                        // console.log(channelName);
                        client = AgoraRTC.createClient({ mode: "rtc", codec: "vp8" });
                        await client.join(APP_ID, channelName, token, null);

                        localAudioTrack = await AgoraRTC.createMicrophoneAudioTrack();
                        await client.publish(localAudioTrack);

                        client.on("user-published", async (user, mediaType) => {
                            if (mediaType === "audio") {
                                await client.subscribe(user, mediaType);
                                const remoteAudioTrack = user.audioTrack;
                                remoteAudioTrack.play();
                                stopRingtone();
                                console.log(`Playing remote audio from user ${user.uid}`);
                            }
                        });

                        client.on("user-unpublished", (user) => {
                            console.log(`User ${user.uid} left the call.`);
                        });
                    }
                    catch (error) {
                        console.error("Error starting the call:", error);
                    }
            }
                document.addEventListener("DOMContentLoaded", function() {
                    const moodArray = @json($total);
                    let containerCount = document.querySelectorAll(".conditions-container").length;
                    let BGcolorSet = ["#FFDFDF", "#F8DCFF", "#FFECDF"];
                    let textcolorSet = ["#FF3333", "#6E0089", "#FFC933"];

                    let container = document.querySelectorAll(".conditions-container");
                    container.forEach((box, index) => {
                        box.style.backgroundColor = `${BGcolorSet[index]}`;
                        box.style.color = `${textcolorSet[index]}`;
                        
                        let defaultCondition = Object.keys(patientDetails.answer)[0];
                        // console.log(patientDetails);
                        getCondition(defaultCondition);

                        let mood = moodArray[index];
                                const moodContainer = document.getElementById("mood-container");
                                moodContainer.innerHTML = "";

                                const moodImg = document.createElement("img");
                                const moodText = document.createElement("p");
                                if (mood === "mild") {
                                    moodImg.src = "/assets/happy.gif";
                                    moodImg.classList.add('mood-image');
                                    moodText.textContent = patientDetails.name + " is suffering " + mood + " " + defaultCondition + " this week.";
                                } else if (mood === "moderate") {
                                    moodImg.src = "/assets/mid.gif";
                                    moodImg.classList.add('mood-image');
                                    moodText.textContent = patientDetails.name + " is suffering " + mood + " " + defaultCondition + " this week.";
                                } else if (mood === "severe") {
                                    moodImg.src = "/assets/sad.gif";
                                    moodImg.classList.add('mood-image');
                                    moodText.textContent = patientDetails.name + " is suffering " + mood + " " + defaultCondition + " this week.";
                                }

                                if (moodImg.src) {
                                    moodContainer.appendChild(moodImg);
                                    moodContainer.appendChild(moodText);
                                }

                        box.addEventListener("click", function() {
                                chartCondition = box.textContent.trim();
                                getCondition(chartCondition);
                                
                                
                                let mood = moodArray[index];
                                const moodContainer = document.getElementById("mood-container");
                                moodContainer.innerHTML = "";

                                const moodImg = document.createElement("img");
                                const moodText = document.createElement("p");
                                if (mood === "mild") {
                                    moodImg.src = "/assets/happy.gif";
                                    moodImg.classList.add('mood-image');
                                    moodText.textContent = patientDetails.name + " is suffering " + mood + " " + chartCondition + " this week.";
                                } else if (mood === "moderate") {
                                    moodImg.src = "/assets/mid.gif";
                                    moodImg.classList.add('mood-image');
                                    moodText.textContent = patientDetails.name + " is suffering " + mood + " " + chartCondition + " this week.";
                                } else if (mood === "severe") {
                                    moodImg.src = "/assets/sad.gif";
                                    moodImg.classList.add('mood-image');
                                    moodText.textContent = patientDetails.name + " is suffering " + mood + " " + chartCondition + " this week.";

                                }

                                if (moodImg.src) {
                                    moodContainer.appendChild(moodImg);
                                    moodContainer.appendChild(moodText);
                                }
                        })  
                    });
                });


                function scrollToBottom(){
                    let container = document.getElementById('chat-content');
                    container.scrollTop = container.scrollHeight;
                }

                window.openChat = function openChat(){
                    document.getElementById('chat-div').style.display = 'block';
                    document.getElementById('chat-screen').style.display = 'block';
                    document.body.style.overflow = 'hidden';

                    // console.log(chatID);
                    const messagesRef = ref(database, `administrator/chats/${chatID}`);
                    onChildAdded(messagesRef, (snapshot) => {
                        const messageData = snapshot.val();
                        const messageKey = snapshot.key;

                        if(!messageData.seen){
                            const messageViewedState = ref(database, `administrator/chats/${chatID}/${messageKey}/seen`);
                            set(messageViewedState, true);   
                        }
                    })

                    scrollToBottom();
                }

                window.closeChat = function closeChat(){
                    document.getElementById('chat-div').style.display = 'none';
                    document.getElementById('chat-screen').style.display = 'none';
                    document.body.style.overflow = 'auto';
                }

                
                window.sendMessage = function sendMessage(){
                    var message = document.getElementById('chat-input').value;
                    var chatDiv = document.getElementById('chat-div');

                    if(message.trim() !== "") {
                        fetch('/sendmessage', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message: message,
                            chatId: '{{ $chatID }}', 
                            sender: "{{ $doctorData['docID'] }}", 
                        })
                    }).then(response => response.json()).then(data => {
                        document.getElementById('chat-input').value = '';
                    
                    });

                    }
                
                }
                document.getElementById('chat-input').addEventListener("keypress", function(event) {
                    if(event.key === "Enter"){
                        sendMessage();
                    }
                });

               window.openReportModal = function openReportModal(){
                    document.getElementById('report-screen').style.display = 'inline-flex';
               } 
               window.openNotesModal = function openNotesModal(){
                    document.getElementById('modal-screen').style.display = 'inline-flex';
               }

            </script>
            <script src="{{ asset('js/doctor/charts.js') }}"></script>

@endsection