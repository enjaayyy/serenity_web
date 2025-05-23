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
                        <div class="icon-container-1">
                            <img src ="{{ asset('assets/doctor-icon.svg') }}" class="doctor-count-icon">
                        </div>
                        <div class="count-container">
                            <p class="counter-label">Doctors</p>
                            <P class="counter-data">{{ $doctorCount }}</p>
                        </div>
                    </div>    
                </div>
                <div class="patient-count-container">
                    <div class="content-wrapper">
                        <div class="icon-container-2">
                            <img src ="{{ asset('assets/patient-icon.svg') }}" class="patient-count-icon">
                        </div>
                        <div class="count-container">
                            <p class="counter-label">Patients</p>
                            <p class="counter-data">{{ $patientCount }}</p>
                        </div>
                    </div> 
                </div>
                <div class="request-count-container">
                    <div class="content-wrapper">
                        <div class="icon-container-4">
                            <img src ="{{ asset('assets/requests-icon.svg') }}" class="request-count-icon">
                        </div>
                        <div class="count-container">
                            <p class="counter-label">Requests</p>
                            <p class="counter-data">{{ $requestsCount }}</p>
                        </div>
                    </div> 
                </div>
                <div class="report-count-container">
                    <div class="content-wrapper">
                        <div class="icon-container-3">
                            <img src ="{{ asset('assets/report-icon.svg') }}" class="report-count-icon">
                        </div>
                        <div class="count-container">
                            <p class="counter-label">Reports</p>
                            <p class="counter-data">{{ $reportsCount }}</p>
                        </div>
                    </div> 
                </div>
                <div class="archive-count-container">
                    <div class="content-wrapper">
                        <div class="icon-container-5">
                            <img src ="{{ asset('assets/archive-icon.svg') }}" class="archive-count-icon">
                        </div>
                        <div class="count-container">
                            <p class="counter-label">Archived</p>
                            <p class="counter-data">{{ $archiveCount }}</p>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="dash-tabs">
                <div class="dash-tab dash-tabs-home active">
                    <button onclick="openHomeWindow()" style="background-color: transparent; border: none;">
                        <p>Home</p>
                    </button>
                </div>
                <div class="dash-tab dash-tabs-videos">
                    <button onclick="openVideoWindow()" style="background-color: transparent; border: none;">
                        <p>Videos</p>
                    </button>
                </div>
            </div>
            <div class="display-videos-container" id="display-videos-container" style="display:none;">
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
                                                <div class="video-tags-container">
                                                    @if($data['tags'])
                                                        @foreach($data['tags'] as $tags)
                                                            <p>{{ $tags }}</p>
                                                        @endforeach
                                                    @else  
                                                        <p>No tags</p>
                                                    @endif   
                                                </div>
                                                <p class="vid-details">{{ $data['details'] }}</p>
                                        </div>
                                    </div>           
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
                {{-- <script>
                    let sample = @json($videos);
                    console.log(sample);
                </script> --}}
            </div>
        </div>
    </div>
                    <div class="upld-screen" id="card" style="display: none;">
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
                            <div class="title-container">
                                <p class="title-label">Enter Title</p>
                                <input type="text" class="vid-title-input" id="vid-title" placeholder="Enter Title" name="title">
                            </div>
                            <div class="tags-header-container">
                                <p>Tags</p>
                            </div>
                            <div class="tags-container">
                                <input type="checkbox" class="tags" name="tags[]" value="Anxiety" id="Anxiety" hidden>
                                <label for="Anxiety" class="tags-label">
                                    <div class="choice">Anxiety</div>
                                </label><input type="checkbox" class="tags" name="tags[]" value="PTS" id="PTS" hidden>
                                <label for="PTS" class="tags-label">
                                    <div class="choice">Post Traumatic Stress</div>
                                </label><input type="checkbox" class="tags" name="tags[]" value="Insomnia" id="Insomnia" hidden>
                                <label for="Insomnia" class="tags-label">
                                    <div class="choice">Insomnia</div>
                                </label>
                            </div>
                            <div class="description-container">
                                <p class="description-label">Additional Details</p>
                                <textarea class="vid-descrip" placeholder="Enter description here." name="details"></textarea><br>
                            </div>
                            <button type="submit" class="upload-btn">Upload Video</button>
                            </form>
                        </div>
                    </div>
    <script>

        document.querySelectorAll('.dash-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.dash-tab').forEach(key => key.classList.remove('active'));
                tab.classList.add('active');
            });
        });

        function openVideoWindow(){
            document.getElementById('display-videos-container').style.display = 'block';
        }
        function openHomeWindow(){
            document.getElementById('display-videos-container').style.display = 'none';
        }
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