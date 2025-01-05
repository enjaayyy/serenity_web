            <div class="upload-container" id="upload-screen" style="display: none;">
                <div class="main-card">
                    <div class="card-header">
                        <p>Upload Profile Picture</p>
                    </div>
                    <form method="POST" action="{{ route('uploadpp') }}" enctype="multipart/form-data">
                            @csrf
                    <div class="upld-btn">
                        {{-- <label for="pp-upload" class="get-pic">
                            <p>Upload Photo</p>
                        </label> --}}
                        <input id="pp-upload" type="file" name="pp" accept="image/*"> 
                    </div>
                    <div class="save-pic">
                        
                            <button type="submit" class="submit">
                                <p>Save</p>
                            </button>
                    </div>
                    </form>
                    <div class="close-btn">
                        <button onclick="closeuploadcard()">
                            <p>Close</p>
                        </button>
                    </div>
                </div>
            </div>