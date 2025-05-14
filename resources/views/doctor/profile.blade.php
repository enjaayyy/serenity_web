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
                    @include('doctor.utilities.credentials')
                </div>
                <div class="other-data" id="other-data">
                    <div class="od-content" id="od-content">
                        @include('doctor.utilities.aboutmecard')
                    </div>
                    <div class="credentials-preview-container" id="credentials-preview-container">
                    </div>
                </div>
            </div>

        </div>
        <script src="{{ asset('js/doctor/profile.js') }}"></script>
@endsection
