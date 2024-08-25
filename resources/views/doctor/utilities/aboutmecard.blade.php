                                <div class="abt-container" id="abt-container">
                                    <p class="abt-me">About me</p>
                                    @if(empty($doctorData['descrip']) || session('editMode'))
                                    <form method="POST" action="{{ route('uploadDetails') }}">
                                        @csrf
                                        <textarea placeholder="Enter details about me..." name="textarea">{{ $doctorData['descrip'] }}</textarea>
                                        <button type="submit">Save</button>
                                    </form>
                                    @else
                                        <p class="read-only">{{ $doctorData['descrip'] }}</p>
                                        <form method="POST" action="{{ route('editDetails') }}">
                                            @csrf
                                            <button type="submit">Edit</button>
                                        </form>
                                    @endif
                                </div>