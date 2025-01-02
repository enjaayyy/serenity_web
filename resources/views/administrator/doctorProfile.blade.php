@extends('index')

@section('title', 'admin_doctor_profile')

@section('content')
        <link rel="stylesheet" href="{{ asset('css/administrator/profile.css') }}">
        <div class="container">
            <div class="admin-header">
                <p class="dash-text">Doctor Profile</p>
                <img src="{{asset('assets/logo-w-text.svg') }}" class="page-logo">
            </div>
            <div class="main-content">
                <div class="doctor-data">
                    <div class="profile-data-header">
                        <div class="profile-pic-container">
                            @if(isset($details['profile']))
                                <img src="{{ $details['profile'] }}">
                            @else
                                <img src="{{ asset('assets/avatar.png') }}" class="profile-img">
                        @endif
                        </div>
                        <div class="profile-name-container">
                            <p class="user-name">{{ $details['name'] }}</p>
                            <p class="prof">{{ $details['profession'] }}</p>
                            <div class="spec-container">
                                @if(isset($details['specialization']) && is_array($details['specialization']))
                                    @foreach($details['specialization'] as $spec)
                                    <div>
                                        <p>{{$spec}}</p>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="doctor-lists">
                    <div class="patient-list">
                        <p class="patient-header">Patients</p>
                        @if(!empty($patient) && is_array($patient))
                            @foreach($patient as $index)
                            <form method="GET" action="{{ route('viewPatientDetails', $index['userID']) }}">
                                @csrf
                                <button class="patient-list" type="submit">
                                    <p class="patient-name">{{ $index['name'] }}</p>
                                </button>
                            </form>  
                            @endforeach
                        @else
                            <p>No Data!</p>
                        @endif
                    </div>
                </div>
            </div>
            {{-- <div class="list">
                
            </div>
            <div class="header-container">
                <p class="header">Profile</p>
                <form action="{{ route('deactivate', ['id' => $details['id']]) }}" method="POST">
                    @csrf
                    <button class="d-btn" type="submit">Deactivate</button>
                </form>
            </div>
        
            <div class="profile-info">
                <div class="info">
                    <div class="pp-pc">
                        @if(isset($details['profile']))
                            <img src="{{ $details['profile'] }}">
                        @else
                            <img src="{{ asset('assets/avatar.png') }}" class="profile-img">
                        @endif
                        <p class="user-name">{{ $details['name'] }}</p>
                        <p class="prof">{{ $details['profession'] }}</p>
                    </div>
                        
                </div>     
                <div class="info2">
                    <div class="header1">
                        <p class="spec-head">Specialization</p>
                        <p class="sex-head">Sex</p>
                        <p class="age-head">Age</p>
                    </div>
                    <div class="data1">
                        <p class="spec-ctnt">
                            @if(isset( $details['specialization']) && is_array( $details['specialization']))
                                        @foreach( $details['specialization'] as $spec)
                                            <p>{{$spec}}</p>
                                        @endforeach
                                    @endif
                        </p>
                        <p class="sex-ctnt">{{ $details['gender'] }}</p>
                        <p class="age-ctnt">{{ $details['age'] }}</p>
                    </div>
                    <div class="header2">
                        <p class="add-head">Work Address</p>
                        <p class="med-head">Medical License</p>
                    </div>
                    <div class="data2">
                        <p class="add-ctnt">{{ $details['address'] }}</p>
                        <p class="med-ctnt">{{ $details['license'] }}</p>
                    </div>
                </div>  
            </div>
                <div class="verifiles">
                    <p class="verifile-header">Credentials</p>
                    <div class="files">
                        @if(isset($details['credentials']) && is_array($details['credentials']))
                            @foreach($details['credentials'] as $images)
                            <div class="item">
                                <img src="{{ $images }}">
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                 --}}
        </div>
@endsection