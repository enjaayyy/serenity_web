let monthData = null;
let yearData = null;

let mainData = document.getElementById('main-content');
let patientDetails = JSON.parse(mainData.dataset.info);
let monthChartID = document.getElementById('month-chart');
let yearChartID = document.getElementById('year-chart');

let currentMonthIndex = new Date().getMonth();
let monthsArray = [];
let monthCategoryArray = [];
let monthCategoryTotal = [];
let monthDataObject = {};
let patientCondition;

function getCondition(condition){
    let patientCategory = patientDetails.answer;
    patientCondition = condition;
    let labels = [];
    let values = [];

    let forYearDate;
    let forYearDateFormat   
    let yearDataObject = {};

    Object.keys(patientCategory).forEach(cat => {
        if(cat === condition){
            let titles = patientCategory[cat];
                Object.keys(titles).forEach(titleKey =>{
                    let total = titles[titleKey];
                    if(total.Overall){
                        values.push(total.Overall);
                        labels.push(total.timestamp);
                    }

                    forYearDate = new Date(total.timestamp);
                    forYearDateFormat = forYearDate.toLocaleString('default', {month: 'long', year: 'numeric'});

                    if(!yearDataObject[forYearDateFormat]){
                        yearDataObject[forYearDateFormat] = 0;
                    }
                    if(!monthDataObject[forYearDateFormat]){
                        monthDataObject[forYearDateFormat] = {};
                    }

                    yearDataObject[forYearDateFormat] += Number(total.Overall);
                    monthDataObject[forYearDateFormat][titleKey] = {
                        Overall: Number(total.Overall),
                        date: total.timestamp,
                        categories: {},
                    }

                    Object.keys(total).forEach(category =>{
                        if(category !== "timestamp" && category !== "Overall"){
                            monthDataObject[forYearDateFormat][titleKey].categories[category] = total[category];
                        }
                    })
                })
        }
    });
    monthsArray = Object.keys(monthDataObject);
    if(currentMonthIndex >= monthsArray.length) currentMonthIndex = 0;

    if (monthData) monthData.destroy();
    if (yearData) yearData.destroy();

    let yearlyLabels = Object.keys(yearDataObject);
    let yearlyvalues = Object.values(yearDataObject);

    yearData = getChart(yearChartID, condition, yearlyLabels, yearlyvalues);
    getMonthChart(monthDataObject, condition);

}

function getMonthChart(object, condition){
    let currentMonth = monthsArray[currentMonthIndex];
    let monthlyData = object[currentMonth];
    let monthLabels = Object.keys(monthlyData).map(weeks => {
    let date = new Date(monthlyData[weeks].date);
        return date.toLocaleDateString('en-US', {day: 'numeric', weekday: 'short'});
    });
    let monthValues = Object.keys(monthlyData).map(weeks => monthlyData[weeks].Overall);

    document.getElementById('currentMonth').innerText = currentMonth;

    if (monthData) monthData.destroy();

    monthData = getChart(monthChartID, condition, monthLabels, monthValues);
    getBreakdown(monthlyData);
    getQuestionnaires(monthlyData);
}

document.getElementById('back').addEventListener("click", function(){
    if(currentMonthIndex > 0){
        currentMonthIndex --;
        getMonthChart(monthDataObject, patientCondition);
    }
});

document.getElementById('next').addEventListener("click", function(){
    if(currentMonthIndex < monthsArray.length - 1){
        currentMonthIndex ++;
        getMonthChart(monthDataObject, patientCondition);
    }
})

let breakdownContainer = document.getElementById('chart-breakdown-container');

function getBreakdown(object){
    breakdownContainer.innerHTML = " ";
    Object.keys(object).forEach(mKey =>{
        let subObject = object[mKey].categories;
        let date = new Date(object[mKey].date);
        let headerDate = date.toLocaleDateString('default', {month: 'long', day: 'numeric', year: 'numeric'});
        let mainDiv = document.createElement('div');

        let dateHeader = document.createElement('p');
        dateHeader.textContent = headerDate;

        mainDiv.appendChild(dateHeader);

        let BGcolorSet = ["#FFDFDF", "#F8DCFF", "#FFECDF"];
        let textcolorSet = ["#FF3333", "#6E0089", "#FFC933"];

            Object.keys(subObject).forEach((catKeys, index) =>{
                let wrapperDiv = document.createElement("div");
                wrapperDiv.style.display = "flex";
                wrapperDiv.classList.add("category-wrapper");
                wrapperDiv.style.backgroundColor = `${BGcolorSet[index]}`

                let categoryData = subObject[catKeys];
                let dataText = document.createElement('p');
                dataText.textContent = catKeys;
                dataText.style.color = `${textcolorSet[index]}`;

                let totalText = document.createElement('p');
                totalText.textContent = categoryData.Total;
                totalText.style.color = `${textcolorSet[index]}`;

                wrapperDiv.appendChild(dataText);
                wrapperDiv.appendChild(totalText);
                
                mainDiv.appendChild(wrapperDiv);
            });



        breakdownContainer.appendChild(mainDiv);
        
    })

}

function getChart(ChartID, condition, labels, values){

    return new Chart(ChartID, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
            label: condition,
            data: values ? values : 0,
            borderWidth: 1
        }]
        },
        options: {
        scales: {
            y: {
            beginAtZero: true
            }
        }
        }
    });
}

let questionnaireContainer = document.getElementById('questionnaire-history-container');

function getQuestionnaires(object){
    questionnaireContainer.innerHTML = " ";
        Object.keys(object).forEach(mKey => {
            let subObject = object[mKey].categories;
            let date = new Date(object[mKey].date);
            let headerDate = date.toLocaleDateString('default', {month: 'long', day: 'numeric', year: 'numeric'}); 
            let objButtons = document.createElement('button');
            objButtons.classList.add("objButtons");

            
            let buttonText = document.createElement('p');
            buttonText.textContent = headerDate;

            objButtons.appendChild(buttonText);
            questionnaireContainer.appendChild(objButtons);

            objButtons.addEventListener("click", function(){
                let buttonContent = object[mKey];
                createQuestionnaireModal(buttonContent, headerDate);
            });
        })
}

function createQuestionnaireModal(object, date){
    let bgScreen = document.createElement("div");
    bgScreen.classList.add('question-modal-screen');
    bgScreen.id = 'question-modal-screen';

    let questionCard = document.createElement("div");
    questionCard.id = "questionnaire-card";
    questionCard.classList.add("questionnaire-card");

    let headWrapper = document.createElement("div");
    headWrapper.classList.add("q-card-header-container");
    
    let modalTitle = document.createElement('p');
    modalTitle.textContent = date;
    modalTitle.classList.add('modalTitle');

    let exitBtn = document.createElement('button');
    exitBtn.textContent = "x";
    exitBtn.classList.add('exitBtn');

    exitBtn.addEventListener("click", function() {
        document.getElementById("question-modal-screen").remove();
    })

    headWrapper.appendChild(modalTitle);
    headWrapper.appendChild(exitBtn);

    let bodyWrapper = document.createElement("div");
    bodyWrapper.classList.add("q-card-body-container");

    let overall = document.createElement('p');
    overall.textContent = "Total Subject Score: " + object.Overall;
    overall.classList.add('overall');

    bodyWrapper.appendChild(overall);

    Object.keys(object.categories).forEach(mKeys => {
        let subObject = object.categories[mKeys];
        let questionDataTotal = subObject.Total;
        let dataDiv = document.createElement("div");
        let catDiv = document.createElement("div");
        catDiv.classList.add("catDiv");

        let catLegend = document.createElement("p");
        catLegend.textContent = "Category";
        catLegend.classList.add("catLegend");
        let cat = document.createElement("p");
        cat.textContent = mKeys;
        cat.classList.add("cat");

        let total = document.createElement("p");
        total.textContent = "Category Total: " + questionDataTotal;
        total.classList.add("cattotal");

        catDiv.appendChild(catLegend);
        catDiv.appendChild(cat);

            Object.keys(subObject).forEach(qKeys => {
                let questionData = subObject[qKeys];

                const answerContainer = document.createElement("div");
                answerContainer.classList.add('answerContainer');
                const answerData = document.createElement("p");
                const legendData = document.createElement("p");

                let questionContainer = document.createElement('div');

                if(questionData.legend && questionData.value && questionData.question){
                    const questionTextHeader = document.createElement("p");
                    questionTextHeader.textContent = "Question";
                    questionTextHeader.classList.add("questionTextHeader");

                    const questionText = document.createElement("p");
                    questionText.textContent = questionData.question;
                    questionText.classList.add("questionText");

                    questionContainer.appendChild(questionTextHeader);   
                    questionContainer.appendChild(questionText);   

                    answerData.textContent = "Answer: " +  questionData.value;
                    answerContainer.appendChild(answerData);

                    legendData.textContent = "Legend: " +  questionData.legend;
                    answerContainer.appendChild(legendData);
                    }
                    else{
                       
                    }
                    
                    questionContainer.appendChild(answerContainer);    
                    catDiv.appendChild(questionContainer);
                })

        catDiv.appendChild(total);
        dataDiv.appendChild(catDiv);
        bodyWrapper.appendChild(dataDiv);
    })  


    questionCard.appendChild(headWrapper);
    questionCard.appendChild(bodyWrapper);
    bgScreen.appendChild(questionCard);
    document.body.append(bgScreen);
}