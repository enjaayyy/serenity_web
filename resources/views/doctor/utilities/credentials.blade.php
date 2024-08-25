<div class="cred-container" id="cred-container">
                                    @if(isset($doctorData['creds']) && is_array( $doctorData['creds']))
                                        @foreach($doctorData['creds'] as $images)
                                            <div class="img-container">
                                                <img src="{{ $images }}" class="img-data">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>