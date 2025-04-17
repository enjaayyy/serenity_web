document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.querySelector(".search-input");
    const tRows = document.querySelectorAll("tbody tr");

    searchInput.addEventListener("input", function() {
        const searchValue = searchInput.value.toLowerCase();

        tRows.forEach(row => {
            const nameBox = row.querySelector("td:first-child");
            const nameText = nameBox.textContent.toLowerCase();

            if(nameText.includes(searchValue)) {
                row.style.display = "";
            }
            else if(nameText === ""){
                row.style.display = block;
            }
            else{
                row.style.display = "none";
            }
        })
    })
})