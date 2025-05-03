

<div class="view-questionnaire-container" id="view-questionnaire-container" style="display: none;">
    <div class="view-qst-cat-btns" id="view-qst-cat-btns"></div>
    <div class="view-qst-content" id="view-qst-content"></div>
    <div class="view-qst-categories" id="view-qst-categories"></div>
</div>

<script>

    function getViewQuestionnaires(){
        document.getElementById('view-questionnaire-container').style.display = "block";
        document.getElementById('questionnaire-container').style.display = "none";
        document.getElementById('add-questionnaire-container').style.display = "none";
        document.getElementById('edit-questionnaire-container').style.display = "none";
        document.getElementById('get-started-container').style.display = "none";
        document.getElementById('cred-container').style.display = "none";
        document.getElementById('about-me-container').style.display = "none";

        let buttonHeaders = document.getElementById('view-qst-cat-btns');

        buttonHeaders.innerHTML = "";
        specBtns(buttonHeaders);

        editable = 2;
    }

    function loadQuestionnaireOverview(title, questionContents, questionSubCategories){
                Object.keys(title).forEach(subCat => {
                    const categories = document.createElement("p");
                    categories.textContent = subCat;
                    categories.classList.add('cat-header');
                    questionSubCategories.appendChild(categories);
                    
                    const questionHeaders = title[subCat];

                    Object.keys(questionHeaders).forEach(quest => {
                        const questionData = questionHeaders[quest];
                        const questionContainer = document.createElement("div");
                            const questionText = document.createElement("p");
                            questionText.textContent = `${questionData.question}`;
                            questionContainer.appendChild(questionText);
                            questionContainer.classList.add('questionData-container');
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
          
    }
</script>