<link rel="stylesheet" href=" {{ asset('css/doctor/utilities/questionnaire.css')}}">
<link rel="stylesheet" href=" {{ asset('css/doctor/utilities/addquestionnaire.css')}}">
    <div id="questionnaire-container" class="questionnaire-container" style="opacity: 1; visibility: visible;">
        <div id="qst-cat-btns" class="qst-cat-btns"></div>
        <div id="qst-content" class="qst-content"></div>
        <div id="qst-categories" class="qst-categories"></div>
    </div>
    <div id="add-questionnaire-container" class="add-questionnaire-container" style="opacity: 0; visibility: hidden;">
        <div class="qcb-header">
            <p>Add Questionnaire</p>
        </div>
        <div id="qst-form" class="qst-form">
            <div id="aqc-title-input"></div>
        </div>
        <div>
            <button onclick="retrieveData()">submit</button>
        </div>
    </div>
    <script>
        let doctorQuestions = @json($doctorData);
        const questionsKeys =  Object.keys(doctorQuestions.questions);
        const questionTemplates = doctorQuestions.templates;
        
        const questionButtons = document.getElementById('qst-cat-btns');
        const questionContents = document.getElementById('qst-content');
        const questionSubCategories = document.getElementById('qst-categories');

        const qstDiv = document.getElementById("questionnaire-container");
        const addQstDiv = document.getElementById('add-questionnaire-container');
        console.log(doctorQuestions.questions);
        
        questionsKeys.forEach(key => {
            const button = document.createElement("button");
            button.textContent = key;
            button.classList.add('qst-btns');
            button.addEventListener("click", () => displayQuestionTitle(key));

            questionButtons.appendChild(button);
        })

        function displayQuestionTitle(titleKey) {

            const title = doctorQuestions.questions[titleKey];

            ChosenData = title;

            questionContents.innerHTML = " ";
            questionSubCategories.innerHTML = " ";
            Object.keys(title).forEach(questionTitle => {
                const titleText = document.createElement("p");
                titleText.textContent = questionTitle;
                titleText.classList.add('qst-header');
                questionContents.appendChild(titleText);

                const subCategories = title[questionTitle];
                Object.keys(subCategories).forEach(subCat => {
                    const categories = document.createElement("p");
                    categories.textContent = subCat;
                    categories.classList.add('cat-header');
                    questionSubCategories.appendChild(categories);
                    
                    const questionHeaders = subCategories[subCat];
                    Object.keys(questionHeaders).forEach(quest => {
                        const questionData = questionHeaders[quest];
                        const questionContainer = document.createElement("div");

                            const questionText = document.createElement("p");
                            questionText.textContent = `${questionData.question}`;
                            questionContainer.appendChild(questionText);
                            questionContainer.classList.add('questionData-container')
                            let valuelegend = questionData.legend.map((value, index) => `${value} (${questionData.value[index]})`);

                            valuelegend.forEach(index => {
                                const questionValues = document.createElement("p");
                                questionValues.textContent = index;
                                questionValues.classList.add('questionData');
                                questionContainer.appendChild(questionValues); 

                                questionSubCategories.appendChild(questionContainer);
                    })
                });
            });
        });
    }

    let chosenSpec = " ";

       function AddDataSet(){
        qstDiv.style.opacity = 0;
        qstDiv.style.visibility = "hidden";
        qstDiv.style.display = "none";
        addQstDiv.style.opacity = 1;
        addQstDiv.style.visibility = "visible";
        addQstDiv.style.display = "block";

        const formcontainer = document.getElementById("qst-form");
        formcontainer.innerHTML = " ";
        const dropdown = document.createElement("div");
        dropdown.id = "aqc-dropdown";
        const dropdownheader = document.createElement("p");
        dropdownheader.textContent = "Specialization";
        dropdownheader.classList.add("dropdown-header");

        // console.log(doctorQuestions.templates);

        let selectSpec = document.createElement("select");
        selectSpec.name = "aqc-dropdown";
        selectSpec.classList.add("aqc-dropdown-select");
        let defaultOpt = document.createElement("option");
        defaultOpt.textContent = "Choose a Specialization";
        defaultOpt.selected = true;
        selectSpec.appendChild(defaultOpt);

        let specOptions = doctorQuestions.templates;


        Object.keys(specOptions).forEach(spec => {  
            const options = document.createElement("option");
            options.value = spec;
            options.textContent = spec;
            selectSpec.appendChild(options);
        })

        selectSpec.addEventListener("change", function() {
            chosenSpec = selectSpec.value;
        });

        dropdown.appendChild(dropdownheader);
        dropdown.appendChild(selectSpec);
        formcontainer.appendChild(dropdown);

        const titleDiv = document.createElement("div");
        titleDiv.id = "title-container";
        titleDiv.name = "title-container";
        titleDiv.classList.add("title-container");

        const questionHeaderBox = document.createElement("div");
        questionHeaderBox.classList.add("questionHeaderBox");

        const questionHeader = document.createElement("p");
        questionHeader.classList.add("question-header");
        questionHeader.textContent = "Questionnaire Title";

        questionHeaderBox.appendChild(questionHeader);

        questionTitle = document.createElement("input");
        questionTitle.setAttribute("name", "questionTitle");
        questionTitle.setAttribute("placeholder", "Enter Title");
        questionTitle.id = "qst-title";

        titleDiv.appendChild(questionHeaderBox);
        titleDiv.appendChild(questionTitle);
     

        formcontainer.appendChild(titleDiv);


        addCategoryset(formcontainer);
       }

       let questionCounter = 0;


        function addQuestionSet(parent, templateQuestion, legend, value) {

            questID = `aqc-question-input-${questionCounter++}`;

            const qstcontainer = document.createElement("div");
            qstcontainer.id = questID;

            const qstinput = document.createElement("div");
            qstinput.id = "aqc-question-choice-input";
            qstinput.classList.add('aqc-question-choice-input');

            questionText = document.createElement("input");
            questionText.setAttribute("name", "questionText");
            questionText.setAttribute("placeholder", "Enter Question");       
            questionText.id = "qst-question";
            if(templateQuestion){
                questionText.value = templateQuestion;
            }
            addQuestButton = document.createElement("button");
            addQuestButton.setAttribute("type", "button");
            addQuestButton.textContent = "Add Questions";

            removequestion = document.createElement("button");
            removequestion.textContent = "remove";
            removequestion.onclick = function (){
                    removeData(questID);
            }

            qstcontainer.appendChild(questionText);
            qstcontainer.appendChild(addQuestButton);
            qstcontainer.appendChild(removequestion);

            let choiceOptions = ["Choice 1", "Choice 2", "Choice 3", "Choice 4"];
            let choiceValues = ["Value 1", "Value 2", "Value 3", "Value 4"];

            if(legend && value){
                legend.forEach((lkey, index) => {
                    const div = document.createElement("div");
                    div.style.display = "flex";

                    const legendInput = document.createElement("input");
                    legendInput.value = lkey;
                    legendInput.setAttribute("name", "choiceInput");

                    const valueInput = document.createElement("input");
                    valueInput.value = value[index];
                    valueInput.setAttribute("name", "choiceValue");

                    div.appendChild(legendInput);
                    div.appendChild(valueInput);
                    qstinput.appendChild(div);
                    qstcontainer.appendChild(qstinput);
                })
            }
            else{
                choiceOptions.forEach((opt,index) => {
                const div = document.createElement("div");
                div.style.display = "flex";

                const choiceInput = document.createElement("input");
                choiceInput.setAttribute("placeholder", opt);
                choiceInput.setAttribute("name", "choiceInput");

                const valueInput = document.createElement("input");
                valueInput.setAttribute("placeholder", choiceValues[index]);
                valueInput.setAttribute("name", "choiceValue");

                div.appendChild(choiceInput);
                div.appendChild(valueInput);
                qstinput.appendChild(div);
                qstcontainer.appendChild(qstinput);
            });
            }
            parent.appendChild(qstcontainer);
            
            addQuestButton.addEventListener("click", function() {
            addQuestionSet(parent);
            })
        }

        let categoryCounter = 0;

        function addCategoryset(parentCat, templateData, templateQuestion, legend, value) {

            let categoryID = `aqc-category-input-${categoryCounter++}`;
            const categoryContainer = document.createElement("div");
            categoryContainer.id = categoryID;
            categoryContainer.classList.add('aqc-category-input');


            questionCategory = document.createElement("input");
            questionCategory.setAttribute("name", "questionCategory");
            questionCategory.setAttribute("placeholder", "Enter Category");
            questionCategory.id = "qst-category";
            if(templateData){
                questionCategory.value = templateData;
            }

            addCategoryButton = document.createElement("button");
            addCategoryButton.setAttribute("type", "button");
            addCategoryButton.textContent = "Add Category";

            removeCategory = document.createElement("button");
            removeCategory.textContent = "remove";
            removeCategory.onclick = function () {
                removeData(categoryID);
            }
            
            categoryContainer.appendChild(questionCategory);
            categoryContainer.appendChild(addCategoryButton);
            categoryContainer.appendChild(removeCategory);

            parentCat.appendChild(categoryContainer);
            
            addQuestionSet(categoryContainer, templateQuestion, legend, value);
            addTemplate(parentCat);
         
            addCategoryButton.addEventListener("click", function() {
            addCategoryset(parentCat);
            });
        }

        let tmpbtn = 0;

        function addTemplate(parentDiv){
            let templateCategory;
            let templateQuestion;
            let templateQuestionData;
            let templateQuestionText;
            let legend;
            let value;
            let tempBoxID = `template-container-${tmpbtn++}`;
            let tempsaveBtn = `save-btn-${tmpbtn++}`;
            let tempaddBtn = `add-btn-${tmpbtn++}`;

            const templateDiv = document.createElement("div");
            templateDiv.id = tempBoxID;

            const tempButton = document.createElement("button");
            tempButton.textContent = "Add Template";
            tempButton.id = tempaddBtn;
            tempButton.style.display = "block";
            

            const saveBtn = document.createElement("button");
            saveBtn.textContent = "save";
            saveBtn.id = tempsaveBtn;
            saveBtn.style.display = "none";

            templateDiv.appendChild(tempButton);
            templateDiv.appendChild(saveBtn);

            
            tempButton.addEventListener("click", function () {
                
                document.getElementById(tempaddBtn).style.display = "none";
                document.getElementById(tempsaveBtn).style.display = "block";
                
                const tempDataDiv = document.createElement("div");
                tempDataDiv.classList.add = "tempDataDiv";

                const selecTemp = document.createElement("select");
                const selectTempQuest = document.createElement("select");
                const selectTempData = document.createElement("select");
                const questionText = document.createElement("input");
                const legendValue = document.createElement("div");

                const catTemps = questionTemplates[chosenSpec];

                Object.keys(catTemps).forEach(key => {
                    const options = document.createElement("option");
                    options.value = key;
                    options.textContent = key;
                    selecTemp.appendChild(options);
                });

                    selecTemp.addEventListener("change", function() {
                            templateCategory = selecTemp.value;
                            const questTemps = catTemps[templateCategory];
                            
                            selectTempQuest.innerHTML="";
                                Object.keys(questTemps).forEach(qkey => {
                                    const qoptions = document.createElement("option");
                                    qoptions.value = qkey;
                                    qoptions.textContent = qkey;
                                    selectTempQuest.appendChild(qoptions);
                                });
                                templateQuestion = selectTempQuest.value;

                                
                                selectTempQuest.addEventListener("change", function(){
                                        templateQuestionData = selectTempQuest.value;
                                        const questData = questTemps[templateQuestionData];

                                        selectTempData.innerHTML = "";

                                        Object.keys(questData).forEach(dkey => {
                                        const doptions = document.createElement("option");
                                        doptions.value = dkey;
                                        doptions.textContent = dkey;
                                        selectTempData.appendChild(doptions);
                                    });

                                    selectTempData.addEventListener("change", function() {
                                            templateQuestionText = selectTempData.value;
                                            const questTextData = questData[templateQuestionText];

                                            questionText.value = questTextData.question;
                                            
                                            questionText.innerHTML = " ";
                                            legendValue.innerHTML = " ";
                                            
                                            legend = questTextData.legend;
                                            value = questTextData.value;

                                            questTextData.legend.forEach((lkey, index) => {
                                                const legValDiv = document.createElement("div");
                                                legValDiv.style.display = "flex";

                                                const legendText = document.createElement("input");
                                                legendText.value = lkey;

                                                const valueText = document.createElement("input");
                                                valueText.value = questTextData.value[index];

                                                legValDiv.appendChild(legendText);
                                                legValDiv.appendChild(valueText);
                                                legendValue.appendChild(legValDiv);
                                            })
                                    });
                                });
                            });

                templateDiv.appendChild(selecTemp);            
                templateDiv.appendChild(selectTempQuest);            
                templateDiv.appendChild(selectTempData);            
                templateDiv.appendChild(questionText);            
                templateDiv.appendChild(legendValue);  
                          
                

                saveBtn.addEventListener("click", function(){
                    addCategoryset(parentDiv, templateCategory, templateQuestion, legend, value);
                    templateDiv.innerHTML = " ";
                });
            });


            parentDiv.appendChild(templateDiv);
        }

        function removeData(id){
            const removeData = document.getElementById(id);
            if(removeData){
                removeData.remove();
            }
        }
        
        function retrieveData(){
            let selectedSpec = document.querySelector('#aqc-dropdown select').value;
            console.log(selectedSpec);
            let title = document.getElementById("qst-title").value;
            
            let mainObj = {};

            mainObj[title] = {};

            let categories = document.querySelectorAll(".qst-form .aqc-category-input input[name='questionCategory']");
            categories.forEach((cat,index) => {
                let categoryName = cat.value;
                mainObj[title][categoryName] = {};
                
                let questionText = cat.parentElement.querySelectorAll("input[name='questionText']");
                questionText.forEach((qst,qindex) => {
                    let questionKey = `Q${qindex+1}`;
                    mainObj[title][categoryName][questionKey] = {
                        legend: [],
                        question: qst.value,
                        value:[]
                    };

                    let choices = qst.parentElement.querySelectorAll(".aqc-question-choice-input div");
                    choices.forEach((choice, cindex) => {

                        let choiceLegend = choice.querySelector("input[name='choiceInput']").value;
                        mainObj[title][categoryName][questionKey].legend.push(choiceLegend);
                        let choiceValue = choice.querySelector("input[name='choiceValue']").value;
                        mainObj[title][categoryName][questionKey].value.push(choiceValue);
                    });
                });
            });

           
            fetch('/doctorProfile/addQuestion', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    specialization: selectedSpec,
                    questionData: mainObj
                }),
            })
            .then(response => {
                if(response.ok) {
                    console.log('Questionnaire successfully submitted.');
                    AddDataSet();
                }
            })

        }
    </script>

    

