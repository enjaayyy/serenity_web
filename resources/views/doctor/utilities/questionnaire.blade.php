 <link rel="stylesheet" href=" {{ asset('css/doctor/utilities/questionnaire.css')}}">
 <div id="questionnaire-container" class="questionnaire-container" style="display: none;">
       <div id="qst-cat-btns" class="qst-cat-btns"></div>
       <div id="qst-content" class="qst-content"></div>
       <div id="qst-categories" class="qst-categories">

       </div>
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
    </div>
   