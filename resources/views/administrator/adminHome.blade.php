@extends('index')

@section('title', 'Admin Dashboard')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/administrator/admindash.css') }}">
    <div class = "container">
        <div class = "main-content">
            <div class="admin-header">
                <p class="dash-text">Dashboard</p>
                <img src="{{asset('assets/logo-w-text.svg') }}" class="page-logo">
            </div>
            <div class="summary-header-container">
                <div class="doctor-count-container">
                    <div class="content-wrapper">
                        <div class="count-container-1">
                            {{ $doctorCount }}
                        </div>
                            <p>No. of Doctors</p>
                    </div>    
                </div>
                <div class="patient-count-container">
                    <div class="content-wrapper">
                        <div class="count-container-2">
                            {{ $patientCount }}
                        </div>
                            <p>No. of Patients</p>
                    </div> 
                </div>
                <div class="report-count-container">
                    <div class="content-wrapper">
                        <div class="count-container-3">

                        </div>
                            <p>No. of Reports</p>
                    </div> 
                </div>
            </div>
            <div class="upload-header-container">
                <p class="upload-header">Materials</p>
                    <div class ="upload-btn-container">
                        <button class = "upld-btn" onclick="openwindow()">Upload<img src="{{ asset('assets/plus.png') }}"></button>
                    </div>
            </div>
            <div class="upload-container">
                <div class = "vid-list">
                    @if(isset($videos) && is_array($videos))
                        @foreach($videos as $data)
                            @if(isset($data['video']))
                                <div class="vids">
                                    <div class="vid-details">
                                        <video class="video-data" controls>
                                            <source src="{{ $data['video'] }}" type="video/mp4">
                                        </video>
                                            <p class="vid-title">{{ $data['title'] }}</p>
                                            <p class="vid-details">{{ $data['details'] }}</p>
                                    </div>
                                </div>           
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
                    <div class="upld-screen" id="card" style="display: block;">
                        <div class = "upld-card">
                            <div class="card-header">
                                <p>Upload Video</p>
                                <button class="close" id="close" onclick="closewindow()">x</button>
                            </div>
                            <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="upload-vid-container">
                                    <label for="upld-vid"  class="upld-vid-label">
                                        <div class="label-container">
                                            <img src="{{ asset('assets/upload-icon.svg') }}">
                                            <p id="file-name" >Choose a video to upload from your local</p>
                                        </div>
                                    </label>
                                    <input type="file" class="upld-vid" id="upld-vid" accept="video/*" name="video" style="display:none;">
                                </div>
                            <input type="text" class="vid-title" id="vid-title" placeholder="Enter Title" name="title">
                            <textarea class="vid-descrip" placeholder="Enter description here." name="details"></textarea><br>
                            <button type="submit" class="upload-btn">Upload Video</button>
                            </form>
                        </div>
                    </div>
    <script>
        function openwindow(){
            document.getElementById('card').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closewindow(){
            document.getElementById('card').style.display = 'none';
            document.body.style.overflow = 'auto';

        }
        document.getElementById('upld-vid').addEventListener('change', function(event) {
            let filename = event.target.files[0] ? event.target.files[0].name : "Choose a video to upload from your local";
            document.getElementById('vid-title').value = filename;
            })
    </script>
@endsection