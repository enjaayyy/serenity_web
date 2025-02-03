<script>
    const buttonHeaders = document.getElementById('edit-qst-cat-btns');

    function editQuestionnaire(){
        qstDiv.style.display = "none";
        addQstDiv.style.display = "none";
        editQstDiv.style.display = "block";

        buttonHeaders.innerHTML = "";
        editable = true;

        status.value = " ";
        status.value = editable;
        status.textContent = editable;

        const buttonChoices = document.getElementById('edit-qst-cat-btns');
        specBtns(buttonChoices);

    }
   
   function resetCounters(){
        questionCounter = 0;
        categoryCounter = 0;
        tmpbtn = 0;
   }

   function loadtemplates(title,questionnaireTitle,editQuestCategory){
        const categories = title[questionnaireTitle];

            Object.keys(categories).forEach(categoryKeys => {

                const questions = categories[categoryKeys];
                Object.keys(questions).forEach(questionKeys => {
                    const questionData =  questions[questionKeys];
                    addCategoryset(editQuestCategory, categoryKeys, questionData.question, questionData.legend, questionData.value);
                });
        }); 
        }


</script>