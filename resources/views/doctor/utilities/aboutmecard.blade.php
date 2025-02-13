<link rel="stylesheet" href=" {{ asset('css/doctor/utilities/aboutme.css')}}">

<div class="about-me-container" id="about-me-container" style="display:none;">
    <div class="main-detail-header" id="main-detail-header">
        <p class="doctor-name" id="doctor-name">{{ $doctorData['name'] }}</p>
        <button class="edit-btn" id="edit-btn" onclick="editData()">
            <p>Edit</p>
            <img class="edit-icon" src=" {{ asset('assets/edit-icon.svg') }}">
        </button>
    </div>
    <p class="doctor-profession">{{ $doctorData['prof'] }}</p>
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
                    <div class="ddata-container">
                        <p class="ddata-content">{{ $doctorData['yrs'] }}</p>
                        <p class="ddata-content">{{ $doctorData['gender'] }}</p>
                        <p class="ddata-content">{{ $doctorData['age'] }}</p>
                        <p class="ddata-content">{{ $doctorData['license'] }}</p>
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
                    <div class="ddata-container">
                        <p class="ddata-content">{{ $doctorData['address'] }}</p>
                        <p class="ddata-content">{{ $doctorData['email'] }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="doctor-description">
            <p class="data-labels-header">Additional Description</p>
                @if(isset($doctorData['description']))
                    <p>awdawd</p>
                @else  
                    <p>No Data!</p>
                @endif
        </div>
        <button onclick="testButton()">testbutton</button>
    </div>
</div>

<script src="{{ asset('js/doctor/aboutme.js') }}"></script>