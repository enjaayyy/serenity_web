<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/doctor/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/doctor/dashboard.css') }}">
    </head>
    <body>
        <div class="container">
            @include('doctor/sidebar')
            <div class="empty"> </div>
            <div class="content">
                Next Update :>
            </div>
            
        </div>
    </body>
</html>