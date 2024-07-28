<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
</head>
    <body>
        <div class="static-header">
            <div>
             <img src="{{asset('assets/logo.png') }}" class="home-logo" height="50px">
            </div>
            <div class="function-btns">
        <button type="button" class="home-btn">Home</button>
        <button type="button" class="contact-btn">Contact</button>
        <button type="button" class="about-btn">About us</button>
        <button type="button" class="services-btn">Services</button>
        <img src= "{{asset('assets/loginlogo.png') }}" class="login-logo">
        <a href = "{{ route('login') }}" style = "text-decoration:none;">
        <button type="button" class="login-btn">Log in</button></a><br>
            </div>
        </div>
        <div class="homepage-container">
               <img src="{{asset('assets/cover-page.jpg') }}" class= "homepage-img">
                <div class="tagline-container">
                    <p class ="tagline">Stay Serene with Serenity</p>
                    <p class ="tag-descrip">Your pocket companion for your mental well being</p>
                    <div class="sign-container">
                        <a href="{{ route('register') }}" style="text-decoration: none;">
                    <button type="button" class="sign-up">
                        <img src="{{asset('assets/signuplogo.png') }}" class="signup-logo">    
                        <p class="sign-text">Sign up</p>
                        </button>
                        </a>
                    </div>
                
                </div>
               
                    
             
        </div>
        
      

</body>
    </html>
