<div class="modal-screen" id="modal-screen">
    <div class="modal-card">
        <form method="POST" action="{{ route('addnotes', ['id' => $patientDetails['patientID']]) }}">
            @csrf
                <div class="notes-card-header">
                <p class="notes-header">Add Notes</p>
                <button type="button" class="close-btn" onclick="closeNotesModal()">x</button>
                </div>
                <textarea class="notes-details" name="notes-data"></textarea>
                <div style="text-align: right; margin-top: 1vh">
                    <button class="submit-note">Add Note</button>
                </div>
        </form>
    </div>
</div>

<script>
    function closeNotesModal(){
        document.getElementById('modal-screen').style.display = 'none';
    }
</script>