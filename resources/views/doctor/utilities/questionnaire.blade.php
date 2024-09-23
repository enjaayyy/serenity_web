<div class="qst-container" id="qst-container" style="display: none;">
    <div id="default-questions">
        <p class = "qst-header">Questionnaire for {{ $doctorData['spec'] }} Patients</p>
            <p id="qst-title">{{ $doctorData['title'] }}</p>
        @if(isset($doctorData['questions']) && is_array($doctorData['questions']))
            @foreach($doctorData['questions'] as $questionKey => $question)
                @if(is_array($question) && isset($question['question']) && $questionKey !== 'title')
                    <div class = "qsts-content" id="default">
                        <p class="qsts">{{ $question['question'] }}</p>
                            @if(isset($question['legend']) && is_array($question['legend']) && isset($question['value']) && is_array($question['value']))
                                <ul class="choice-list">
                                    @foreach($question['legend'] as $choiceIndex => $choice)
                                        <li>{{ $choice }} ({{ $question['value'][$choiceIndex]}})</li>
                                    @endforeach
                                </ul>
                            @endif
                    </div>
                @endif
            @endforeach
        @endif
    </div>
        <div id="newQuestionForm" style="display: none;">
            <form action="{{ route('newTemplate') }}" method="POST">
                @csrf
                <select id="templates" name="template" onchange="this.form.submit()">
                        <option>Select an Existing Templates</option>
                    @foreach($doctorData['templates'] as $templateTitle => $templates)
                        <option value="{{ $templateTitle }}">{{ $templateTitle }}</option>
                    @endforeach
                </select>   
            </form>
         
        <form action="{{ route('updateQuestions') }}" method="POST" id="questionForm">
        @csrf
        <input placeholder="Enter Title" name="title" class="title-txt">
        <div id="questionContainer">
            <div class="question-group">
                <input placeholder="Enter Question" name="question[]" class="question-txt"><br>
                <div class="val-leg-container">
                    <input placeholder="Enter Legend" name="legend[0][]" class="legend-txt">
                    <input placeholder="Enter Value" name="value[0][]" class="val-txt"><br>
                    <input placeholder="Enter Legend" name="legend[0][]" class="legend-txt">
                    <input placeholder="Enter Value" name="value[0][]" class="val-txt"><br>
                    <input placeholder="Enter Legend" name="legend[0][]" class="legend-txt">
                    <input placeholder="Enter Value" name="value[0][]" class="val-txt"><br>
                    <input placeholder="Enter Legend" name="legend[0][]" class="legend-txt">
                    <input placeholder="Enter Value" name="value[0][]" class="val-txt"><br>
                    <input placeholder="Enter Legend" name="legend[0][]" class="legend-txt">
                    <input placeholder="Enter Value" name="value[0][]" class="val-txt">
                </div>
                <button type="button" class="remove-question-btn" style="display: none;">Remove</button>
            </div>
        </div>
        <button type="submit">Save</button>
    </form>
    <button id="addQuest" class="addQuest">Add</button>
    </div>

    <div id="editedQuestionForm" style="display: none;">
        <form method="POST" action="{{ route('editQuestions') }}">
            @csrf
            <input type="text" name="title" value="{{ $doctorData['title'] }}">
            <div id="newQuestionContainer">
                @if(isset($doctorData['questions']) && is_array($doctorData['questions']))
                    @foreach($doctorData['questions'] as $questionKey => $question)
                        @if(is_array($question) && isset($question['question']) && $questionKey !== 'title')
                            <div class="new-questionGroup">
                                 <input type="text" name="questions[{{ $questionKey }}][question]" value="{{ $question['question'] }}" placeholder="Enter Question">
                                    @if(isset($question['legend']) && is_array($question['legend']) && isset($question['value']) && is_array($question['value']))
                                        <div>
                                            @foreach($question['legend'] as $index => $legend)
                                                <input name="questions[{{ $questionKey }}][legend][]" value="{{ $legend }}" class="legend-txt">
                                                <input name="questions[{{ $questionKey }}][value][]" value="{{ $question['value'][$index] }}" class="val-txt"><br>
                                            @endforeach
                                        </div>
                                    @endif
                                    <button type="button" class="remove-editedquestion-btn">Remove</button>
                            </div>
                        @endif
                    @endforeach
                @endif  
            </div>
            <button type="submit">Save Changes</button>
        </form>
        <button type="button" id="addNewQuestion">Add New Question</button>
    </div>
        <button id="newQuestions">Create Template</button>
            @if($doctorData['title'] !== 'default')
                <button id="Edit" onclick ="editQuestion()">Edit</button>
            @endif
</div>

<script>
    
</script>