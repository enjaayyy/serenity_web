<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/register-details.css') }}">
</head>
<body>
<div>
        <a href ="{{ route('home') }}" style = "text-decoration: none;">
        <img src="{{asset('assets/logo.png') }}" class="register-logo">
</a>
</div>
<div class="details-container">
    <div class="details-body">
        <form action="{{ url('register-details') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class = "body-left">
            <p class="prof-header">Profession</p>
            <input type="text" name="profession">
            <div class="header-group">
                <p class="prof-ys">Years of Service</p>
                <p class="gender">Gender</p>
                 <p class="age">Age</p>
</div>
            
            <input type="text" class = "yrs-input" name="service">
            <select class = "gender-input" name="gender">
                <option> </option>
                <option>Male</option>
                <option>Female</option>
</select>
           
            <input type="text" class = "age-input" name="age">
            <p class="license">Medical License No.</p>
            <input type="text" name="license">
</div>
<div class = "body-right">
            <p class="address">Work Address/Company</p>
            <input type="text" name="address">
            <p class="spec">Specialization</p>
            <select name="spec">
                <option> </option>
                <option>Anxiety</option>
                <option>Insomnia</option>
                <option>Post Traumatic Stress Disorder</option>
</select>
<p class="file-attach">Attach a file for verification. this includes: selfie with Government ID, Degree, Medical License</p>
<input type="file" class="upload-btn" name="verifile[]" multiple>
</div>
<button type="submit" class="signup-btn">Sign up</button>
</form>
</div>
<div class="register-art">
    <img src="{{ asset('assets/footer-img.png') }}" class="register-art">
</div>
</div>
</body>
    </html>