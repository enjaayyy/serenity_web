<link rel="stylesheet" href=" {{ asset('css/doctor/utilities/questionnaire.css')}}">
<link rel="stylesheet" href=" {{ asset('css/doctor/utilities/addquestionnaire.css')}}">
    <div id="questionnaire-container" class="questionnaire-container" style="display: block;">
        <div id="qst-cat-btns" class="qst-cat-btns"></div>
        <div id="qst-content" class="qst-content"></div>
        <div id="qst-categories" class="qst-categories"></div>
    </div>
    <div id="add-questionnaire-container" class="add-questionnaire-container" style="display: none;">
        <div class="qcb-header">
            <p>Add Questionnaire</p>
        </div>
        <div id="qst-form" class="qst-form">
            <div id="aqc-title-input"></div>
        </div>
        <div class = "retrieve-btn-container">
            <button onclick="retrieveData()" class="retrieve-btn">Submit</button>
            <p class="check-all-input" id="check-all-input">*Fill out missing information!</p> 
        </div>
    </div>
    <div class = "edit-questionnaire-container" id = "edit-questionnaire-container" style="display: none;">
        <div id="edit-qst-cat-btns" class="edit-qst-cat-btns"></div>
        <div id="edit-qst-content" class="edit-qst-content"></div>
        <div id="edit-qst-categories" class="edit-qst-categories"></div>
    </div>
    <script>
        let doctorQuestions = @json($doctorData);
        const questionsKeys =  Object.keys(doctorQuestions.questions);
        const questionTemplates = doctorQuestions.templates;
        
        const questionContents = document.getElementById('qst-content');
        const questionSubCategories = document.getElementById('qst-categories');

        const qstDiv = document.getElementById("questionnaire-container");
        const addQstDiv = document.getElementById('add-questionnaire-container');
        const editQstDiv = document.getElementById('edit-questionnaire-container');

        const questionButtons = document.getElementById('qst-cat-btns');

        let editable = false;

        function getQuestionnaires(){
                document.getElementById('questionnaire-container').style.display = "block";
                document.getElementById('add-questionnaire-container').style.display = "none";
                document.getElementById('edit-questionnaire-container').style.display = "none";
                let addTab = document.getElementById('add-qst-tab');
                let editTab = document.getElementById('edit-qst-tab');
                    addTab.style.display = 'block'; 
                    editTab.style.display = 'block';
                    setTimeout(() => {
                        addTab.classList.add('show'); 
                        editTab.classList.add('show');
                    }, 10); 

                    editable = false;
            }

        function specBtns(buttonContainer){

            questionsKeys.forEach((key, index) => {
                const button = document.createElement("button");
                button.textContent = key;
                button.classList.add('qst-btns');
                button.addEventListener("click", () => displayQuestionTitle(key));

                buttonContainer.appendChild(button);

                if(index === 0){
                    button.click();
                }
            });
        }

        specBtns(questionButtons);
        

        function displayQuestionTitle(titleKey) {

            const title = doctorQuestions.questions[titleKey];

            ChosenData = title;
            if(editable === false){
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
        else{
            const editQuestContent = document.getElementById('edit-qst-content');
            const editQuestCategory = document.getElementById('edit-qst-categories');

            editQuestContent.innerHTML = "";
            editQuestCategory.innerHTML= "";

            Object.keys(title).forEach(questionnaireTitle => {
                const header = document.createElement("div");
                header.style.display = "flex";
                const titleText = document.createElement("p");
                titleText.textContent = questionnaireTitle;
                header.appendChild(titleText);

                const chooseTemplate = document.createElement("select");
                const templateDefault = document.createElement("option");
                templateDefault.textContent = "Choose Template";
                templateDefault.selected = true;
                chooseTemplate.appendChild(templateDefault);

                const templateContent = questionTemplates[questionnaireTitle];

                Object.keys(templateContent).forEach(templateKeys => {
                    const templateOptions = document.createElement("option");
                    templateOptions.textContent = templateKeys;
                    templateOptions.value = templateKeys;
                    chooseTemplate.appendChild(templateOptions);
                })
               
                const activateBtn = document.createElement("button");
                activateBtn.textContent = "Use Template";

                chooseTemplate.appendChild(templateDefault);

                header.appendChild(chooseTemplate);
                header.appendChild(activateBtn);
                editQuestContent.appendChild(header);

                    const categories = title[questionnaireTitle];
                    Object.keys(categories).forEach(categoryKeys => {

                        const questions = categories[categoryKeys];
                        Object.keys(questions).forEach(questionKeys => {
                            const questionData =  questions[questionKeys];
                            addCategoryset(editQuestCategory, categoryKeys, questionData.question, questionData.legend, questionData.value);
                        })
                    })
            });


        }
            
    }
    </script>
    @include('doctor.utilities.addQuestionnaire')
    @include('doctor.utilities.editQuestionnaire')
