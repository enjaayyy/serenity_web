@extends('index')

@section('title', 'patient-profile')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/doctor/patientProfile.css') }}">
{{-- 
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdn.agora.io/sdk/release/AgoraRTC_N.js"></script>

    <script type="module" src="{{ asset('js/test/agoraLogic.js') }}"></script>
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.13.1/firebase-app.js";
        import { getDatabase, ref, onChildAdded } from "https://www.gstatic.com/firebasejs/10.13.1/firebase-database.js";

        const firebaseConfig = {
            apiKey: "AIzaSyCYLZvbqn9jnEQwwGNLZtbahdFLIBxksSc",
            authDomain: "serenity-c800c.firebaseapp.com",
            databaseURL: "https://serenity-c800c-default-rtdb.firebaseio.com",
            projectId: "serenity-c800c",
            storageBucket: "serenity-c800c.appspot.com",
            messagingSenderId: "366141859028",
            appId: "1:366141859028:web:1ffb51a714407fea7f4741",
        };

        const app = initializeApp(firebaseConfig);
        const database = getDatabase(app);

        function listenForMessages() {
            const chatID = "{{ $chatID }}"; 
            const messagesRef = ref(database, `administrator/chats/${chatID}`);

            onChildAdded(messagesRef, (snapshot) => {
                const message = snapshot.val();
                
                const chatContent = document.getElementById('chat-content');
                const newMessageDiv = document.createElement('div');
                newMessageDiv.style.display = "flex";

                 const messageParagraph = document.createElement('p');
                    messageParagraph.textContent = message.message;
                    messageParagraph.style.backgroundColor = "red";

                if (message.senderId === "{{ $doctorData['docID'] }}") {
                    newMessageDiv.style.justifyContent = "flex-end"; 
                    messageParagraph.style.backgroundColor = "#20c073"; 
                } 
                else {
                    newMessageDiv.style.justifyContent = "flex-start"; 
                    messageParagraph.style.backgroundColor = "pink";
                }

               
                console.log("Message sender:", message.sender);

                newMessageDiv.appendChild(messageParagraph);

                // Append the new message div to the chat content
                chatContent.appendChild(newMessageDiv);


                chatContent.scrollTop = chatContent.scrollHeight;
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            listenForMessages();
        });
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
    
      function drawChart() {
        var chartData = JSON.parse(@json($data));
   
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Time');
            data.addColumn('number', 'Value');

            console.log('chartData:', chartData);
           
            chartData.forEach(function(row) {
                data.addRow([row.Time, row.Value]);
            });

          
            var options = {
                title: 'Overall State',
                curveType: 'none',
                legend: { position: 'bottom' },
                width: 700,
                height: 300,
                vAxis: {
                viewWindow: {
                min: 0 
                }
            }
        };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
            chart.draw(data, options);
      }

    

      function sendMessage(){
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
    </script> --}}
            <div class='container'>
                <div class="admin-header">
                    <p class="dash-text">Patient Profile</p>
                    <img src="{{asset('assets/logo-w-text.svg') }}" class="page-logo">
                </div>
                <div class="main-content">
                    <div class="user-info-container">
                        <div class="user-info">
                            <div class="profile-pic-container">
                                <img src="{{ asset('assets/avatar.png') }}" class="profile-img">
                                <p class="patient-name">{{ $patientDetails['name'] }}</p>
                                <p class="patient-email">{{ $patientDetails['email'] }}</p>
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
                            {{-- <div class="profile-group">
                                <div class="img-container">
                                    <img src="{{ asset('assets/avatar.png') }}" class="profile-img">
                                </div>
                                <div class="profile-group-cntn">
                                    <p class="u-cond-head">Condition:</p>
                                    <p class="u-cond">
                                       
                                    </p>
                                </div>
                                <div class="commu-btn">
                                    <button class="mess-btn" onclick="openChat()">
                                        <img src="{{ asset('assets/message.png') }}">
                                    </button>
                                    <button id="join">
                                        <img src="{{ asset('assets/call.png') }}">
                                    </button>
                                  
                                </div>
                            </div> --}}
                        </div>
                        
                    </div>
                    <div class="analytics-container">
                        <p class="analytics-header">Conditions</p>
                        <div class="conditions-group">
                            @if(isset($patientDetails['condition']) && is_array($patientDetails['condition']))
                                @foreach($patientDetails['condition'] as $condition)
                                    <div class="conditions-container">
                                        <p>{{ $condition }}</p>
                                    </div>
                                @endforeach 
                            @endif
                        </div>
                        <p class="analytics-header">Questionnaire Activity</p>
                        <div class="chart-container">
                            <div class="charts">
                                <div id="curve_chart"></div>
                            </div>
                        </div>
                        <p class="analytics-header">Questionnaire Breakdown</p>
                        <div class="chart-breakdown-container">
                            breakdance
                        </div>
                    </div>
                    <div class="additional-info-container">
                        <div class="answered-questions-container">
                            <p class="content-header">Questionnaires</p>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="call-chat-container">
                <div class="function-buttons">
                    <div class="mess-container">
                        <button onclick="openChat()">
                    </div>
                </div>
                <div class="chat-div" id="chat-div" style="display: none;">
                    <div class="chat-header">
                        <img src="{{ asset('assets/avatar.png') }}">
                        <p>{{ $patientDetails['name'] }}</p>
                        <button onclick="closeChat()">x</button>
                    </div>
                    {{-- <div class="chat-ctnt" id="chat-content">
                        <!-- @foreach($messages as $message)
                            @if($message['sender'] == $doctorData['docID'])
                            <div class="doctor-mess">
                                <p>{{ $message['message'] }}</p>
                            </div>
                            @elseif($message['sender'] == $patientDetails['patientID'])
                            <div class="patient-mess">
                                <p>{{ $message['message'] }}</p>
                            </div>
                            @endif
                        @endforeach -->
                    </div> --}}
                    <div class="chat-input">
                        <input type="text" id="chat-input">
                        <button onclick="sendMessage()">
                            <img src="{{ asset('assets/send.png') }}">
                        </button>
                    </div>
                </div>
            </div>
            
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    let containerCount = document.querySelectorAll(".conditions-container").length;

                    let BGcolorSet = ["#FFDFDF", "#F8DCFF", "#FFECDF"];
                    let textcolorSet = ["#FF3333", "#6E0089", "#FFC933"];

                    let container = document.querySelectorAll(".conditions-container");
                    container.forEach((box, index) => {
                        box.style.backgroundColor = `${BGcolorSet[index]}`;
                        box.style.color = `${textcolorSet[index]}`;
                    });
                });

                function openChat(){
                    document.getElementById('chat-div').style.display = 'block';
                }
                function closeChat(){
                    document.getElementById('chat-div').style.display = 'none';
                }
                
            </script>
@endsection