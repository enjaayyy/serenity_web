@extends('index')

@section('title', 'doctor-profile')

@section('content')

        <link rel="stylesheet" href="{{ asset('css/doctor/profile.css') }}">
        <link rel="stylesheet" href="{{ asset('css/doctor/utilities/uploadcard.css') }}">
        <link rel="stylesheet" href="{{ asset('css/doctor/utilities/credential.css') }}">
        <div class="container">
            <div class="admin-header">
                <p class="dash-text">My Profile</p>
                <img src="{{asset('assets/logo-w-text.svg') }}" class="page-logo">
            </div>
            <div class="main-content">
                <div class="doctor-data">
                    <div class="doctor-data-2">
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
                    <div class="doctor-data-3">
                        awdawda
                    </div>
                </div>
                <div class="other-data">
                    <div class="od-content">
                        <div class="get-started-container" id="get-started-container">
                        <p class="get-started-header">Get Started</p>
                        <p class="get-started-sub-header">Select a ribbon to view >></p>
                        </div>
                        <p class="status" name="status" id="status" hidden></p>
                        @include('doctor.utilities.questionnaire')
                        @include('doctor.utilities.credentials')
                    </div>
                   
                </div>
                <div class="tabs">
                    <div class="qst-tab">
                        <button type="button" onclick="getQuestionnaires()">
                            <p>Questionnaires</p>
                            <img src=" {{ asset('assets/question-tab-icon.svg') }}">
                        </button>
                    </div>
                    <div class="add-qst-tab" style="display:none;" id="add-qst-tab" onclick="AddDataSet()">
                        <button type="button">
                            <p>Add&nbsp;Questionnaire</p>
                            <img src=" {{ asset('assets/add-icon.svg') }}">
                        </button>
                    </div>
                    <div class="edit-qst-tab" style="display:none;" id="edit-qst-tab" onclick=" editQuestionnaire()">
                        <button type="button">
                            <p>Edit&nbsp;Questionnaire</p>
                            <img src=" {{ asset('assets/edit-qst-icon.svg') }}">
                        </button>
                    </div>
                    <div class="credenials-tab" id="creds-tab" onclick="getCredentials()">
                        <button type="button">
                            <p>Credentials</p>
                            <img src=" {{ asset('assets/credential-tab-icon.svg') }}">
                        </button>
                    </div>
                    <div class="about-me-tab" id="abt-me-tab">
                        <button type="button">
                            <p>About&nbsp;me</p>
                            <img src=" {{ asset('assets/account-icon.svg') }}">
                        </button>
                    </div>
                    
                </div>
            </div>

        </div>
        <script src="{{ asset('js/doctor/profile.js') }}"></script>
@endsection
