function editData(){
    document.getElementById('edit-btn').style.display = "none";
    let headerContainer = document.getElementById('main-detail-header');
    let subHeaderContainer = document.getElementById('doctor-profession-container');

    let name = document.getElementById('doctor-name');
    name.style.display = "none";

    convertToInput(name,"name-input","name-input","name-input", headerContainer);

    let saveBtn = document.createElement("button");
    saveBtn.textContent = "Save";
    saveBtn.classList.add('save-btn');
    saveBtn.id = "save-btn";
    headerContainer.appendChild(saveBtn);

    let spec = document.getElementById('doctor-profession');
    spec.style.display = "none";

    convertToInput(spec,"spec-input","spec-input","spec-input", subHeaderContainer);

    let infoContainer = document.getElementById('ddata-container');

    let age = document.getElementById('ddata-age');
    let gender = document.getElementById('ddata-gender');
    let years = document.getElementById('ddata-years');
    let license = document.getElementById('ddata-license');
    age.style.display = "none";
    gender.style.display = "none";
    years.style.display = "none";
    license.style.display = "none";

    convertToInput(age,"age-input","input-content","age-input", infoContainer);
    convertToInput(gender,"gender-input","input-content","gender-input", infoContainer);
    convertToInput(years,"years-input","input-content","years-input", infoContainer);
    convertToInput(license,"license-input","input-content","license-input", infoContainer);

    let additionalInfoContainer = document.getElementById('ddata-container-2');

    let email = document.getElementById('email-input');
    let address = document.getElementById('address-input');
    email.style.display = "none";
    address.style.display = "none";

    convertToInput(email,"email-input","input-content","email-input", additionalInfoContainer);
    convertToInput(address,"address-input","input-content","address-input", additionalInfoContainer);

    let doctorDetailsContainer = document.getElementById('doctor-description');
    let doctorDetails = document.getElementById('doctor-description-area');
    doctorDetails.style.display = "none";


    convertToTextArea(doctorDetails, "detail-textarea", "doctor-description-area", "detail-textarea", doctorDetailsContainer)
}

function convertToInput(ID, newID, classname, elementname, parent){
    let newDiv = document.createElement('div');

    let x = document.createElement('input');
    x.value = ID.textContent;
    x.id = newID;
    x.classList.add(classname);
    x.name = elementname;

    newDiv.appendChild(x);
    parent.appendChild(newDiv);
}

function convertToTextArea(ID, newID, classname, elementname, parent){
    let x = document.createElement('textarea');
    x.value = ID.textContent;
    x.id = newID;
    x.classList.add(classname);
    x.name = elementname;

    parent.appendChild(x);
}