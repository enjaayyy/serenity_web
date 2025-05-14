<!DOCTYPE html>
<html>
<head>
        <link rel="stylesheet" href="{{ asset('css/register-details.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="details-container">
    <a href ="{{ route('home') }}" style = "text-decoration: none;">
        <img src="{{asset('assets/logo-w-text.svg') }}" class="register-logo">
    </a>
    <div class="details-body">
        <div class="form-body">
            <p class="form-header">Finish setting up your account</p>
                <div class="ocr-button-container">
                    <input id="ocr-image-input" name="ocr-image" type="file" accept="image/*" style="display:none;">
                    <label for="ocr-image-input" title="Populate input fields by uploading an image">
                        <img src="{{ asset('assets/upload-icon.svg') }}">
                        <p class="image-text" id="image-text" >Upload Image</p>
                    </label>
                    <button class="generate-ocr-button" onclick="generateText()">
                        Generate
                    </button>
                </div>
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
                            <input type="number" id="age-input" class = "age-input" name="age" required>
                            <div style="display:flex; gap: 1.5vw;">
                                <p class="license-header">Medical License No.</p>
                                <p class="license-header">Date issued</p>
                                <p class="license-header">Expiry</p>
                            </div>
                            <div style="display:flex; gap: 1.3vw;">   
                                <input type="text" name="license" class="license-input" id="license-input" required>
                                <input type="date" name="licenseissued" class="license-issued-input" id="license-issued-input" required>
                                <input type="date" name="licenseexpired" class="license-expired-input" id="license-expired-input" required>
                            </div>
                            
                </div>
                <div class = "body-right">
                    <p class="address-header">Work Address/Company</p>
                    <input type="text" name="address" id="address-input" class="address-input"required>
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
                        <p>Upload your Government ID, License, Selfie, and all other credentials.</p> 
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
<script>
    function generateText(){
        const fileInput = document.getElementById('ocr-image-input');
        const fileContainer = document.getElementById('upload-data-container');
        const file = fileInput.files[0];

        const formData = new FormData();
        formData.append('ocr-image', file);

        fetch("/register-details/generateImageToText", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.rawText);
            // console.log(data.expired);
            if(data.error){
                alert('Invalid Image');
            }
            else{
                document.getElementById('license-input').value = data.licenseNumber;
                document.getElementById('address-input').value = data.address;
                document.getElementById('age-input').value = data.age;
                document.getElementById('license-issued-input').value = data.issued;
                document.getElementById('license-expired-input').value = data.expired;

                const selectProfessions = document.querySelector('.prof-input');
                const matchedProfession = data.profession[0];

                if(matchedProfession){
                    for(let option of selectProfessions.options) {
                        if(option.text.toLowerCase() === matchedProfession.toLowerCase()){
                            option.selected = true;
                            break;
                        }
                    }
                }

                const selectGender = document.querySelector('.gender-input');
                const matchedGender = data.gender[0];

                if(matchedGender){
                    for(let option of selectGender.options){
                        if(option.text.toLowerCase() === matchedGender.toLowerCase()){
                            option.selected = true;
                            break;s
                        }
                    }
                }

                imageWrapper(file, fileContainer);
            }
        })
        .catch(err => console.error("Fetch error", err));
    }   


</script>