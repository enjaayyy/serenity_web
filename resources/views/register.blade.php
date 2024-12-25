<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    <div class = "register-container">
        <div class = "register-body">
            <a href ="{{ route('home') }}" style = "text-decoration: none;">
            <img src="{{asset('assets/logo-w-text.svg') }}" class="register-logo">
            </a>
                <div class="register-form">
                    <p class="header"> SIGN-UP </p>
                    <form action="{{ url('register') }}" method="POST">
                        @csrf
                            <p class="name-header">Full Name</p>
                            <input type = "text" class = "fname-input" placeholder="First Name, Middle Name, Last Name" autocomplete="off" name="fullname" required>
                            <p class="email-header">Email Address</p>
                            <input type = "text" class = "email-input" placeholder="Email"  autocomplete="off" name="email" required>
                            <p class="password-header">Password</p>
                            <input type = "password" class = "pass-input" placeholder="Password"  name="password" required>
                            <a href="{{ url('register-details') }}" style="text-decoration: none;"><br>
                                <button class="next-btn" type="submit">Next -></button>
                            </a>
                    </form>
                    <p class ="prompt">Already have an Account? <a href="{{ route('login') }}" style = "color: blue;">Click here! </a></p>
                </div>
        </div>
            <div class = "register-art">
                <p class="art-header">Welcome</p>
                <p class="art-text">Join Serenity and be a part of the solution that the world needs!</p>
            </div>
    </div>
</body>
</html>
