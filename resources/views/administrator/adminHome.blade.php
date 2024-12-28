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
                    <div class = "upload container">
                        <p class="upld-txt">Upload Videos</p>
                        <div class = "vid-list">
                            <div class ="vids">
                                <button class = "upld-btn" onclick="openwindow()"><img src="{{ asset('assets/plus.png') }}"></button>
                            </div>
                            @if(isset($videos) && is_array($videos))
                                @foreach($videos as $data)
                                    @if(isset($data['video']))
                                        <div class="vids">
                                            <div class="vid-details">
                                                <video width="200" height="200" controls>
                                                <source src="{{ $data['video'] }}" type="video/mp4">
                                                </video>
                                                <p>{{ $data['title'] }}</p>
                                            </div>
                                        </div>           
                                    @endif
                                @endforeach
                            @endif
                            @if(isset($videos) && is_array($videos))
                                @foreach($videos as $data)
                                    @if(isset($data['video']))
                                        <div class="vids">
                                            <div class="vid-details">
                                                <video width="200" height="200" controls>
                                                <source src="{{ $data['video'] }}" type="video/mp4">
                                                </video>
                                                <p>{{ $data['title'] }}</p>
                                            </div>
                                        </div>           
                                    @endif
                                @endforeach
                            @endif
                        </div>  
                    </div>

                    <div class="upld-screen" id="card">
                        <div class = "upld-card">
                            <div class="card-header">
                                <p>Upload Video</p>
                                <button class="close" id="close" onclick="closewindow()">x</button>
                            </div>
                            <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                            <input type="file" class="upld-vid" accept="video/*" name="video">
                            <input type="text" class="vid-title" placeholder="Enter Title" name="title">
                            <textarea class="vid-descrip" placeholder="Enter description here." name="details"></textarea><br>
                            <button type="submit" class="upload-btn">Upload Video</button>
                            </form>
                        </div>
                    </div>
            </div>
    </div>
    <script>
        function openwindow(){
            document.getElementById('card').style.display = 'block';
        }

        function closewindow(){
            document.getElementById('card').style.display = 'none';
        }
    </script>
@endsection