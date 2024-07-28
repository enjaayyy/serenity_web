<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    <div>
        <a href ="{{ route('home') }}" style = "text-decoration: none;">
        <img src="{{asset('assets/logo.png') }}" class="register-logo">
</a>
</div>
<div class = "register-container">
    <div class = "register-body">
        <p class="header"> SIGN-UP </p>
        <form action="{{ url('register') }}" method="POST">
            @csrf
            <p class="name-header">Full Name</p>
            <input type = "text" class = "fname-input" placeholder="First Name, Middle Name, Last Name" name="fullname">
            <p class="email-header">Email</p>
            <input type = "text" class = "email-input" placeholder="Email" name="email">
            <p class="password-header">Password</p>
            <input type = "password" class = "pass-input" placeholder="Password"  name="password">
            <a href="{{ url('register-details') }}" style="text-decoration: none;">
             <button class="next-btn" type="submit">Next -></button>
            </a>
</form>

    <p class ="prompt">Already have an Account? <a href="{{ route('login') }}" style = "color: blue;">Click here! </a></p>
</div>
    <div class = "register-art">
        <img src="{{asset('assets/register-art.png') }}" class="register">
</div>
</div>

</body>
    </html>
