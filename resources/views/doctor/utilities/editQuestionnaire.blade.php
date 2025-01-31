<script>
    const buttonHeaders = document.getElementById('edit-qst-cat-btns');

    function editQuestionnaire(){
        qstDiv.style.display = "none";
        addQstDiv.style.display = "none";
        editQstDiv.style.display = "block";

        buttonHeaders.innerHTML = "";
        editable = true;
        const buttonChoices = document.getElementById('edit-qst-cat-btns');
        specBtns(buttonChoices);

        
    }
</script>