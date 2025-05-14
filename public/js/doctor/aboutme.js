function editData(){
    document.getElementById('edit-btn').style.display = "none";
    let headerContainer = document.getElementById('main-detail-header');
    let subHeaderContainer = document.getElementById('doctor-profession-container');

    let name = document.getElementById('doctor-name');
    name.style.display = "none";

    convertToInput(name,"text", "name-input","name-input","name-input", headerContainer);

    let saveBtn = document.createElement("button");
    saveBtn.textContent = "Submit Changes";
    saveBtn.title = "Changes will be applied after approval from administrator";
    saveBtn.classList.add('save-btn');
    saveBtn.id = "save-btn";
    headerContainer.appendChild(saveBtn);

    let spec = document.getElementById('doctor-profession');
    spec.style.display = "none";

    convertToInput(spec,"text", "spec-input","spec-input","spec-input", subHeaderContainer);

    let infoContainer = document.getElementById('ddata-container');

    let age = document.getElementById('ddata-age');
    let gender = document.getElementById('ddata-gender');
    let years = document.getElementById('ddata-years');
    let license = document.getElementById('ddata-license');
    let issued = document.getElementById('ddata-issued');
    let expiry = document.getElementById('ddata-expiry'); 

    age.style.display = "none";
    gender.style.display = "none";
    years.style.display = "none";
    license.style.display = "none";
    issued.style.display = "none";
    expiry.style.display = "none";

    convertToInput(age,"number" ,"age-input","input-content","age-input", infoContainer);
    convertToSelect(gender, "gender-input","input-content","gender-input", infoContainer);
    convertToInput(years, "number", "years-input","input-content","years-input", infoContainer);
    convertToInput(license, "number","license-input","input-content","license-input", infoContainer);
    convertToInput(issued, "date", "issued-input","input-content","issued-input", infoContainer);
    convertToInput(expiry, "date","expiry-input","input-content","expiry-input", infoContainer);

    let additionalInfoContainer = document.getElementById('ddata-container-2');

    let address = document.getElementById('address-input');
    address.style.display = "none";

    convertToInput(address,"text", "address-input","input-content","address-input", additionalInfoContainer);

    let doctorDetailsContainer = document.getElementById('doctor-description');
    let doctorDetails = document.getElementById('doctor-description-area');
    doctorDetails.style.display = "none";


    convertToTextArea(doctorDetails, "detail-textarea", "doctor-description-area", "detail-textarea", doctorDetailsContainer)
}

function convertToInput(ID, type, newID, classname, elementname, parent){
    let newDiv = document.createElement('div');

    let x = document.createElement('input');
    x.type = type;
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

function convertToSelect(ID, newID, classname, elementname, parent){
    let x = document.createElement('select')
    x.id = newID;
    x.name = elementname;
    x.classList.add(classname);

    let defualt = document.createElement('option');
    defualt.value = ID.textContent;

    x.appendChild(defualt);

    let genders = ['Male', 'Female'];

    genders.forEach(gender => {
        const option = document.createElement('option');
        option.textContent = gender;
        option.value = gender;
        x.appendChild(option);
    })

    parent.appendChild(x);
}