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
                        <form method="POST" action="{{ route('profileChanges', ['id' => $details['docID']])}}">
                            @csrf
                            @if(isset($changes))
                            <div class="changes-button">
                                <button type="button" id="viewChanges"  class="viewChanges"><p>View Pending Changes</p></button>
                                <button type="submit" id="acceptChanges" class="acceptChanges" name="action" value="accept" hidden>Accept Changes</button>
                                <button type="submit" id="declineChanges" class="declineChanges" name="action" value="decline" hidden>Decline Changes</button>
                            </div>
                        @endif
                            <div class="profile-data-header">
                                <div class="profile-pic-container">
                                    @if(isset($details['profile']))
                                        <img src="{{ $details['profile'] }}" class="profile-img">
                                    @else
                                        <img src="{{ asset('assets/avatar.png') }}" class="profile-img">
                                    @endif
                                </div>
                                <div class="profile-name-container">
                                    <p class="user-name">
                                        {{ $details['name'] }}
                                        @if(isset($changes['name']))
                                            <p class="change-name" id="change-name" hidden>{{$changes['name']}}</p>
                                            <input type="hidden" name="change-name" value="{{$changes['name']}} ">
                                        @endif
                                    </p>
                                    <p class="prof">{{ $details['prof'] }}</p>
                                        @if(isset($changes['profession']))
                                            <p class="change-profession" id="change-profession" hidden>{{$changes['profession']}}</p>
                                            <input type="hidden" name="change-profession" value="{{$changes['profession']}} ">
                                        @endif
                                    <div class="spec-container">
                                        @if(isset($details['spec']) && is_array($details['spec']))
                                            @foreach($details['spec'] as $spec)
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
                                        @if(isset($changes['age']))
                                            <p class="change-age" id="change-age" hidden>{{$changes['age']}}</p>
                                            <input type="hidden" name="change-age" value="{{$changes['age']}} ">
                                        @endif
                                    </div>
                                    <div class="yrs-of-service-box">
                                        <p class="category">Years of Service</p>
                                        <p class="ctnt">{{ $details['yrs']}}</p>
                                        @if(isset($changes['years']))
                                            <p class="change-years" id="change-years" hidden>{{$changes['years']}}</p>
                                            <input type="hidden" name="change-years" value="{{$changes['years']}} ">
                                        @endif
                                    </div>
                                    <div class="gender-box">
                                        <p class="category">Gender</p>
                                        <p class="ctnt">{{ $details['gender'] }}</p>
                                        @if(isset($changes['gender']))
                                            <p class="change-gender" id="change-gender" hidden>{{$changes['gender']}}</p>
                                            <input type="hidden" name="change-gender" value="{{$changes['gender']}} ">
                                        @endif
                                    </div>
                                </div>
                                <div class="details-box">
                                    <p class="category">Address</p>
                                    <p class="ctnt">{{ $details['address']}}</p>
                                    @if(isset($changes['address']))
                                        <p class="change-address" id="change-address" hidden>{{$changes['address']}}</p>
                                        <input type="hidden" name="change-address" value="{{$changes['address']}} ">
                                    @endif
                                </div>
                                <div class="details-box">
                                    <p class="category">Email</p>
                                    <p class="ctnt">{{ $details['email']}}</p>
                                </div>
                                <div class="medical-data-container">
                                    <div class="details-box">
                                        <p class="category">Medical License</p>
                                        <p class="ctnt">{{ $details['license'] }}</p>
                                        @if(isset($changes['license']))
                                            <p class="change-license" id="change-license" hidden>{{$changes['license']}}</p>
                                            <input type="hidden" name="change-license" value="{{$changes['license']}} ">
                                        @endif
                                    </div>
                                    <div class="details-box">
                                        <p class="category">Issued Date</p>
                                        <p class="ctnt">{{ $details['issued'] }}</p>
                                        @if(isset($changes['issued']))
                                            <p class="change-issued" id="change-issued" hidden>{{$changes['issued']}}</p>
                                            <input type="hidden" name="change-issued" value="{{$changes['issued']}} ">
                                        @endif
                                    </div>
                                    <div class="details-box">
                                        <p class="category">Expiry Date</p>
                                        <p class="ctnt">{{ $details['expired'] }}</p>
                                        @if(isset($changes['expire']))
                                            <p class="change-expire" id="change-expire" hidden>{{$changes['expire']}}</p>
                                            <input type="hidden" name="change-expire" value="{{$changes['expire']}} ">
                                        @endif
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="description-container">
                        <p class="description-header">Description<p>
                            <div class="description-details-container">
                                @if(isset($details['description']))
                                    <p>{{ $details['description']}}</p>
                                    @if(isset($changes['descrip']))
                                        <p class="change-descrip" id="change-descrip" hidden>{{$changes['descrip']}}</p>
                                        <input type="hidden" name="change-descrip" value="{{$changes['descrip']}} ">
                                    @endif
                                @else
                                    <div class="empty-container">
                                        <p class="no-data">No Data!</p>
                                        <br>
                                        @if(isset($changes['descrip']))
                                            <p class="change-descrip" id="change-descrip" hidden>{{$changes['descrip']}}</p>
                                            <input type="hidden" name="change-descrip" value="{{$changes['descrip']}} ">
                                        @endif
                                    </div>
                                @endif
                            </div>
                    </div>
                </form>

                    <div class="credential-container">
                        <p class="credential-header">Credentials<p>
                            <div class="file-container">    
                                @foreach($details['creds'] as $index => $creds)
                                    <div class="filetitle-wrapper clickable" id="filetitle-wrapper" data-index="{{ $index }}">
                                        <img src={{ asset('/assets/image.svg') }}>
                                        <p class="file-name">{{ $creds['filename']}}</p>
                                    </div>
                                    <div class="image-preview" data-index="{{ $index }}" id="image-preview" style="display:none;">
                                        <img src="{{ $creds['url'] }}">
                                    </div>
                                @endforeach
                            </div>
                    </div>
                </div>
                <div class="doctor-lists">
                    <div class="patient-list-container">
                        <div class="patient-header-container">
                            <p class="patient-header">Patients</p>
                            <p class="patient-count">{{ $patientCount }}</p>
                        </div>
                        <div class="patient-list">
                            @if(!empty($patient) && is_array($patient))
                                @foreach($patient as $index)
                                    <div class="patient-list-wrapper">
                                        @if(isset($index['img']))
                                            <img src="{{ $index['img'] }}" class="patient-profile-img">
                                        @else
                                            <img src="{{ asset('assets/avatar.png') }}" class="patient-profile-img">
                                        @endif
                                        <div class="patient-details-wrapper">
                                            <p class="patient-name">{{ $index['name'] }}</p>
                                                <div class="patient-condition-wrapper">
                                                    @foreach($index['conditions'] as $cond)
                                                        <p class="patient-condition">{{ $cond }}&nbsp;</p>
                                                    @endforeach
                                                </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="empty-container">
                                    <p class="no-data">No Data!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="deactivate-btn-container">
                    <form action="{{ route('deactivate', ['id' => $details['docID']]) }}" method="POST">
                        @csrf
                            <button class="d-btn" type="submit"><img src="{{ asset('assets/report-icon.svg') }}"><p>Deactivate<p></button>
                    </form>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const wrappers = document.querySelectorAll('.filetitle-wrapper');
                    wrappers.forEach(wrapper => {
                        wrapper.addEventListener('click', () => {
                            const index = wrapper.getAttribute('data-index');
                            const preview = document.querySelector(`.image-preview[data-index="${index}"]`);
                            if(preview.style.display === "none"){
                                preview.style.display = "flex"
                            }
                            else{
                                preview.style.display = "none";
                            }
                        })
                    })

                const viewChange = document.getElementById('viewChanges');
                viewChange.addEventListener('click', () => {
                    document.getElementById('change-name').hidden = false;
                    document.getElementById('change-profession').hidden = false;
                    document.getElementById('change-age').hidden = false;
                    document.getElementById('change-years').hidden = false;
                    document.getElementById('change-gender').hidden = false;
                    document.getElementById('change-address').hidden = false;
                    document.getElementById('change-license').hidden = false;
                    document.getElementById('change-expire').hidden = false;
                    document.getElementById('change-issued').hidden = false;
                    document.getElementById('change-descrip').hidden = false;

                    document.getElementById('viewChanges').hidden = true;
                    document.getElementById('acceptChanges').hidden = false;
                    document.getElementById('declineChanges').hidden = false;
                })
            })

        </script>
@endsection