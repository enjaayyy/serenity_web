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
                <div class="medical-box">
                    <p class="category">Medical License</p>
                    <p class="ctnt">{{ $details['license'] }}</p>
                </div>
                <div class="btn-container">
                    <form class="buttons" action = "{{ route('approve', ['id' => $details['id']]) }}" method="POST">
                        @csrf
                            <button class="approve" type="submit" name="approve">Approve</button>
                            
                    </form>
                    <form class="buttons" action = "{{ route('disapprove', ['id' => $details['id']]) }}" method="POST">
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
                <div class="verifiles">
                    <div class="image-display">
                        <img id="current-image" src="">
                    </div>
                    <div class="image-btns">
                        <button class="prev" onclick="prevImage()">Previous</button>
                        <button class="next" onclick="nextImage()">Next</button>
                    </div>
                   
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
    </div>
       
  @endsection
