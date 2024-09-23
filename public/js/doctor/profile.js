 
    function uploadcard(){
                document.getElementById('upload-screen').style.display = 'block';
                document.body.style.overflow = 'hidden';
            }

            function closeuploadcard(){
                document.getElementById('upload-screen').style.display = 'none';
                document.body.style.overflow = 'auto';
            }

            function opencredentials(){
                document.getElementById('cred-container').style.display = 'block';
               document.getElementById('abt-container').style.display = 'none';
                document.getElementById('qst-container').style.display = 'none';
            }
            function openquestions(){
                document.getElementById('qst-container').style.display = 'block';
               document.getElementById('abt-container').style.display = 'none';
               document.getElementById('cred-container').style.display = 'none';

            }

            function openaboutme(){
               document.getElementById('abt-container').style.display = 'block';
               document.getElementById('cred-container').style.display = 'none';
               document.getElementById('qst-container').style.display = 'none';
            
            }

                document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('newQuestions').addEventListener('click', function() {
                let questElements = document.querySelectorAll('.qsts-content');
                document.getElementById('newQuestionForm').style.display = 'block';
                document.getElementById('newQuestions').style.display = 'none';



                questElements.forEach(function (element) {
                element.style.display = 'none';
            });
        });

                document.getElementById('addQuest').addEventListener('click', function() {
                const questionCount = document.querySelectorAll('.question-group').length;

                const newQuestionGroup = document.createElement('div');
                newQuestionGroup.classList.add('question-group');
                newQuestionGroup.innerHTML = `
                    <input placeholder="Enter Question" name="question[]" class="question-txt"><br>
                        <div class="val-leg-container">
                            <input placeholder="Enter Legend" name="legend[${questionCount}][]" class="legend-txt">
                            <input placeholder="Enter Value" name="value[${questionCount}][]" class="val-txt"><br>
                            <input placeholder="Enter Legend" name="legend[${questionCount}][]" class="legend-txt">
                            <input placeholder="Enter Value" name="value[${questionCount}][]" class="val-txt"><br>
                            <input placeholder="Enter Legend" name="legend[${questionCount}][]" class="legend-txt">
                            <input placeholder="Enter Value" name="value[${questionCount}][]" class="val-txt"><br>
                            <input placeholder="Enter Legend" name="legend[${questionCount}][]" class="legend-txt">
                            <input placeholder="Enter Value" name="value[${questionCount}][]" class="val-txt"><br>
                            <input placeholder="Enter Legend" name="legend[${questionCount}][]" class="legend-txt">
                            <input placeholder="Enter Value" name="value[${questionCount}][]" class="val-txt">
                        </div>
                        <button type="button" class="remove-question-btn">Remove</button>
                    `;

                document.getElementById('questionContainer').appendChild(newQuestionGroup);

                newQuestionGroup.querySelector('.remove-question-btn').addEventListener('click', function(){
                    this.parentElement.remove();
                });
    });
});

            

                document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('addNewQuestion').addEventListener('click', function() {
                    const questionCount = document.querySelectorAll('.new-questionGroup').length;

                    const newQuestionGroup = document.createElement('div');
                    newQuestionGroup.classList.add('new-questionGroup');
                    newQuestionGroup.innerHTML = `
                        <input placeholder="Enter Question" name="questions[${questionCount}][question]" class="question-txt"><br>
                        <div class="val-leg-container">
                            <input placeholder="Enter Legend" name="questions[${questionCount}][legend][]" class="legend-txt">
                            <input placeholder="Enter Value" name="questions[${questionCount}][value][]" class="val-txt"><br>
                            <input placeholder="Enter Legend" name="questions[${questionCount}][legend][]" class="legend-txt">
                            <input placeholder="Enter Value" name="questions[${questionCount}][value][]" class="val-txt"><br>
                            <input placeholder="Enter Legend" name="questions[${questionCount}][legend][]" class="legend-txt">
                            <input placeholder="Enter Value" name="questions[${questionCount}][value][]" class="val-txt"><br>
                            <input placeholder="Enter Legend" name="questions[${questionCount}][legend][]" class="legend-txt">
                            <input placeholder="Enter Value" name="questions[${questionCount}][value][]" class="val-txt"><br>
                            <input placeholder="Enter Legend" name="questions[${questionCount}][legend][]" class="legend-txt">
                            <input placeholder="Enter Value" name="questions[${questionCount}][value][]" class="val-txt"><br>
                        </div>
                        <button type="button" class="remove-editedquestion-btn">Remove</button>
                    `;

                document.getElementById('newQuestionContainer').appendChild(newQuestionGroup);

                newQuestionGroup.querySelector('.remove-editedquestion-btn').addEventListener('click', function(){
                    this.parentElement.remove();
                });
            });

        document.querySelectorAll('.remove-editedquestion-btn').forEach(button => {
            button.addEventListener('click', function() {
                this.parentElement.remove();
            });
        });

    document.getElementById('Edit').addEventListener('click', function() {
        document.getElementById('default-questions').style.display = "none";
        this.style.display = "none";
        document.getElementById('editedQuestionForm').style.display = "block";
    });
});


                

        