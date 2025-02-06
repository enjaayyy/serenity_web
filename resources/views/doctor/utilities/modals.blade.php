<link rel="stylesheet" href="{{ asset('css/doctor/utilities/modal.css')}}">
<div class="modal-screen" id="modal-screen">
    <div class="modal-container">
        <div class="modal-header-container">
            <button onclick="closeConfirmationModal()">x</button>
        </div>
        <div class="modal-image">
            <img src="{{ asset('assets/thinking-person.jpg')}}">
        </div>
        <div class="modal-subtitle">
            <p>Are you sure you want to use this questionnaire?</p>
        </div>
    </div>
</div>

<script>
    function openConfirmationModal(){
        let modalScreen = document.getElementById('modal-screen');
        document.body.style.overflow = 'hidden';
        modalScreen.style.display = "block";
    }

    function closeConfirmationModal(){
        let modalScreen = document.getElementById('modal-screen');
        modalScreen.style.display = "none";
        document.body.style.overflow = 'auto';
    }

</script>