
const storedImages = [];

function openUploadModal(){
    document.getElementById('upload-modal-screen').style.display = "inline-flex";
}


function saveUpload(){
    document.getElementById('upload-modal-screen').style.display = "none";
}


function closeUploadModal(){
    document.getElementById('upload-modal-screen').style.display = "none";

    let container = document.getElementById('upload-data-container');

    container.innerHTML = " ";
    storedImages.length = 0;
}




function fileUpload(){
    const fileUpload = document.getElementById('upload-input');
    const fileContainer = document.getElementById('upload-data-container');

    fileUpload.addEventListener('change', () => {
        const imagefiles = Array.from(fileUpload.files);
            if(imagefiles.length > 0){
                imagefiles.forEach(file => {

                    storedImages.push(file);
                    console.log(storedImages);
                    const uploadWrapper = document.createElement('div');
                    uploadWrapper.classList.add('uploadWrapper');

                    const mainUploadWrapper = document.createElement('div');
                    mainUploadWrapper.classList.add('mainUploadWrapper');

                    const imageIcon = document.createElement('img');
                    imageIcon.src = '/assets/image.svg';
                    imageIcon.classList.add('image-icon');
                    mainUploadWrapper.appendChild(imageIcon);

                    const imageTextContainer = document.createElement('div');
                    imageTextContainer.classList.add('imageTextContainer');

                    imageTextContainer.textContent = file.name;

                    mainUploadWrapper.appendChild(imageTextContainer);

                    const removebutton = document.createElement('button');
                    removebutton.textContent = "X";
                    removebutton.type = "button";
                    removebutton.classList.add('removebutton');
                    mainUploadWrapper.appendChild(removebutton);

                    removebutton.addEventListener("click", () => {
                        uploadWrapper.remove();
                        storedImages.splice(storedImages.indexOf(file), 1);
                    })

                    const previewWrapper = document.createElement('div');
                    previewWrapper.classList.add('previewWrapper');
                    previewWrapper.style.display = "none";

                    const previewImage = document.createElement('img');
                    previewImage.src = URL.createObjectURL(file);
                    previewImage.classList.add('previewImage');

                    previewWrapper.appendChild(previewImage);

                    mainUploadWrapper.addEventListener('click', () => {
                        if(previewWrapper.style.display === "none"){
                            previewWrapper.style.display = "block";
                        }
                        else{
                            previewWrapper.style.display = "none";
                        }
                    });

 
                    uploadWrapper.appendChild(mainUploadWrapper);
                    uploadWrapper.appendChild(previewWrapper);
                    fileContainer.appendChild(uploadWrapper);
                })
                
                // console.log(fileNames);  
        }
    });
}


fileUpload();

document.querySelector('form').addEventListener('submit', function(e){
    const dataTransfer = new DataTransfer();
    storedImages.forEach(file => dataTransfer.items.add(file));

    document.getElementById('upload-input').files = dataTransfer.files;
})