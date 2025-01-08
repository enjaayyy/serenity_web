 <div id="questionnaire-container" class="questionnaire-container" style="display: block;">
       <div id="qst-cat-btns" class="qst-cat-btns"></div>
       <div id="qst-content" class="qst-content"></div>
       <div id="qst-categories" class="qst-categories">
       </div>
       <div id="qqqq"></div>
        <script>
            var doctorQuestions = @json($doctorData);
            const questionsKeys =  Object.keys(doctorQuestions.questions);

            const questionButtons = document.getElementById('qst-cat-btns');
            const questionContents = document.getElementById('qst-content');
            const questionSubCategories = document.getElementById('qst-categories');
            const qqqq = document.getElementById('qqqq');

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
                        questionSubCategories.appendChild(categories);
                        
                        const questionHeaders = subCategories[subCat];
                        Object.keys(questionHeaders).forEach(quest => {
                            const questionData = questionHeaders[quest];

                                const questionText = document.createElement("p");
                                questionText.textContent = `${questionData.question}`;
                                questionSubCategories.appendChild(questionText);

                                const questionLegend = document.createElement("p");
                                questionLegend.textContent = `${questionData.legend} , ${questionData.value}`;
                                questionSubCategories.appendChild(questionLegend);         
                    });
                });
            });

        }
           
        </script>
    </div>
    <style>

        .questionnaire-container{
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }
        .qst-cat-btns{
            margin-top:2vh;
            text-align: center;
            display: flex;
        }

        .qst-cat-btns button{
            width: 100%;
            height: 7vh;
            border: none;
            transition: background-color 0.5s ease;
        }

        .qst-cat-btns button:hover{
            background-color: #49B2FF;
            color: white;
        }

        .qst-header{
            font-weight: bold;
            font-size: 2vw;
        }

        .qst-content, 
        .qst-categories{
            margin-left: 2vw;
            margin-right: 2vw;
        }

        
        
    </style>