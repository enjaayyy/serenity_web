<div class="add-appointment-screen" id="add-appointment-screen">
    <div class="add-appointment-card" id="add-appointment-card">
        <form method="POST" action="{{ route('addAppointments') }}">
            @csrf
                <div class="card-header-container">
                    <p class="card-header">Set Appointment</p>
                    <button class="close-btn" onclick="closeAppointmentModal()">x</button>
                </div>
                <div class="card-body">
                    <p class="input-header">Enter Title</p>
                    <input type="text" placeholder="Enter Details" class="input-details" name="input-details" autocomplete="off">
                    <p class="input-header">Enter Date and Time</p>
                    <div class="date-container">
                        <input type="date" class="input-date" name="input-date" required autocomplete="off">
                        <input type="time" class="input-time" name="input-starttime" required autocomplete="off">
                        <p>To</p>
                        <input type="time" class="input-time" name="input-endtime" required autocomplete="off">
                    </div>
                    <p class="input-header">Choose a Patient</p>
                    <div class="patient-container">
                        <select name="selected-user" required> 
                            <option disabled selected>Select Patient</option>
                                @foreach($patientData as $patientName)
                                    <option>
                                        @if(isset($patientName['name']))
                                            {{$patientName['name']}}
                                        @else
                                            No Patients Found!
                                        @endif
                                    </option>
                                @endforeach
                        </select>
                        <input type="color" name="color-indicator" required>
                    </div>
                    <div class="submit-container">
                        <button type="submit">Save</button>
                    </div>
                </div>
        </form>
    </div>
</div>

<script>
    function closeAppointmentModal(){
        document.getElementById('add-appointment-screen').style.display = 'none';
    }
</script>