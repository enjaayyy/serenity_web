document.addEventListener("DOMContentLoaded", function(){
    const searchInput = document.querySelector(".search-input");
    const ticketContainer = document.querySelectorAll(".ticket-details-container");

    searchInput.addEventListener("input", function(){
        const searchValue = searchInput.value.toLowerCase();

        ticketContainer.forEach(content => {
            const reporterName = content.querySelector('.reporter-name');
            const nameText = reporterName.textContent.toLowerCase();

            if(searchValue === ""){
                content.style.display = "";
            }
            else if(nameText.includes(searchValue)){
                content.style.display = "block";
            }
            else{
                content.style.display = "none";
            }
        })
    });
});
