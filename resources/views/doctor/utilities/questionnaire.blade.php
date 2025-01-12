<link rel="stylesheet" href=" {{ asset('css/doctor/utilities/questionnaire.css')}}">
    <div id="questionnaire-container" class="questionnaire-container" style="display: none;">
       <div id="qst-cat-btns" class="qst-cat-btns"></div>
       <div id="qst-content" class="qst-content"></div>
       <div id="qst-categories" class="qst-categories"></div>
    </div>
    <div id="add-questionnaire-container" class="add-questionnaire-container" style="display: block;">
        <form id="qst-form">
            <div id="aqc-dropdown" class = "aqc-dropdown"></div>
            <div id="aqc-title-input"></div>
            <div id="aqc-category-input"></div>
            <div id="aqc-question-input"></div>
            <div id="aqc-question-choice-input"></div>
        </form>

        <button onclick="retrieveData()">test</button>
    </div>
    <script>
        let doctorQuestions = @json($doctorData);
        let ChosenData;
        const questionsKeys =  Object.keys(doctorQuestions.questions);
        const questionTemplates = Object.keys(doctorQuestions.templates);
        
        const questionButtons = document.getElementById('qst-cat-btns');
        const questionContents = document.getElementById('qst-content');
        const questionSubCategories = document.getElementById('qst-categories');
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

       function AddDataSet(){
        document.getElementById("questionnaire-container").style.display = 'none';
        document.getElementById('add-questionnaire-container').style.display = 'block';
        
        const container = document.getElementById("aqc-dropdown");
        const container2 = document.getElementById("aqc-title-input");
        const container3 = document.getElementById("aqc-category-input");
        const container4 = document.getElementById("aqc-question-input");
        const container5 = document.getElementById("aqc-question-choice-input");

        container.innerHTML = " ";
        container2.innerHTML = " ";
        container3.innerHTML = " ";
        container4.innerHTML = " ";
        container5.innerHTML = " ";

        let selectSpec = document.createElement("select");
        let specOptions = doctorQuestions.templates;

        Object.keys(specOptions).forEach(spec => {
            const options = document.createElement("option");
            options.value = spec;
            options.textContent = spec;
            selectSpec.appendChild(options);
        })
       
        questionTitle = document.createElement("input");
        questionTitle.setAttribute("name", "questionTitle");
        questionTitle.setAttribute("placeholder", "Enter Title");
        questionTitle.id = "qst-title";

        questionCategory = document.createElement("input");
        questionCategory.setAttribute("name", "questionCategory");
        questionCategory.setAttribute("placeholder", "Enter Category");
        questionCategory.id = "qst-category";

        questionText = document.createElement("input");
        questionText.setAttribute("name", "questionText");
        questionText.setAttribute("placeholder", "Enter Question");
        questionText.id = "qst-question";

        let choiceOptions = ["Choice 1", "Choice 2", "Choice 3", "Choice 4"];
        let choiceValues = ["Value 1", "Value 2", "Value 3", "Value 4"];

        choiceOptions.forEach((opt,index) => {
            const div = document.createElement("div");
            div.style.display = "flex";

            const choiceInput = document.createElement("input");
            choiceInput.setAttribute("placeholder", opt);

            const valueInput = document.createElement("input");
            valueInput.setAttribute("placeholder", choiceValues[index]);

            div.appendChild(choiceInput);
            div.appendChild(valueInput);
            container5.appendChild(div);
        })

        addQuestButton = document.createElement("button");
        addQuestButton.setAttribute("type", "button");
        addQuestButton.textContent = "Add Questions";

        addCategoryButton = document.createElement("button");
        addCategoryButton.setAttribute("type", "button");
        addCategoryButton.textContent = "Add Category";

        container.appendChild(selectSpec);
        container2.appendChild(questionTitle);
        container3.appendChild(questionCategory);
        container3.appendChild(addCategoryButton);
        container4.appendChild(questionText);
        container4.appendChild(addQuestButton);

        addQuestButton.addEventListener("click", function() {
            addQuestionSet();
        })

        addCategoryButton.addEventListener("click", function() {
            addCategoryset();
        })
       }

        function addQuestionSet() {
            const formdiv = document.getElementById("qst-form");

            const qstcontainer = document.createElement("div");
            qstcontainer.id = "aqc-question-input";
            const qstinput = document.createElement("div");
            qstinput.id = "aqc-question-choice-input";

            questionText = document.createElement("input");
            questionText.setAttribute("name", "questionText");
            questionText.setAttribute("placeholder", "Enter Question");       
            questionText.id = "qst-question";


            addQuestButton = document.createElement("button");
            addQuestButton.setAttribute("type", "button");
            addQuestButton.textContent = "Add Questions";

            addQuestButton.addEventListener("click", function() {
            addQuestionSet();
            })

            qstcontainer.appendChild(questionText);
            qstcontainer.appendChild(addQuestButton);

            let choiceOptions = ["Choice 1", "Choice 2", "Choice 3", "Choice 4"];
            let choiceValues = ["Value 1", "Value 2", "Value 3", "Value 4"];

            choiceOptions.forEach((opt,index) => {
                const div = document.createElement("div");
                div.style.display = "flex";

                const choiceInput = document.createElement("input");
                choiceInput.setAttribute("placeholder", opt);

                const valueInput = document.createElement("input");
                valueInput.setAttribute("placeholder", choiceValues[index]);

                div.appendChild(choiceInput);
                div.appendChild(valueInput);
                qstinput.appendChild(div);
            });

            formdiv.appendChild(qstcontainer);
            formdiv.appendChild(qstinput);

        }

        function addCategoryset() {
            const formdiv = document.getElementById("qst-form");

            const categoryContainer = document.createElement("div");
            categoryContainer.id = "aqc-category-input";

            questionCategory = document.createElement("input");
            questionCategory.setAttribute("name", "questionCategory");
            questionCategory.setAttribute("placeholder", "Enter Category");
            questionCategory.id = "qst-category";

            addCategoryButton = document.createElement("button");
            addCategoryButton.setAttribute("type", "button");
            addCategoryButton.textContent = "Add Category";

            categoryContainer.appendChild(questionCategory);
            categoryContainer.appendChild(addCategoryButton);

            formdiv.appendChild(categoryContainer);

            addCategoryButton.addEventListener("click", function() {
            addCategoryset();
        })
        addQuestionSet();
        }
        
        function retrieveData(){
            let selectedSpec = document.querySelector('#aqc-dropdown select').value;
            console.log(selectedSpec);
            console.log(document.getElementById("qst-title").value);
            console.log(document.getElementById("qst-category").value);

            let category = document.querySelectorAll()
        }
        
    </script>