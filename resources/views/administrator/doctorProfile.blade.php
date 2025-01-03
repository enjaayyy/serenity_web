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
                <div class="doctor-details">
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
                        <div class="more-details-container">
                            <div class="age-yrs-gender-box">
                                <div class="age-box">
                                    <p class="category">Age</p>
                                    <p class="ctnt">{{ $details['age'] }}</p>
                                </div>
                                <div class="yrs-of-service-box">
                                    <p class="category">Years of Service</p>
                                    <p class="ctnt">{{ $details['years']}}</p>
                                </div>
                                <div class="gender-box">
                                    <p class="category">Gender</p>
                                    <p class="ctnt">{{ $details['gender'] }}</p>
                                </div>
                            </div>
                            <div class="details-box">
                                <p class="category">Address</p>
                                <p class="ctnt">{{ $details['address']}}</p>
                            </div>
                            <div class="details-box">
                                <p class="category">Email</p>
                                <p class="ctnt">{{ $details['email']}}</p>
                            </div>
                            <div class="details-box">
                                <p class="category">Medical License</p>
                                <p class="ctnt">{{ $details['license'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="credential-container">
                        <p class="credential-header">Credentials<p>
                            <div class="picture-container">
                                <button class="prev" onclick="prevImage()"><img src="{{ asset('assets/arrow-left.svg') }}"></button>
                                <div class="image-display">
                                    <img id="current-image" src="">
                                </div>
                                <button class="next" onclick="nextImage()"><img src="{{ asset('assets/arrow-right.svg') }}"></button>
                            </div>
                            <script>
                                const images = @json($details['credentials'] ?? awdawd);
                                let currentIndex = 0;

                                console.log(images);

                                function displayImage(index){
                                    const imageElement = document.getElementById('current-image');
                                    if(images.length > 0){
                                        imageElement.src = images[index];
                                    } else {
                                        imageElement.alt = "No Credentials Available";
                                    }
                                }
                                document.addEventListener('DOMContentLoaded', () => {
                                    displayImage(currentIndex);
                                })

                                function prevImage() {
                                    if (images.length > 0){
                                        currentIndex = (currentIndex - 1 + images.length) % images.length;
                                        displayImage(currentIndex);
                                    }
                                }

                                function nextImage() {
                                    if (images.length > 0){
                                        currentIndex = (currentIndex + 1) % images.length;
                                        displayImage(currentIndex);
                                    }
                                }
                                
                            </script>
                    </div>
                </div>
                <div class="doctor-lists">
                    <div class="patient-list-container">
                        <div class="patient-header-container">
                            <p class="patient-header">Patients</p>
                            <p class="patient-count">(no. of patients)</p>
                        </div>
                        <div class="search-container">
                            <div class="input-container">
                                <img src="{{asset('assets/search-icon.svg') }}">
                                <input type="text" placeholder="Search Patient" class="search-input"></input>
                                <img src="{{asset('assets/filter-icon.svg') }}">
                            </div>
                        </div>
                        <script src="{{ asset('js/utilities/search.js') }}"></script>
                        <div class="patient-list">
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
                <div class="deactivate-btn-container">
                    <form action="{{ route('deactivate', ['id' => $details['id']]) }}" method="POST">
                        @csrf
                            <button class="d-btn" type="submit"><img src="{{ asset('assets/report-icon.svg') }}"><p>Deactivate<p></button>
                    </form>
                </div>
            </div>
            {{-- <div class="list">
                
            </div>
            <div class="header-container">
                <p class="header">Profile</p>
                
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