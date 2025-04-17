<link rel="stylesheet" href=" {{ asset('css/doctor/utilities/aboutme.css')}}">

<div class="about-me-container" id="about-me-container" style="display:none;">
    <form action = "{{ route('editDetails') }}"method="POST" id="form-container">
        @csrf
        <div class="main-detail-header" id="main-detail-header">
            <p class="doctor-name" id="doctor-name">{{ $doctorData['name'] }}</p>
            <button type="button" class="edit-btn" id="edit-btn" onclick="editData()">
                <p>Edit</p>
                <img class="edit-icon" src=" {{ asset('assets/edit-icon.svg') }}">
            </button>
        </div>
        <div class="doctor-profession-container" id="doctor-profession-container">
            <p class="doctor-profession" id="doctor-profession">{{ $doctorData['prof'] }}</p>
        </div>
        <div class="spec-container">
            <div class="spec-header">
                <p class="data-header">Specialization</p>
            </div>
            <div class="spec-list-container">
                @if(isset($doctorData['spec']) && is_array($doctorData['spec']))
                    @foreach($doctorData['spec'] as $spec)
                        <div class="spec-list">
                            <p>{{$spec}}</p>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="more-details">
                <div class="data-labels-container">
                    <p class="data-labels-header">Additional Information</p>
                    <div class="labels-data">
                        <div class="labels-container">
                            <p class="labels">Age:</p>
                            <p class="labels">Gender:</p>
                            <p class="labels">Years of Service:</p>
                            <p class="labels">Medical License:</p>

                        </div>
                        <div class="ddata-container" id="ddata-container">
                            <p class="ddata-content" id="ddata-age">{{ $doctorData['age'] }}</p>
                            <p class="ddata-content" id="ddata-gender">{{ $doctorData['gender'] }}</p>
                            <p class="ddata-content" id="ddata-years">{{ $doctorData['yrs'] }}</p>
                            <p class="ddata-content" id="ddata-license">{{ $doctorData['license'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="data-labels-container">
                    <p class="data-labels-header">Contact Information</p>
                    <div class="labels-data">
                        <div class="labels-container">
                            <p class="labels">Email Address:</p>
                            <p class="labels">Work Address:</p>
                        </div>
                        <div class="ddata-container" id="ddata-container-2">
                            <p class="ddata-content" id="email-input">{{ $doctorData['email'] }}</p>
                            <p class="ddata-content" id="address-input">{{ $doctorData['address'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="doctor-description" id="doctor-description">
                <p class="data-labels-header">Additional Description</p>
                    @if(isset($doctorData['descrip']))
                        <p  id="doctor-description-area"> {{ $doctorData['descrip'] }} </p>
                    @else  
                        <textarea class="doctor-description-area" id="doctor-description-area" disabled>No DATA!</textarea> 
                    @endif
            </div>
            {{-- <script>
                let x = @json($doctorData);
                console.log(x);
            </script> --}}
        </div>
    </form>
</div>

<script src="{{ asset('js/doctor/aboutme.js') }}"></script>