let addEventContainer = document.getElementById('schedules-container');
let addID = 0;

function addSchedule(){
    let wrapperDivID = "wrapperDiv-" + addID++;
    let wrapperDiv = document.createElement("div");
    wrapperDiv.classList.add("schedulewrapper");
    wrapperDiv.id = wrapperDivID;
    let dateDiv = document.createElement("div");
    dateDiv.classList.add("dateDiv");

    let detailsDiv = document.createElement("div");

    let dateInput = document.createElement("input");
    dateInput.type = "date";

    let timeInput = document.createElement("input");
    timeInput.type = "time";

    let detailsInput = document.createElement("input");
    detailsInput.type = "text";

    dateDiv.appendChild(dateInput);
    dateDiv.appendChild(timeInput);
    detailsDiv.appendChild(detailsInput);

    let addbutton = document.createElement('button');
    addbutton.id = "addbutton";
    addbutton.classList.add('addbutton');

    let addImg = document.createElement('img');
    addImg.src = "../../assets/plus-icon.svg";

    addbutton.appendChild(addImg);

    let removebutton = document.createElement('button');
    removebutton.id = "removebutton";
    removebutton.classList.add('removebutton');
    removebutton.onclick = function(){
        removeAddSched(wrapperDivID);
    };

    let removeImg = document.createElement('img');
    removeImg.src = "../../assets/remove-icon.svg";

    removebutton.appendChild(removeImg);

    let midDiv = document.createElement("div");
    midDiv.classList.add('midDiv');
    let rightDiv = document.createElement("div");
    rightDiv.classList.add('rightDiv');

    rightDiv.appendChild(addbutton);
    rightDiv.appendChild(removebutton);

    midDiv.appendChild(dateDiv);
    midDiv.appendChild(detailsDiv);

    wrapperDiv.appendChild(midDiv);
    wrapperDiv.appendChild(rightDiv);

    addEventContainer.appendChild(wrapperDiv);
}

function removeAddSched(id){
    const removeData = document.getElementById(id);
    if(removeData){
        removeData.remove();
    }
}
function displayCalendarSchedules(calendar){
    // calendar.addEvent({
    //             title: 'Meeting with John',
    //             start: '2025-03-20',
    //         });
    //         calendar.addEvent({
    //             title: 'Meeting with Me',
    //             start: '2025-03-22',
    //         });
}