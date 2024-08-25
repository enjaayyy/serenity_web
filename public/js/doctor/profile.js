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

            function addquestion(){
                const list = document.getElementById('qst-item');
                const index = list.children.length;
                const newQstData = document.createElement('div');

                newQstData.className = 'qst-item';
                newQstData.setAttribute('data-index', index);

                newQstData.innerHTML = `
            <textarea name="questions[${index}]" placeholder="Enter question here..."></textarea>
            <button type="button" onclick="removeQuestion(this)">Remove</button>
            `;

                list.appendChild(newQstData);
            }

            function removequestion(button){
                const item = button.parentElement;
                item.remove();
                updateQuestionIndex();
            }

            function updateQuestionIndex(){
                const list = document.getElementById('qst-item');
                   Array.from(list.children).forEach((item, index) => {
                        item.setAttribute('data-index', index);
                        item.querySelector('textarea').setAttribute('name', `questions[${index}]`);
             });
    
            }

    function addGraduate() {
    const button = document.getElementById('grad-btn');

    const form = document.createElement('form');
    form.action = "{{ route('addGraduate') }}";
    form.method = "POST";

    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';

    const textarea = document.createElement('textarea');
    textarea.placeholder = 'Enter school..';
    textarea.name = 'textarea';
    textarea.class = 'grad-textarea';

    const saveBtn = document.createElement('button');
    saveBtn.innerText = 'Save';
    saveBtn.type = 'submit';
    saveBtn.class = 'grad-save-btn';

    button.replaceWith(form);
    form.appendChild(csrfToken);
    form.appendChild(textarea);
    form.appendChild(saveBtn);
}

function addGraduateSecond() {
    const button = document.getElementById('grad-btn2');
    const pElement = document.getElementById('grad-text');

    const form = document.createElement('form');
    form.action = "{{ route('addGraduate') }}";
    form.method = "POST";

    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';

    const textarea = document.createElement('textarea');
    textarea.placeholder = 'Enter updated school...';
    textarea.name = 'textarea';
    textarea.classList.add('grad-textarea');
    textarea.value = pElement.textContent;

    const saveBtn = document.createElement('button');
    saveBtn.innerText = 'Save';
    saveBtn.type = 'submit';
    saveBtn.classList.add('grad-save-btn');

    form.appendChild(csrfToken);
    form.appendChild(textarea);
    form.appendChild(saveBtn);

    if (pElement) {
        pElement.replaceWith(form);
    } else {
        button.replaceWith(form);
    }
}
