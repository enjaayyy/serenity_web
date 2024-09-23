<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/doctor/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/doctor/profile.css') }}">
        <link rel="stylesheet" href="{{ asset('css/doctor/utilities/uploadcard.css') }}">
        <link rel="stylesheet" href="{{ asset('css/doctor/utilities/profile-content.css') }}">
        <script src="{{ asset('js/doctor/profile.js') }}"></script>
    </head>
    <body>
        <div class="page-container">
            @include('doctor.sidebar')
            @include('doctor.utilities.profileuploadcard')
            <div class="empty"></div>
                <div class="content">
                    <p class="header">My Profile</p> 
                        <div class="header-container">
                            <div class="profile-pic">
                                @if(empty($doctorData['pic']))
                                <button class="pp-btn1" onclick="uploadcard()">
                                    <img src="{{ asset('assets/defaultpp.png') }}">
                                </button>
                                @else
                                <button class="pp-btn" onclick="uploadcard()">
                                    <img src="{{ $doctorData['pic'] }}" style="max-width: 250px; max-height: 250px;">
                                </button>
                                @endif
                            </div>
                            <div class="more-info">
                                <p class="name">{{ $doctorData['name'] }}</p>
                                <p class="prof">{{ $doctorData['prof'] }}</p>
                                <div class="em-spec">
                                    <p class="spec">Specialization: {{ $doctorData['prof'] }}</p>
                                    <p class="em">Email: {{ $doctorData['email'] }}</p>
                                </div>
                                <div class="age-gen-yrs-lic">
                                    <p class="age">Age: {{ $doctorData['age'] }}</p>
                                    <p class="gen">Gender: {{ $doctorData['gender'] }}</p>
                                    <p class="yrs">Years of Service: {{ $doctorData['yrs'] }}</p>
                                    <p class="lic">License No.: {{ $doctorData['license'] }}</p>
                                </div>
                                <div class='btns'>
                                    <button class="about" onclick="openaboutme()">
                                        About me
                                    </button>
                                    <button class="creds" onclick="opencredentials()">
                                        Credentials
                                    </button>
                                     <button class="quest" onclick="openquestions()">
                                        Questions
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="ctnt-body">
                            <div class="more-deats">
                                <p class="works">Works at</p>
                                <P class="address">{{ $doctorData['address'] }}</p>
                                <p class="grad">Graduates at</p>
                                    @if(isset($doctorData['graduated']))
                                        <div class="grad-container">
                                            <p id="grad-text">{{ $doctorData['graduated'] }}</p>
                                            <button onclick="addGraduateSecond()" id="grad-btn2">
                                            <img src="{{ asset('assets/edit.png') }}">
                                            </button>
                                        </div>           
                                    @else
                                        <button onclick="addGraduate()" id="grad-btn">
                                            <img src="{{ asset('assets/adddetail.png') }}">
                                        </button>
                                    @endif
                                <p class="res">Research</p>
                                <button>
                                    <img src="{{ asset('assets/adddetail.png') }}">
                                </button>
                            </div>
                            <div class="abt-cred-ctnt">
                                @include('doctor.utilities.credentials')
                                @include('doctor.utilities.questionnaire')
                                @include('doctor.utilities.aboutmecard')
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </body>
</html>