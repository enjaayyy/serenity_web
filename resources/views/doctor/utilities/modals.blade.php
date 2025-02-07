<link rel="stylesheet" href="{{ asset('css/doctor/utilities/modal.css')}}">
<div class="modal-screen" id="modal-screen">
    <div class="modal-container" id="modal-container">
        <div class="modal-header-container">
            <button onclick="closeConfirmationModal()">x</button>
        </div>
        <div class="modal-image">
            <img src="{{ asset('assets/thinking-person.jpg')}}">
        </div>
        <div class="modal-subtitle">
            <p>Are you sure you want to use this questionnaire?</p>
        </div>
        <div class="modal-btns">
            <button class="modal-btn-accept">Accept</button>
            <button class="modal-btn-cancel" onclick="closeConfirmationModal()">Cancel</button>
        </div>
    </div>
    <div class="post-confirm-modal-container" id="post-confirm-modal-container" style="display:none;">
        <div class="modal-image">
            <img src="{{ asset('assets/accepted.gif')}}">
        </div>
        <div class="modal-btns">
            <button class="modal-btn-cancel" onclick="closeConfirmationModalwithLoad()">Close</button>
        </div>
    </div>
</div>

<script>
    function openConfirmationModal(obj, route, selectedSpec){
        let modalScreen = document.getElementById('modal-screen');
        document.body.style.overflow = 'hidden';
        modalScreen.style.display = "block";

        const acceptBtn = document.querySelector(".modal-btn-accept");
        acceptBtn.onclick = () => acceptQuestionnaire(obj, route, selectedSpec);
    }

    function acceptQuestionnaire(obj, route, selectedSpec){
        fetch(route, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        specialization: selectedSpec,
                        questionData: obj
                    }),
                })
                .then(response => {
                    postConfirmationModal();
                })
    }

    function closeConfirmationModal(){
        let modalScreen = document.getElementById('modal-screen');
        modalScreen.style.display = "none";
        document.body.style.overflow = 'auto';
    }

    function closeConfirmationModalwithLoad(){
        let modalScreen = document.getElementById('modal-screen');
        modalScreen.style.display = "none";
        document.body.style.overflow = 'auto';

        window.location.reload();
    }

    function postConfirmationModal(){
        let mainModal = document.getElementById('modal-container');
        mainModal.style.display = "none";
        let postModal = document.getElementById('post-confirm-modal-container');
        postModal.style.display = "block";
    }

</script>