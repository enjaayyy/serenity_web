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
    <script>
        let doctorQuestions = @json($doctorData);
        const questionsKeys =  Object.keys(doctorQuestions.questions);
        const questionTemplates = doctorQuestions.templates;
        
        const questionButtons = document.getElementById('qst-cat-btns');
        const questionContents = document.getElementById('qst-content');
        const questionSubCategories = document.getElementById('qst-categories');

        const qstDiv = document.getElementById("questionnaire-container");
        const addQstDiv = document.getElementById('add-questionnaire-container');
        
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
    </script>
    @include('doctor.utilities.addQuestionnaire')
    @include('doctor.utilities.editQuestionnaire')
