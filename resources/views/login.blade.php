<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class = "logo-container">
    <a href ="{{ route('home') }}" style = "text-decoration: none;">
    <img src="{{asset('assets/logo.png') }}" class="login-logo">
</a>
</div>
<div class = "login-container">
    <div class= "login-art-body">  
        <img src="{{asset('assets/login-art.png') }}" class="login-art">
    </div>
    <div class = "login-body">
        <p class="header">LOGIN</p>
        <form action="{{ route('logins') }}" method="POST">
            @csrf
        <p class="email"> Email </p>
        <input type="text" class = "email-input" name="email">
        <p class="password"> Password </p>
        <input type="password" class = "password-input" name="pass"><br><br>
        <button class = "login-btn"> Login </button>
</form>
<br>
<p class = "prompt">Dont have an account? <a href = "{{ route('register') }}" style= "color: blue;" >Click here!</a.</p>
    </div>
</div>
</body>
</html