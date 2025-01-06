 <div id="questionnaire-container" style="display: block;">
       <div id="qst-cat-btns">
            @foreach($doctorData['questions'] as $category => $subCategory)
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
            @endforeach
       </div>
        <script>
            var doctorQuestions = @json($doctorData);
            const Questions =  doctorQuestions.questions;

            console.log(Questions);
            
        </script>
    </div>