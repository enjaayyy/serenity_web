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
                        @include('doctor.utilities.aboutmecard')
                    </div>
                </div>
                <div class="tabs">
                    <div class="qst-tab">
                        <button type="button" onclick="getQuestionnaires()">
                            <p>Questionnaires</p>
                            <img src=" {{ asset('assets/question-tab-icon.svg') }}">
                        </button>
                    </div>
                    <div class="view-qst-tab" style="display:none;" id="view-qst-tab" onclick="getViewQuestionnaires()">
                        <button type="button">
                            <p>View&nbsp;Questionnaires</p>
                            <img src=" {{ asset('assets/view-icon.svg') }}">
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
                        <button type="button" onclick="openAboutMe()">
                            <p>About&nbsp;me</p>
                            <img src=" {{ asset('assets/account-icon.svg') }}">
                        </button>
                    </div>
                    
                </div>
            </div>

        </div>
        <script src="{{ asset('js/doctor/profile.js') }}"></script>
@endsection
