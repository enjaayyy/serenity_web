<div style="display:flex; justify-content: space-between; align-items:center">
    <p class="cred-header">Credentials</p>
    <button class="credinputlabel" onclick="opencredentialModal()">
        <img src="{{ asset('/assets/add-icon.svg') }}">
    </button>
</div>
<div class="cred-container" id="cred-container">
    @foreach($doctorData['creds'] as $index => $creds)
        <div class="filetitle-wrapper clickable" id="filetitle-wrapper" data-index="{{ $index }}" data-src="{{ $creds['url']}}">
            <img src={{ asset('/assets/image.svg') }}>
            <p class="file-name">{{ $creds['filename']}}</p>
        </div>
    @endforeach
        <div class="image-preview-screen" id="image-preview-screen" style="display: none;">
            <form method="POST" action="{{ route('addcredentials')}}" enctype="multipart/form-data">
                @csrf
                <div class="image-preview-modal">
                    <input type="file" name="imagefile" class="imagefile" id="imagefile"accept="image/*">
                    {{-- <div class="upload-preview" id="upload-preview">
                    </div> --}}
                    <button type="submit">Submit</button>
                </div>
            </form>
        </div>
</div>



<script>
    document.addEventListener("DOMContentLoaded", () => {
        const wrappers = document.querySelectorAll('.filetitle-wrapper');
            wrappers.forEach(wrapper => {
                wrapper.addEventListener('click', () => {
                    const index = wrapper.getAttribute('data-index');
                    const imgURL = wrapper.getAttribute('data-src');
                    const preview = document.querySelector(`.image-preview[data-index="${index}"]`);
                    const imagecontainer = document.getElementById('credentials-preview-container');
                    const scrollDiv = document.getElementById('other-data');


                    imagecontainer.innerHTML = " ";

                    const img = document.createElement('img');
                    img.src = imgURL;

                    imagecontainer.appendChild(img);
                    console.log(imgURL);

                    scrollDiv.scrollTo({
                        top: scrollDiv.scrollHeight,
                        behavior: 'smooth'
                    })
                    
                });
            })

        

    })
    function opencredentialModal(){
            document.getElementById('image-preview-screen').style.display = "flex";
        }

        const getImage = document.getElementById('imagefile').value;
        console.log(getImage);  
</script>