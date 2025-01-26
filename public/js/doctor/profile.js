 
    function uploadcard(){
                document.getElementById('upload-screen').style.display = 'block';
                document.body.style.overflow = 'hidden';
            }

            function closeuploadcard(){
                document.getElementById('upload-screen').style.display = 'none';
                document.body.style.overflow = 'auto';
            }

            function getQuestionnaires(){
                document.getElementById('questionnaire-container').style.opacity = 1;
                document.getElementById('questionnaire-container').style.visibility = "visible";
                document.getElementById('questionnaire-container').style.display = "block";
                document.getElementById('add-questionnaire-container').style.opacity = 0;
                document.getElementById('add-questionnaire-container').style.visibility = "hidden";
                document.getElementById('add-questionnaire-container').style.display = "none";
                let addTab = document.getElementById('add-qst-tab');
                let editTab = document.getElementById('edit-qst-tab');
                    addTab.style.display = 'block'; 
                    editTab.style.display = 'block';
                    setTimeout(() => {
                        addTab.classList.add('show'); 
                        editTab.classList.add('show');
                    }, 10); 

            }

            function getCredentials(){
                document.getElementById('questionnaire-container').style.display = 'none';
                document.getElementById('add-qst-tab').style.display = 'none';
                document.getElementById('edit-qst-tab').style.display = 'none';

            }
              

                

        