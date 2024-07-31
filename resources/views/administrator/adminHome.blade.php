<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="{{ asset('css/admindash.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    @stack('styles')
    <head>
</head>
<body>
    <div class = "container">
        @include('administrator.adminSidebar')
            <div class = "content">
                <div class="admin-header">
                    <img src = "{{ asset('assets/admin-dash.png') }}" class="dashboard">  
                    <p class="dash-text">
                        Dashboard
                    </p>
                    </div>

                    <div class = "upload container">
                        <p class="upld-txt">Upload Videos</p>
                    </div>
            </div>
        </div>
</body>
    </html>