@extends('index')

@section('title', 'doctor-profile')

@section('content')

        <link rel="stylesheet" href="{{ asset('css/doctor/profile.css') }}">
        <link rel="stylesheet" href="{{ asset('css/doctor/utilities/uploadcard.css') }}">
        {{-- 
        <link rel="stylesheet" href="{{ asset('css/doctor/utilities/profile-content.css') }}"> --}}
        <script src="{{ asset('js/doctor/profile.js') }}"></script>
        <div class="container">
            <div class="admin-header">
                <p class="dash-text">My Profile</p>
                <img src="{{asset('assets/logo-w-text.svg') }}" class="page-logo">
            </div>
            <div class="main-content">
                <div class="doctor-data">
                    <div class="profile-pic-container">
                        <div class="pic-container">
                            @if(empty($doctorData['pic']))
                                <button type="button" onclick="uploadcard()">
                                    <img src="{{ asset('assets/avatar.png') }}">
                                </button>
                                @else
                                <button type="button" onclick="uploadcard()">
                                    <img src="{{ $doctorData['pic'] }}">
                                </button>
                            @endif
                            <img class="plus-icon" src=" {{ asset('assets/plus-icon.svg') }}">
                            <img class="change-photo-icon" src=" {{ asset('assets/change-pp-icon.svg') }}">
                        </div>
                        <p class="doc-name">{{ $doctorData['name'] }}</p>
                        <p class="doc-prof">{{ $doctorData['prof'] }}</p>
                    </div>
                    <div class="following-data">
                        <div class="spec-container">
                            <div class="spec-header">
                                <p class="data-header">Specialization</p>
                                <img class="edit-icon" src=" {{ asset('assets/edit-icon.svg') }}">
                            </div>
                            <div class="spec-list-container">
                                @if(isset($doctorData['spec']) && is_array($doctorData['spec']))
                                    @foreach($doctorData['spec'] as $spec)
                                    <div class="rt-data">
                                        <p>{{$spec}}</p>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="age-yrs-gender-group">
                            <div>
                                <p class="data-header">Age</p>
                                <p class="actual-data">{{ $doctorData['age'] }}</p>
                            </div>
                            <div>
                                <p class="data-header">Years of Service</p>
                                <p class="actual-data">{{ $doctorData['yrs'] }}</p>
                            </div>
                            <div>
                                <p class="data-header">Gender</p>
                                <p class="actual-data">{{ $doctorData['gender'] }}</p>
                            </div>
                        </div>
                        <div class="license-group">
                            <p class="data-header">Medical License</p>
                            <p class="actual-data">{{ $doctorData['license'] }}</p>
                        </div>
                        <div class="address-group">
                            <p class="data-header">Work Address</p>
                            <p class="actual-data">{{ $doctorData['address'] }}</p>
                        </div>
                        <div class="email-group">
                            <p class="data-header">Email Address</p>
                            <p class="actual-data">{{ $doctorData['email'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="other-data">

                </div>
            </div>

        </div>
@endsection


 
            {{-- @include('doctor.utilities.profileuploadcard') --}}
                {{-- <div>
                    <p class="header">My Profile</p> 
                        <div class="header-container">
                            <div class="profile-pic-container">
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
                               
                                <div class="em-spec">
                                    <div class="spec-container">
                                        @if(isset($doctorData['specialization']) && is_array($doctorData['specialization']))
                                            @foreach($doctorData['specialization'] as $spec)
                                            <div>
                                                <p>{{$spec}}</p>
                                            </div>
                                            @endforeach
                                        @endif
                                    </div>
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
                                {{-- @include('doctor.utilities.questionnaire')
                                @include('doctor.utilities.aboutmecard')
                            </div>
                        </div>
                </div>
            </div> --}}