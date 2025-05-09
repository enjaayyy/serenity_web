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
                    <select class="prof-input" name="profession">
                        <option>Choose a profession</option>
                        @foreach($professions as $prof)
                            <option>{{ $prof }}</option>
                        @endforeach
                    </select>
                        <div class="header-group">
                            <p class="prof-ys-header">Years of Service</p>
                            <p class="gender-header">Gender</p>
                            <p class="age-header">Age</p>
                        </div>
                            <input type="number" class = "yrs-input" name="service" autocomplete="off" required>
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
                    <div class="file-upload-container">
                        <button type="button" id="open-upload-modal" onclick="openUploadModal()" class="upload-files-button">Upload file(s)</button>
                        {{-- <button type="button"  --}}
                    </div>
                    
                </div>
                    <button type="submit" class="signup-btn">Sign up</button>
                    <div id="upload-modal-screen" class="upload-modal-screen" style="display:none;">
                        <div class="upload-card">
                            <div class="upload-card-header-container">
                                <p class="upload-card-header">Upload a File</p>
                            </div>
                            <div class="upload-data-container" id="upload-data-container">
                    
                            </div>
                            <div class="upload-card-button-container">
                                <input class="upload-input" id="upload-input" name="verifile[]" type="file" accept="image/*" style="display: none;" multiple required>
                                    <label for="upload-input" class="add-image-button">
                                        <img src="{{ asset('assets/add-icon.svg') }}">
                                    </label>
                                <button type="button" class="cancel-button" onclick="closeUploadModal()">
                                    <p>Cancel</p>
                                </button>
                                <button type="button" class="save-button" onclick="saveUpload()">
                                    <p>Save Upload</p>
                                </button>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
<script src="{{ asset('js/register-details.js')}}"></script>
