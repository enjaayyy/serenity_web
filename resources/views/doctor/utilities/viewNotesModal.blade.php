<div class="view-note-screen" id="view-note-screen">
    <div class="view-note-card" id="view-note-card">
        <div class="view-note-card-header" id="view-note-card-header">
            <p class="view-notes-header">Session Notes</p>
            <button type="button" class="close-btn" onclick="closeViewNotesModal()">x</button>
        </div>
        <div class="view-note-body" id="view-note-body">
            <textarea class="view-notes-textarea" id="view-notes-textarea" disabled></textarea>
        </div>
        <p class="date-filed" id="date-filed"></p>
    </div>
</div>

<script>
    function closeViewNotesModal(){
        document.getElementById('view-note-screen').style.display = 'none';
    }
</script>