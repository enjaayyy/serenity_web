@extends('index')

@section('title', 'admin_request_details')

@section('content')
        <link rel="stylesheet" href="{{ asset('css/administrator/adminrequestdetails.css') }}">
        <div class="container">
            <div class="admin-header">
                <p class="dash-text">Doctor Profile</p>
                <img src="{{asset('assets/logo-w-text.svg') }}" class="page-logo">
            </div>
            <div class="main-info"> 
                <div class="request-main-data">
                    <div class="info1">      
                        <img src = "{{ asset('assets/avatar.png') }}" class="avatar1">
                        <p class="user-name">{{ $details['name'] }}</p>
                        <p class="prof">{{ $details['profession'] }}</p>
                    </div>
                    <div class="more-header-details">
                        <div class="info2">
                            <div class="custom-box">
                                <p class="category">Gender</p>
                                <p class="gender-ctnt">{{ $details['gender'] }}</p>
                            </div>
                            <div class="custom1-box">
                                <p class="category">Age</p>
                                <p class="age-ctnt">{{ $details['age'] }}</p>
                            </div>
                            <div class="custom2-box">
                                <p class="category">Years of Service</p>
                                <p>{{ $details['years']}}</p>
                            </div>
                            <div class="custom2-box">
                                <p class="category">Medical License</p>
                                <p class="med-ctnt">{{ $details['license'] }}</p>
                            </div>
                            <div class="custom2-box">
                                <p class="category">Work Address</p>
                                <p class="add-ctnt">{{ $details['address'] }}</p>
                            </div>
                            <div class="custom2-box">
                                <p class="category">Email</p>
                                <p>{{ $details['email']}}</p>
                            </div>
                        </div>
                        <div class="content1">
                             <div>
                                <p class="category">Specialization: </p>
                                    <div class="bottom-box">
                                        <div class="spec-box">
                                            @if(isset($details['specialization']) && is_array($details['specialization']))
                                                @foreach($details['specialization'] as $spec)
                                                    <p>{{$spec}}&nbsp;&nbsp;</p>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="buttons">
                                            <form action = "{{ route('approve', ['id' => $details['id']]) }}" method="POST">
                                                @csrf
                                                   <button class="approve" type="submit" name="approve">Approve</button>
                                            </form>
                                            {{-- <button class="delete">Delete</button> --}}
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="verifiles">
                <p class="sub-header">Credentials</p>
                <div class="files">
                    @if(isset($details['credentials']) && is_array($details['credentials']))
                        @foreach($details['credentials'] as $images)
                     <div class="file-item">
                         <img src="{{ $images }}">
                      </div>
                        @endforeach
                    @else
                      <p>No credentials available.</p>
                  @endif
                </div>
            </div>
            <button class="verify" onclick = "openLink()">Verify</button>
        </div>
            

            <script>
                function openLink() {
                    const url = 'https://online.prc.gov.ph/Verification';
                    window.open(url);
                }
            </script>
  @endsection