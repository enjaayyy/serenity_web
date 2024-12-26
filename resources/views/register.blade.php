<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    <div class = "register-container" id="register-container">
        <div class = "register-body">
            <a href ="{{ route('home') }}" style = "text-decoration: none;">
            <img src="{{asset('assets/logo-w-text.svg') }}" class="register-logo">
            </a>
                <div class="register-form">
                    <p class="header"> Lets get started! </p>
                    <p class="sub-header"> Fill out the form below to create your account. </p>
                    <form action="{{ url('register') }}" method="POST" id="registration-form">
                        @csrf
                            <p class="name-header">Full Name</p>
                            <input type = "text" class = "fname-input" placeholder="First Name, Middle Name, Last Name" autocomplete="off" name="fullname" required>
                            <p class="email-header">Email Address</p>
                            <input type = "text" class = "email-input" placeholder="Enter Email"  autocomplete="off" name="email" required>
                            <p class="password-header">Password</p>
                            <input type = "password" class = "pass-input" placeholder="Enter Password"  autocomplete="off" id="password" name="password" required>
                            <p class="password-confirmation-header">Confirm Password</p> 
                            <input type = "password" class = "confirm-pass-input" placeholder="Confirm Password"  id="confirmpassword" name="confirm-password" required>
                            <p class="confirm-pass-error" id="confirmation-error">*Passwords do not match!</p>
                            <p class="confirm-pass-success" id="confirmation-pass">Password creation success!</p>
                            <a href="{{ url('register-details') }}" style="text-decoration: none;"><br>
                                <button class="next-btn" type="submit">Next -></button>
                            </a>
                    </form>
                    <p class ="prompt">Already have an Account? <a href="{{ route('login') }}" style = "color: blue;" onclick="hideRegister()">Click here! </a></p>
                </div>
        </div>
            <div class = "register-art">
                <div class="background-overlay"></div>
                <p class="art-header">Welcome</p>
                <p class="art-text">Join Serenity and be a part of the solution that the world needs!</p>
            </div>
    </div>
    <div class="login-container">
        @yield('content')
    </div>
    <script>
        document.getElementById('registration-form').addEventListener('submit', function (event) {
            const password = document.getElementById('password').value;
            const confirmPass = document.getElementById('confirmpassword').value;

            if(password !== confirmPass){
                event.preventDefault();
                document.getElementById('confirmation-error').style.display = 'block';
            }
            else{
                document.getElementById('confirmation-pass').style.display = 'block';
            }
        })

    </script>
</body>
</html>

