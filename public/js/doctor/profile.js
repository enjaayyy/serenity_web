 
            function uploadcard(){
                document.getElementById('upload-screen').style.display = 'block';
                document.body.style.overflow = 'hidden';
            }

            function closeuploadcard(){
                document.getElementById('upload-screen').style.display = 'none';
                document.body.style.overflow = 'auto';
            }

            function uploadcred(){
                document.getElementById('upload-cred-screen').style.display = 'block';
                document.body.style.overflow = 'hidden';
            }

            function closeuploadcred(){
                document.getElementById('upload-cred-screen').style.display = 'none';
                document.body.style.overflow = 'auto';
            }

            function getCredentials(){
                document.getElementById('questionnaire-container').style.display = "none";
                document.getElementById('add-qst-tab').style.display = "none";
                document.getElementById('edit-qst-tab').style.display = "none";
                document.getElementById('view-qst-tab').style.display = "none";
                document.getElementById('add-questionnaire-container').style.display = "none";
                document.getElementById('view-questionnaire-container').style.display = "none";
                document.getElementById('edit-questionnaire-container').style.display = "none";
                document.getElementById('cred-container').style.display = "block";
                document.getElementById('get-started-container').style.display = "none";
                document.getElementById('about-me-container').style.display = "none";

            }
            
            function openAboutMe(){
                document.getElementById('questionnaire-container').style.display = "none";
                document.getElementById('add-qst-tab').style.display = "none";
                document.getElementById('edit-qst-tab').style.display = "none";
                document.getElementById('view-qst-tab').style.display = "none";
                document.getElementById('add-questionnaire-container').style.display = "none";
                document.getElementById('edit-questionnaire-container').style.display = "none";
                document.getElementById('view-questionnaire-container').style.display = "none";
                document.getElementById('cred-container').style.display = "none";
                document.getElementById('get-started-container').style.display = "none";
                document.getElementById('about-me-container').style.display = "block";

            }

                

        