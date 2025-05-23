<link rel="stylesheet" href=" {{ asset('css/doctor/utilities/questionnaire.css')}}">
<link rel="stylesheet" href=" {{ asset('css/doctor/utilities/addquestionnaire.css')}}">
    <div id="questionnaire-container" class="questionnaire-container" style="display: block;">
        <div id="qst-cat-btns" class="qst-cat-btns"></div>
        <div id="qst-content" class="qst-content"></div>
        <div id="qst-categories" class="qst-categories"></div>
        <div id="qst-scores" class="qst-scores"></div>
    </div>
    <div id="add-questionnaire-container" class="add-questionnaire-container" style="display: none;">
            <div class="qcb-header">
                <p>Add Questionnaire</p>
            </div>
            <div id="qst-form" class="qst-form">
                <div id="aqc-title-input"></div>
            </div>
            <div class = "retrieve-btn-container">
                <button type="button" onclick="retrieveData()" class="retrieve-btn">Submit</button>
                <p class="check-all-input" id="check-all-input">*Fill out missing information!</p> 
            </div>
            {{-- <div class="score-index-container">
                <p class="score-index-header">Scoring Index</p>
                <div class="index-container">
                    <p>mild => </p>
                    <input type="number" >
                </div>
            </div> --}}
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
        const doctorScores = doctorQuestions.activeScore;

        const status = document.getElementById('status');
        
        const questionContents = document.getElementById('qst-content');
        const questionSubCategories = document.getElementById('qst-categories');

        const qstDiv = document.getElementById("questionnaire-container");
        const addQstDiv = document.getElementById('add-questionnaire-container');
        const editQstDiv = document.getElementById('edit-questionnaire-container');
        const qstscores = document.getElementById('qst-scores');
        const viewscores = document.getElementById('view-qst-scores');

        const questionButtons = document.getElementById('qst-cat-btns');

        let editable = false;
        function getQuestionnaires(){
                document.getElementById('questionnaire-container').style.display = "block";
                document.getElementById('add-questionnaire-container').style.display = "none";
                document.getElementById('edit-questionnaire-container').style.display = "none";
                document.getElementById('view-questionnaire-container').style.display = "none";



                let addTab = document.getElementById('add-qst-tab');
                let editTab = document.getElementById('edit-qst-tab');
                let viewTab = document.getElementById('view-qst-tab');
                    addTab.style.display = 'block'; 
                    editTab.style.display = 'block';
                    viewTab.style.display = 'block'
                    setTimeout(() => {
                        addTab.classList.add('show'); 
                        editTab.classList.add('show');
                        viewTab.classList.add('show');
                    }, 10); 

                    editable = false;
                    status.value = " ";
                    status.value = editable;
                    status.textContent = editable;
            }

        function specBtns(buttonContainer){

            questionsKeys.forEach((key, index) => {
                
                const button = document.createElement("button");
                button.textContent = key;
                button.classList.add('qst-btns');

                button.addEventListener("click", () => {
                    displayQuestionTitle(key);

                    let activeSpecTab = document.getElementById("activeSpecTab");
                        if(!activeSpecTab){
                            activeSpecTab = document.createElement("p");
                            activeSpecTab.hidden = true;
                            activeSpecTab.id = "activeSpecTab";
                            buttonContainer.appendChild(activeSpecTab);
                        }
                        activeSpecTab.value = key;
                        activeSpecTab.textContent = key;
                        
                });

                buttonContainer.appendChild(button);
                if(index === 0){
                    button.click();
                }
            });

            const btns = document.querySelectorAll(".qst-btns");
            btns.forEach(button => {
            button.addEventListener('click', () =>{
                btns.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
            });
        });
        }

         

        specBtns(questionButtons);
        
        

        function displayQuestionTitle(titleKey) {

            const title = doctorQuestions.questions[titleKey];
            const titleView = doctorQuestions.templates[titleKey];
            const scoreView = doctorQuestions.activeScore[titleKey];
            
            ChosenData = title;
            if(editable === false){

            questionContents.innerHTML = " ";
            questionSubCategories.innerHTML = " ";
            qstscores.innerHTML = " ";

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
            const scoreTitle = document.createElement('p');
            scoreTitle.textContent = "Scoring Index";
            scoreTitle.classList.add('scoring-index');

            qstscores.appendChild(scoreTitle);

            Object.keys(scoreView).forEach(scores => {
                const scoreData = scoreView[scores];
                Object.entries(scoreData).forEach(([level, value]) => {
                    if(level !== "score-flow"){
                        const p = document.createElement('p');
                        p.textContent = `${level} => ${value}`;
                        p.classList.add('scoring-data');
                        qstscores.appendChild(p);
                    }
                    else{
                        const flow = document.createElement('p');
                        flow.textContent = `${level} => ${value}`;
                        flow.classList.add('scoring-data');

                        qstscores.appendChild(flow);
                    }
                })
            })
        }
        else if(editable === true){
            const editQuestContent = document.getElementById('edit-qst-content');
            const editQuestCategory = document.getElementById('edit-qst-categories');

            
            editQuestContent.innerHTML = "";
            editQuestCategory.innerHTML= "";

            const header = document.createElement("div");
                Object.keys(title).forEach(questionnaireTitle => {
                    const header = document.createElement("div");
                    header.style.display = "flex";
                    
                    const p = document.createElement("p");
                    p.textContent = "Title";
                    p.classList.add("categoryheader");

                    const chooseTemplate = document.createElement("select");
                    const templateDefault = document.createElement("option");
                    templateDefault.textContent = questionnaireTitle;
                    templateDefault.value = questionnaireTitle;
                    templateDefault.selected = true;
                    chooseTemplate.id = "aqc-dropdown-2";
                    chooseTemplate.classList.add("aqc-dropdown-2");
                    chooseTemplate.appendChild(templateDefault);

                    const templateContent = questionTemplates[titleKey];

                    Object.keys(templateContent).forEach(templateKeys => {
                        const templateOptions = document.createElement("option");
                        templateOptions.textContent = templateKeys;
                        templateOptions.value = templateKeys;
                        chooseTemplate.appendChild(templateOptions);

                    })

                    chooseTemplate.appendChild(templateDefault);
                    header.appendChild(chooseTemplate);

                    const activateBtn = document.createElement("button");
                                activateBtn.textContent = "Use Template";
                                activateBtn.id = "activate-button";
                                activateBtn.classList.add("activate-button");
                                activateBtn.onclick = function (){
                                retrieveData();
                                }
                                header.appendChild(activateBtn);

                    editQuestContent.appendChild(p);
                    editQuestContent.appendChild(header);


                    chooseTemplate.addEventListener("change", function(){
                        if(chooseTemplate.value == templateDefault.value){
                            editQuestCategory.innerHTML= "";
                            resetCounters();
                            chosenTemplate = chosenSpec;
                            loadtemplates(title,questionnaireTitle,editQuestCategory);
                        }
                        else{
                            resetCounters();
                            Object.keys(templateContent).forEach(templatesKey => {
                                if(chooseTemplate.value == templatesKey){
                                    editQuestCategory.innerHTML= "";
                                    chosenSpec = templatesKey;
                                    chosenTemplate = templatesKey; 
                                    loadtemplates(templateContent,templatesKey,editQuestCategory);
                                }
                            })
                        }       
                       
                        });

                        loadtemplates(title,questionnaireTitle,editQuestCategory);
                    
            });
        }
        else{
            const viewQuestContent = document.getElementById('view-qst-content');
            const viewQuestCategory = document.getElementById('view-qst-categories');

            viewQuestContent.innerHTML = " ";

            const header = document.createElement("div");
                Object.keys(title).forEach(questionnaireTitle => {
                    const p = document.createElement("p");
                    p.textContent = "Title";
                    p.classList.add("cat-header");


                    const chooseTemplate = document.createElement("select");
                    const templateDefault = document.createElement("option");
                    templateDefault.textContent = questionnaireTitle;
                    templateDefault.value = questionnaireTitle;
                    templateDefault.selected = true;
                    chooseTemplate.id = "aqc-dropdown-3";
                    chooseTemplate.classList.add("aqc-dropdown-2");
                    chooseTemplate.appendChild(templateDefault);

                    const templateContent = questionTemplates[titleKey];
                    Object.keys(templateContent).forEach(templateKeys => {
                        const templateOptions = document.createElement("option");
                        templateOptions.textContent = templateKeys;
                        templateOptions.value = templateKeys;
                        chooseTemplate.appendChild(templateOptions);

                    })


                    chooseTemplate.appendChild(templateDefault);
                    header.appendChild(p);
                    header.appendChild(chooseTemplate);

                    viewQuestContent.appendChild(header);
                    
                    loadQuestionnaireOverview(templateContent[chooseTemplate.value], viewQuestContent, viewQuestCategory);


                    chooseTemplate.addEventListener("change", function(){
                        viewQuestCategory.innerHTML= "";
                        loadQuestionnaireOverview(templateContent[chooseTemplate.value], viewQuestContent, viewQuestCategory);
                        });

                    
            });

        }
       
    }
    </script>
    @include('doctor.utilities.addQuestionnaire')
    @include('doctor.utilities.editQuestionnaire')
    @include('doctor.utilities.viewquestionnaires')
