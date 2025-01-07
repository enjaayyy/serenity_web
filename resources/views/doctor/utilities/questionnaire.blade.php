 <div id="questionnaire-container" style="display: block;">
       <div id="qst-cat-btns">
            {{-- @foreach($doctorData['questions'] as $category => $subCategory)
                <h2>{{$category}}</h2>
                <ul>
                    @foreach($subCategory as $subCategories => $questions)
                    <li>
                        <strong>{{ $subCategories }}</strong>
                        <ul>
                            @foreach($questions as $key => $questions)
                                <li>
                                    <strong>{{ $key }}</strong> {{ $questions['Q1'] }}
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    @endforeach
                </ul>
            @endforeach --}}
       </div>
       <div id="qst-content"></div>
       <div id="qst-categories">
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
                button.addEventListener("click", () => displayQuestionTitle(key));

                questionButtons.appendChild(button);
            })

            function displayQuestionTitle(titleKey) {

                const title = Object.keys(doctorQuestions.questions[titleKey]);

                questionContents.innerHTML = " ";
                questionSubCategories.innerHTML = " ";
                title.forEach(questionTitle => {
                    const titleText = document.createElement("p");
                    titleText.textContent = questionTitle;
                    questionContents.appendChild(titleText);
                })

                const subCategories = Object.keys(doctorQuestions.questions[titleKey][title]);

                subCategories.forEach(subCat => {
                    const categories = document.createElement("p");
                    categories.textContent = subCat;
                    questionSubCategories.appendChild(categories);
                        
                        const questionHeaders = Object.keys(doctorQuestions.questions[titleKey][title][subCat]);
                        questionHeaders.forEach(quest => {
                            const questheads = document.createElement("p");
                            questheads.textContent = quest;
                            questionSubCategories.appendChild(questheads);
                        })
                });
            }

           
        </script>
    </div>