<link rel="stylesheet" href="{{ asset('css/doctor/utilities/reportModal.css')}}">
<div class="report-screen" id="report-screen">
    <form method="POST" action="{{ route('reportPatient', ['id' => $patientDetails['patientID']]) }}">
        @csrf
        <div class="report-card">
            <div class="report-title-container">
                <p class="report-header">Report</p>
                <button class="close-btn" type="button" onclick="closeReportModal()">x</button>
            </div>
            <p class="header-details">"Serenity ensures that the users experiences a friendly and formal enviroment. Please provide details about the issue. Our team will review your report and take appropriate action."</p>
            <p class="report-subheader">Why are you reporting this user?</p>
            <div class="choices-container">
                <input type="checkbox" id="Sexual" name="choices[]" value="Sexual" hidden>
                <label for="Sexual">
                    <div class="choice">Sexual</div>
                </label>
                <input type="checkbox" id="Profanities" name="choices[]" value="Profanities" hidden>
                <label for="Profanities">
                    <div class="choice">Profanities</div>
                </label>
                <input type="checkbox" id="Fraud" name="choices[]" value="Fraud" hidden>
                <label for="Fraud">
                    <div class="choice">Fraud</div>
                </label>
                <input type="checkbox" id="Harrasment" name="choices[]" value="Harrassment" hidden>
                <label for="Harrasment">
                    <div class="choice">Harrassment</div>
                </label>
                <input type="checkbox" id="PV" name="choices[]" value="Privacy Violation" hidden>
                <label for="PV">
                    <div class="choice">Privacy Violation</div>
                </label>
                <input type="checkbox" id="violence" name="choices[]" value="Violence" hidden>
                <label for="violence">
                    <div class="choice">Violence</div>
                </label>
                <input type="checkbox" id="misinfo" name="choices[]" value="Misinformation" hidden>
                <label for="misinfo">
                    <div class="choice">Misinformation</div>
                </label>
                <input type="checkbox" id="discrimination" name="choices[]" value="Discrimination" hidden>
                <label for="discrimination">
                    <div class="choice">Discrimination</div>
                </label>
            </div>
            <p class="reason-header">More Details</p>
            <textarea class="reason-details" name="reason-details"></textarea>
            <button type="submit" class="submit-report">Submit</button>
        </div>
    </form>
    
</div>

<script>
    function closeReportModal(){
        document.getElementById('report-screen').style.display = 'none';
    }
</script>