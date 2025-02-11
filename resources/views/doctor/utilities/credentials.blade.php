<div class="cred-container" id="cred-container">
    <div class="credential-header-container">
        <p class="credential-header">Credentials<p>
    </div>
        <div class="picture-container">
                <div class="image-display">
                    <img class="cred-image" id="current-image" src="">
                </div>
        </div>
        <div class="cred-btns">
                    <button class="prev" onclick="prevImage()"><img src="{{ asset('assets/arrow-left.svg') }}"></button>
                    <button class="add" onclick="uploadcred()"><img src="{{ asset('assets/plus-icon.svg') }}"></button>
                    <button class="next" onclick="nextImage()"><img src="{{ asset('assets/arrow-right.svg') }}"></button>
                </div>
        <script>
            const images = @json($doctorData['creds']);
            let currentIndex = 0;

            function displayImage(index){
                const imageElement = document.getElementById('current-image');
                    if(images.length > 0){
                        imageElement.src = images[index];
                    } else {
                        imageElement.alt = "No Credentials Available";
                    }
            }
            document.addEventListener('DOMContentLoaded', () => {
            displayImage(currentIndex);
            })

            function prevImage() {
            if (images.length > 0){
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                displayImage(currentIndex);
                }
            }

                                function nextImage() {
                                    if (images.length > 0){
                                        currentIndex = (currentIndex + 1) % images.length;
                                        displayImage(currentIndex);
                                    }
                                }
                                
                            </script>
                    </div>
                <div class="upload-container" id="upload-cred-screen" style="display: none;">
                <div class="main-card">
                    <div class="card-header">
                        <p>Add Credentials</p>
                    </div>
                    <form method="POST" action="{{ route('addcredentials') }}" enctype="multipart/form-data">
                            @csrf
                    <div class="upld-btn">
                        <label for="credential" class="get-pic">
                            <p id="file-name">Upload Credential</p>
                        </label>
                        <input id="credential" type="file" name="credential" accept="image/*" style="display: none;"> 
                        <script>
                            document.getElementById('credential').addEventListener('change', function(event) {
                                let filename = event.target.files[0] ? event.target.files[0].name : "Upload Photo";
                                document.getElementById('file-name').textContent = filename;
                            })
                        </script>
                    </div>
                    <div class="save-pic">
                            <button type="submit" class="submit">
                                <p>Save</p>
                            </button>
                    </div>
                    </form>
                    <div class="close-btn">
                        <button onclick="closeuploadcred()">
                            <p>Close</p>
                        </button>
                    </div>
                </div>
            </div>