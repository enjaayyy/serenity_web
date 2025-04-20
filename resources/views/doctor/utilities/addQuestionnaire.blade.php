<script>
    let chosenSpec = " ";
    let chosenTemplate = " ";
       function AddDataSet(){
        qstDiv.style.display = "none";
        addQstDiv.style.display = "block";
        editQstDiv.style.display = "none";
        document.getElementById('view-questionnaire-container').style.display = "none";


        editable = false;

        status.value = " ";
        status.value = editable;
        status.textContent = editable;

        document.getElementById("edit-qst-categories").innerHTML = " ";
        const formcontainer = document.getElementById("qst-form");
        formcontainer.innerHTML = " ";
        const dropdown = document.createElement("div");
        dropdown.id = "aqc-dropdown";
        const dropdownheader = document.createElement("p");
        dropdownheader.textContent = "Specialization";
        dropdownheader.classList.add("dropdown-header");

        const dropwdownbox = document.createElement("div");
        dropwdownbox.classList.add("dropdownBox");
        dropwdownbox.style.display = "flex";

        let selectSpec = document.createElement("select");
        selectSpec.name = "aqc-dropdown";
        selectSpec.id = "aqc-dropdown";
        selectSpec.classList.add("aqc-dropdown-select");
        let defaultOpt = document.createElement("option");
        defaultOpt.textContent = "Choose a Specialization";
        defaultOpt.selected = true;
        selectSpec.appendChild(defaultOpt);

        let specOptions = doctorQuestions.templates;

        let specVerify = document.createElement("p");
        specVerify.classList.add("check-spec-input");
        specVerify.textContent = "*please choose a specialization";
        specVerify.style.display = "none";
        specVerify.id = "check-spec-input";

        Object.keys(specOptions).forEach(spec => {  
            const options = document.createElement("option");
            options.value = spec;
            options.textContent = spec;
            selectSpec.appendChild(options);
        })

        selectSpec.addEventListener("change", function() {
            chosenSpec = selectSpec.value;
            specVerify.style.display = "none";
        });

        dropwdownbox.appendChild(selectSpec);
        dropwdownbox.appendChild(specVerify);

        dropdown.appendChild(dropdownheader);
        dropdown.appendChild(dropwdownbox);
        formcontainer.appendChild(dropdown);

        const titleDiv = document.createElement("div");
        titleDiv.id = "title-container";
        titleDiv.name = "title-container";
        titleDiv.classList.add("title-container");

        const questionHeaderBox = document.createElement("div");
        questionHeaderBox.classList.add("question-HeaderBox");

        const questionHeader = document.createElement("p");
        questionHeader.classList.add("question-header");
        questionHeader.textContent = "Questionnaire Title";

        questionHeaderBox.appendChild(questionHeader);

        questionTitle = document.createElement("input");
        questionTitle.setAttribute("name", "questionTitle");
        questionTitle.setAttribute("placeholder", "Enter Title");
        questionTitle.setAttribute("autocomplete", "off");
        questionTitle.classList.add("questionTitle-input");
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
            qstcontainer.classList.add("aqc-question-input");
            
            const mainQuestionContainer = document.createElement("div");
            mainQuestionContainer.classList.add("mainQuestionContainer");
            mainQuestionContainer.style.display = "flex";

            const qstinput = document.createElement("div");
            qstinput.id = "aqc-question-choice-input";
            qstinput.classList.add('aqc-question-choice-input');

            qstinputheader = document.createElement("p");
            qstinputheader.classList.add("questinputheader");
            qstinputheader.textContent = "Add Question";

            qstcontainer.appendChild(qstinputheader);

            questionText = document.createElement("input");
            questionText.setAttribute("name", "questionText");
            questionText.setAttribute("placeholder", "Enter Question");  
            questionText.setAttribute("autocomplete", "off");  
            questionText.classList.add("questionText-input"); 
                
            questionText.id = "qst-question";
            if(templateQuestion){
                questionText.value = templateQuestion;
            }

            const addImg = document.createElement('img');
            addImg.src = "{{ asset('assets/plus-icon.svg') }}";
            addImg.classList.add("add-img");

            addQuestButton = document.createElement("button");
            addQuestButton.setAttribute("type", "button");
            addQuestButton.classList.add("add-btn");
            addQuestButton.appendChild(addImg);

            const removeImg = document.createElement('img');
            removeImg.src = "{{ asset('assets/remove-icon.svg') }}";
            removeImg.classList.add("remove-img");

            removequestion = document.createElement("button");
            removequestion.classList.add("remove-btn");
            removequestion.appendChild(removeImg);
            removequestion.onclick = function (){
                    removeData(questID);
            }
            mainQuestionContainer.appendChild(questionText);
            mainQuestionContainer.appendChild(addQuestButton);
            mainQuestionContainer.appendChild(removequestion);
            qstcontainer.appendChild(mainQuestionContainer);

            let choiceOptions = ["Choice 1", "Choice 2", "Choice 3", "Choice 4", "Choice 5"];
            let choiceValues = ["Value 1", "Value 2", "Value 3", "Value 4", "Value 5"];

            if(legend && value){
                legend.forEach((lkey, index) => {
                    const div = document.createElement("div");
                    div.style.display = "flex";

                    const legendInput = document.createElement("input");
                    legendInput.value = lkey;
                    legendInput.setAttribute("name", "choiceInput");
                    legendInput.classList.add("choiceInput");
                    
                    const valueInput = document.createElement("input");
                    valueInput.value = value[index];
                    valueInput.setAttribute("name", "choiceValue");
                    valueInput.classList.add("valueInput");

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
                choiceInput.setAttribute("autocomplete", "off");
                choiceInput.classList.add("choiceInput");

                const valueInput = document.createElement("input");
                valueInput.setAttribute("placeholder", choiceValues[index]);
                valueInput.setAttribute("name", "choiceValue");
                valueInput.setAttribute("autocomplete", "off");
                valueInput.classList.add("valueInput");

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

            const subcategoryHeader = document.createElement("div");
            subcategoryHeader.style.display="flex";

            categoryheader = document.createElement("p");
            categoryheader.classList.add("categoryheader");
            categoryheader.textContent = "Add Category";

            categoryContainer.appendChild(categoryheader);

            questionCategory = document.createElement("input");
            questionCategory.setAttribute("name", "questionCategory");
            questionCategory.setAttribute("placeholder", "Enter Category");
            questionCategory.setAttribute("autocomplete", "off");  
            questionCategory.classList.add("questionCategory-input");
            questionCategory.id = "qst-category";
            if(templateData){
                questionCategory.value = templateData;
            }

            const addImg = document.createElement('img');
            addImg.src = "{{ asset('assets/plus-icon.svg') }}";
            addImg.classList.add("add-img");

            addCategoryButton = document.createElement("button");
            addCategoryButton.setAttribute("type", "button");
            addCategoryButton.classList.add("add-btn");
            addCategoryButton.appendChild(addImg);

            const removeImg = document.createElement('img');
            removeImg.src = "{{ asset('assets/remove-icon.svg') }}";
            removeImg.classList.add("remove-img");

            removeCategory = document.createElement("button");
            removeCategory.classList.add("remove-btn");
            removeCategory.appendChild(removeImg);
            removeCategory.onclick = function () {
                removeData(categoryID);
            }
            
            subcategoryHeader.appendChild(questionCategory);
            subcategoryHeader.appendChild(addCategoryButton);
            subcategoryHeader.appendChild(removeCategory);
            
            categoryContainer.appendChild(subcategoryHeader);

            parentCat.appendChild(categoryContainer);
            
            if(editable == false){
            addQuestionSet(categoryContainer, templateQuestion, legend, value);
            addTemplate(categoryContainer);
            }
            
         
            addCategoryButton.addEventListener("click", function() {
            addCategoryset(parentCat);
            });
        }

        let tmpbtn = 0;

        function addTemplate(parentDiv){
            if(editable == false){
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
            templateDiv.classList.add("templateDiv");

            const tempButton = document.createElement("button");
            tempButton.textContent = "Select Template";
            tempButton.id = tempaddBtn;
            tempButton.style.display = "block";
            tempButton.classList.add("tempButton");
            

            const saveBtn = document.createElement("button");
            saveBtn.textContent = "Add Template";
            saveBtn.id = tempsaveBtn;
            saveBtn.style.display = "none";
            saveBtn.classList.add("saveBtn");

            templateDiv.appendChild(tempButton);
            templateDiv.appendChild(saveBtn);

           
                tempButton.addEventListener("click", function () {
                
                if(chosenSpec != " " && chosenSpec != "Choose a Specialization"){
                    document.getElementById(tempaddBtn).style.display = "none";
                document.getElementById(tempsaveBtn).style.display = "block";
                
                const tempDataDiv = document.createElement("div");
                tempDataDiv.classList.add("tempDataDiv");

                const selectTitleText = document.createElement("p");
                    selectTitleText.classList.add("questionHeaderBox");
                    selectTitleText.textContent = "Select Title";
                const selecTemp = document.createElement("select");
                    selecTemp.id = "selecTemp";
                    selecTemp.classList.add("selecTemp");
                    titleChoice = document.createElement("option");
                    titleChoice.textContent = "Choose Title";
                    titleChoice.selected = true;
                    selecTemp.appendChild(titleChoice);


                const selectCategoryText = document.createElement("p");
                    selectCategoryText.classList.add("questionHeaderBox");
                    selectCategoryText.textContent = "Select Category";
                const selectTempQuest = document.createElement("select");
                    selectTempQuest.id = "selectTempQuest";
                    selectTempQuest.classList.add("selectTempQuest");
                    

                const selectquestionText = document.createElement("p");
                    selectquestionText.textContent = "Select Question";
                    selectquestionText.classList.add("questionHeaderBox");
                const selectTempData = document.createElement("select");
                    selectTempData.id = "selectTempData";
                    selectTempData.classList.add("selectTempData");
                    

                const questionText = document.createElement("input");
                    questionText.id = "questionTextTemplate";
                    questionText.classList.add("questionTextTemplate");
                    questionText.disabled = !questionText.disabled;


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
                                catChoice = document.createElement("option");
                                catChoice.textContent = "Choose Category";
                                catChoice.selected = true;
                                selectTempQuest.appendChild(catChoice);
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
                                        questChoice = document.createElement("option");
                                        questChoice.textContent = "Choose Question";
                                        questChoice.selected = true;
                                        selectTempData.appendChild(questChoice);

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
                                                legendText.classList.add("legendText");
                                                legendText.disabled = !legendText.disabled;

                                                const valueText = document.createElement("input");
                                                valueText.value = questTextData.value[index];
                                                valueText.value = lkey;
                                                valueText.classList.add("valueText");
                                                valueText.disabled = !valueText.disabled;


                                                legValDiv.appendChild(legendText);
                                                legValDiv.appendChild(valueText);
                                                legendValue.appendChild(legValDiv);
                                            })
                                    });
                                });
                            });
                
                tempDataDiv.appendChild(selectTitleText);
                tempDataDiv.appendChild(selecTemp);   
                tempDataDiv.appendChild(selectCategoryText);         
                tempDataDiv.appendChild(selectTempQuest); 
                tempDataDiv.appendChild(selectquestionText);           
                tempDataDiv.appendChild(selectTempData);            
                tempDataDiv.appendChild(questionText);            
                tempDataDiv.appendChild(legendValue);  
                templateDiv.appendChild(tempDataDiv);  
                          
                

                saveBtn.addEventListener("click", function(){
                    addCategoryset(parentDiv, templateCategory, templateQuestion, legend, value);
                    templateDiv.innerHTML = " ";
                });
                }
                else{
                    document.getElementById("check-spec-input").style.display = "block";
                    const glowtext = document.getElementById("check-spec-input");
                    erroreffect(glowtext);
                }
                
            });
           

            parentDiv.appendChild(templateDiv);
            }
            else{

            }
            
        }

        function removeData(id){
            const removeData = document.getElementById(id);
            if(removeData){
                removeData.remove();
            }
        }
        
        function retrieveData(){
            if(status.value == false){
                if(document.getElementById("qst-title").value === ""){
                document.getElementById("check-all-input").style.display = "block";
                const glowtext = document.getElementById("check-all-input");
                erroreffect(glowtext);

                }
                else{
                let selectedSpec = document.querySelector('#aqc-dropdown select').value;
                let title = document.getElementById("qst-title").value;
                let mainObj = {};

                mainObj[title] = {};

                let categories = document.querySelectorAll(".qst-form .aqc-category-input");
                categories.forEach((cat,index) => {
                    let categoryName = cat.querySelector("input[name='questionCategory']").value;
                    mainObj[title][categoryName] = {};
                    
                    let questionText = cat.querySelectorAll("input[name='questionText']");
                    questionText.forEach((qst,qindex) => {
                        let questionKey = `Q${qindex+1}`;
                        mainObj[title][categoryName][questionKey] = {
                            legend: [],
                            question: qst.value,
                            value:[]
                        };
                        let choices = qst.closest(".aqc-question-input").querySelectorAll(".aqc-question-choice-input div");
                        choices.forEach((choice, cindex) => {

                            let choiceLegend = choice.querySelector("input[name='choiceInput']").value;
                            mainObj[title][categoryName][questionKey].legend.push(choiceLegend);
                            let choiceValue = choice.querySelector("input[name='choiceValue']").value;
                            mainObj[title][categoryName][questionKey].value.push(choiceValue);
                        });
                    });
                });
                let route = '/doctorProfile/addQuestion';
                openConfirmationModal(mainObj,route,chosenSpec);
                }
            }
            else{
                let selectedTemplate = document.getElementById("aqc-dropdown-2").value;
                let selectedSpec = document.getElementById("activeSpecTab").value;
                let tempObj = {};
                
                tempObj[selectedTemplate] = {};

                let categoryInput = document.querySelectorAll(".edit-qst-categories > div");
                categoryInput.forEach(cat => {
                    let categoryvalue = cat.querySelector("input[name='questionCategory']").value;
                    tempObj[selectedTemplate][categoryvalue] = {};

                    let questionInput =  cat.querySelectorAll(".aqc-question-input");
                    questionInput.forEach((quest, index) => {
                        let questionKey = `Q${index+1}`;

                        let questionText = quest.querySelector("input[name='questionText']").value;

                    tempObj[selectedTemplate][categoryvalue][questionKey] = {
                        legend: [],
                        question: questionText,
                        value: [],
                    };
                        let choices = quest.closest(".aqc-question-input").querySelectorAll(".aqc-question-choice-input div");
                        choices.forEach((choice, cindex) => {

                            let choiceLegend = choice.querySelector("input[name='choiceInput']").value;
                            tempObj[selectedTemplate][categoryvalue][questionKey].legend.push(choiceLegend);
                            let choiceValue = choice.querySelector("input[name='choiceValue']").value;
                            tempObj[selectedTemplate][categoryvalue][questionKey].value.push(choiceValue);
                        });
                    });
                    
                });
                let route = '/doctorProfile/editQuestion';
                openConfirmationModal(tempObj,route,selectedSpec);
            }
        }
        function erroreffect(glowtext){
            glowtext.classList.remove("error-glow");

            void glowtext.offsetWidth;

            glowtext.classList.add("error-glow");

        }

         
</script>
    @include('doctor.utilities.modals')

