                                <div class="qst-container" id="qst-container">
                                    <p class = "qst-header">Questionnaire for {{ $doctorData['spec'] }} Patients</p>


                                    @if(isset($doctorData['questions']) && is_array($doctorData['questions']))
                                        @if(session('editqst'))
                                            <form method="POST" action="{{ route('updateQuestions') }}">
                                                @csrf
                                                <div class = "qst-item" id="qst-item">
                                                        @foreach($doctorData['questions'] as $index => $questions)
                                                        <div class = "qst-block" data-index="{{ $index }}">
                                                            <textarea name="questions[{{ $index }}][question]">{{ $questions['question'] }}</textarea>

                                                            @if(isset($questions['legend']) && is_array($questions['legend']))
                                                                @foreach($questions['legend'] as $choiceIndex => $choice)
                                                                    <div class="choices">
                                                                        <input type="text" name="questions[{{ $index }}][legend][{{ $choiceIndex }}]" value="{{ $choice }}">
                                                                        <input type="hidden" name="questions[{{ $index }}][value][{{ $choiceIndex }}]" value="{{ $questions['value'][$choiceIndex] }}">
                                                                    </div>
                                                                @endforeach
                                                            @endif

                                                            <button type="button" onclick="removequestion(this)" class="rmv-btn">Remove</button>
                                                        </div> 
                                                        @endforeach     
                                                </div>
                                                <button type="button" onclick="addquestion()">Add</button>
                                                <button type="submit">Save</button>
                                            </form>
                                        @else
                                                @foreach($doctorData['questions'] as $question)
                                                    <div class = "qsts-content">
                                                        <p class="qsts">{{ $question['question'] }}</p>

                                                        @if(isset($question['legend']) && is_array($question['legend']))
                                                            <ul class="choice-list">
                                                                @foreach($question['legend'] as $choiceIndex => $choice)
                                                                <li>{{ $choice }} ({{ $question['value'][$choiceIndex] }})</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            <form method="POST" action="{{ route('editQuestions') }}">
                                                @csrf
                                                <button type="submit">Edit</button>
                                            </form>
                                        @endif
                                    @endif
                                </div>