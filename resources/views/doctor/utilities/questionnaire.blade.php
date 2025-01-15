<link rel="stylesheet" href=" {{ asset('css/doctor/utilities/questionnaire.css')}}">
    <div id="questionnaire-container" class="questionnaire-container" style="display: none;">
       <div id="qst-cat-btns" class="qst-cat-btns"></div>
       <div id="qst-content" class="qst-content"></div>
       <div id="qst-categories" class="qst-categories"></div>
    </div>
    <div id="add-questionnaire-container" class="add-questionnaire-container" style="display: block;">
        <form id="qst-form" method="POST" action="{{ route('addQuestionnaire') }} ">
            @csrf
            <div id="aqc-title-input"></div>
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
        
        const formcontainer = document.getElementById("qst-form");

        const dropdown = document.createElement("div");
        dropdown.id = "aqc-dropdown";

        
        let selectSpec = document.createElement("select");
        selectSpec.name = "aqc-dropdown";
        
        let specOptions = doctorQuestions.templates;

        Object.keys(specOptions).forEach(spec => {
            const options = document.createElement("option");
            options.value = spec;
            options.textContent = spec;
            selectSpec.appendChild(options);
        })

        dropdown.appendChild(selectSpec);
        formcontainer.appendChild(dropdown);

        questionTitle = document.createElement("input");
        questionTitle.setAttribute("name", "questionTitle");
        questionTitle.setAttribute("placeholder", "Enter Title");
        questionTitle.id = "qst-title";
        formcontainer.appendChild(questionTitle);
        

        addCategoryset(formcontainer);

        const submitBtn = document.createElement("button");
        submitBtn.setAttribute("type", "submit");
        submitBtn.textContent = "submit";

        formcontainer.appendChild(submitBtn);

       }

        function addQuestionSet(parent) {

            const qstcontainer = document.createElement("div");
            qstcontainer.id = "aqc-question-input";
            const qstinput = document.createElement("div");
            qstinput.id = "aqc-question-choice-input";
            qstinput.classList.add('aqc-question-choice-input');

            questionText = document.createElement("input");
            questionText.setAttribute("name", "questionText");
            questionText.setAttribute("placeholder", "Enter Question");       
            questionText.id = "qst-question";


            addQuestButton = document.createElement("button");
            addQuestButton.setAttribute("type", "button");
            addQuestButton.textContent = "Add Questions";

            qstcontainer.appendChild(questionText);
            qstcontainer.appendChild(addQuestButton);

            let choiceOptions = ["Choice 1", "Choice 2", "Choice 3", "Choice 4"];
            let choiceValues = ["Value 1", "Value 2", "Value 3", "Value 4"];

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

            parent.appendChild(qstcontainer);
            
            addQuestButton.addEventListener("click", function() {
            addQuestionSet(parent);
            })
        }

        function addCategoryset(parentCat) {
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

            addQuestionSet(categoryContainer);
            
            parentCat.appendChild(categoryContainer);

            addCategoryButton.addEventListener("click", function() {
            addCategoryset(parentCat);
            })
        }
        
        function retrieveData(){
            let selectedSpec = document.querySelector('#aqc-dropdown select').value;
            console.log(selectedSpec);
            let title = document.getElementById("qst-title").value;
            
            let mainObj = {};

            mainObj[title] = {};

            let categories = document.querySelectorAll("#qst-form #aqc-category-input input[name='questionCategory']");
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
            console.log(mainObj);
            console.log(doctorQuestions.templates);
        }
        
    </script>