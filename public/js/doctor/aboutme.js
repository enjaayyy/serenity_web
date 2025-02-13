function editData(){
    document.getElementById('edit-btn').style.display = "none";
    let headerContainer = document.getElementById('main-detail-header');

    let name = document.getElementById('doctor-name');
    name.style.display = "none";

    let newName = document.createElement('input');
    newName.value = name.textContent;
    newName.classList.add('name-input');
    newName.id = "name-input";

    headerContainer.appendChild(newName);

    let saveBtn = document.createElement("button");
    saveBtn.textContent = "Save";
    saveBtn.classList.add('save-btn');
    saveBtn.id = "save-btn";
    headerContainer.appendChild(saveBtn);

}

function testButton(){
    let testButton = document.getElementById('name-input').value;
    alert(testButton);
}