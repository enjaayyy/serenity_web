@extends('index')

@section('title', 'admin_request_details')

@section('content')
<link rel="stylesheet" href="{{ asset('css/administrator/adminrequestdetails.css') }}">
    <div class="container">
        <div class="admin-header">
            <p class="dash-text">Doctor Profile</p>
            <img src="{{asset('assets/logo-w-text.svg') }}" class="page-logo">
        </div>
        <div class="main-content">
            <div class="profile-details">
                <div class="profile-pic-container">
                    <img src = "{{ asset('assets/avatar.png') }}" class="avatar1">
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
                <div class="address-box">
                    <p class="category">Address</p>
                    <p class="ctnt">{{ $details['address']}}</p>
                </div>
                <div class="email-box">
                    <p class="category">Email</p>
                    <p class="ctnt">{{ $details['email']}}</p>
                </div>
                <div class="medical-data-container">
                    <div class="medical-box">
                        <p class="category">Medical License</p>
                        <p class="ctnt">{{ $details['license'] }}</p>
                    </div>
                    <div class="issued-date-box">
                        <p class="category">Issued Date</p>
                        <p class="ctnt">{{ $details['issued'] }}</p>
                    </div>
                    <div class="expiry-date-box">
                        <p class="category">Expiry Date</p>
                        <p class="ctnt">{{ $details['expire'] }}</p>
                    </div>
                </div>
                
                <div class="btn-container">
                    <form class="approve-form" action = "{{ route('approve', ['id' => $details['id']]) }}" method="POST">
                        @csrf
                            <button class="approve" type="submit" name="approve">Approve</button>
                    </form>
                    <form class="del-veri-form" action = "{{ route('disapprove', ['id' => $details['id']]) }}" method="POST">
                        @csrf
                            <button class="delete">Delete</button>
                            <button class="verify" type="button" onclick = "openLink()">Verify</button>
                            <script>
                                function openLink() {
                                    const url = 'https://online.prc.gov.ph/Verification';
                                    window.open(url);
                                }
                            </script>
                    </form>
                </div>
            </div>
            <div class="profile-credentials">
                <div class="credential-header-container">
                    <p>Credentials</p>
                </div>
                <div class="file-container">    
                    @foreach($details['credentials'] as $index => $creds)
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
        })
    </script>
  @endsection
