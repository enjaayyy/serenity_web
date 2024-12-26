<!DOCTYPE html>
<html>
<head>
        <link rel="stylesheet" href="{{ asset('css/register-details.css') }}">
</head>
<body>
<div class="details-container">
    <a href ="{{ route('home') }}" style = "text-decoration: none;">
        <img src="{{asset('assets/logo-w-text.svg') }}" class="register-logo">
    </a>
    <div class="details-body">
        <div class="form-body">
            <p class="form-header">Finish setting up your account</p>
            <form action="{{ url('register-details') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class = "body-left">
                    <p class="prof-header">Profession</p>
                    <input type="text" name="profession" class="prof-input" required>
                        <div class="header-group">
                            <p class="prof-ys-header">Years of Service</p>
                            <p class="gender-header">Gender</p>
                            <p class="age-header">Age</p>
                        </div>
                            <input type="number" class = "yrs-input" name="service" required>
                            <select class = "gender-input" name="gender">
                                <option> </option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                            <input type="number" class = "age-input" name="age" required>
                            <p class="license-header">Medical License No.</p>
                            <input type="text" name="license" class="license-input" required>
                </div>
                <div class = "body-right">
                    <p class="address-header">Work Address/Company</p>
                    <input type="text" name="address" class="address-input"required>
                    <p class="spec-header">Specialization</p>
                    <div class="spec-choice-container">
                        <div class="spec-choices">
                            <input type="checkbox" class="spec-choice" name="spec[]" value="Anxiety" id="Anxiety">
                            <label for="Anxiety">Anxiety</label>
                        </div>
                        <div class="spec-choices">
                            <input type="checkbox" class="spec-choice" name="spec[]" value="Insomnia" id="Insomnia">
                            <label for="Insomnia">Insomnia</label>
                        </div>
                        <div class="spec-choices">
                            <input type="checkbox" class="spec-choice" name="spec[]" value="Post Traumatic Stress" id="Post Traumatic Stress">
                            <label for="Post Traumatic Stress">Post Traumatic Stress</label>
                        </div>
                    </div>
                    <p class="file-attach-header">Attach a file for verification. this includes: selfie with Government ID, Degree, Medical License</p>
                    <input type="file" class="upload-btn" id="upload-btn" name="verifile[]" multiple required>
                    <label for="upload-btn" class="upload-btn-label">Upload</label>
                </div>
                    <button type="submit" class="signup-btn">Sign up</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>