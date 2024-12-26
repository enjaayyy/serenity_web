<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class = "login-container">
        <div class= "login-art-body">  
            <div class="background-overlay"></div>
            <a href ="{{ route('home') }}" style = "text-decoration: none;">
                <img src="{{asset('assets/logo-w-text.svg') }}" class="login-logo">
            </a>
            <p class="login-art-header">Access Your Serenity Account Here</p>
            <p class="login-art-subheader">Become part of a community dedicated to well-being.</p>
        </div>

        <div class = "login-body">
            <p class="header">LOGIN</p>
                <form action="{{ route('logins') }}" method="POST">
                        @csrf
                    <p class="email"> Email </p>
                    <input type="text" class = "email-input" name="email" placeholder="Enter Email Address" required>
                    <p class="password"> Password </p>
                    <input type="password" class = "password-input" name="pass" placeholder="Password" required><br><br>
                    <button class = "login-btn"> Login </button>
                </form>
                <br>
                <p class = "prompt">Dont have an account? <a href = "{{ route('register') }}" style= "color: blue;" >Click here!</a.</p>
        </div>
    </div>
</body>
</html