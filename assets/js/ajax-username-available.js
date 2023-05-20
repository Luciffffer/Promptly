const input = document.querySelector("#username");
const messageEl = document.querySelector("#username-warning");
const errorSymbol = document.querySelector('i[data-username="warning"]');
const successSymbol = document.querySelector('i[data-username="success"]');

input.addEventListener("keyup", e => {
    
    if (messageEl.classList.contains("hidden")) messageEl.classList.remove("hidden");

    if (input.value.match(/([^a-zA-Z0-9])/)) {

        displayError("Username can only contain letters and numbers.");

    } else if (input.value.length < 3) {
        
        displayError("Username must be at least 3 characters long.");

    } else {

        const formData = new FormData();
        formData.append("columnValue", input.value);
        formData.append("columnName", "username");

        fetch("./ajax/check-available.ajax.php", {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(json => {            

                if (json['available'] === true) {

                    displaySuccess("Username is allowed.");

                } else if (json['available'] === false) {

                    displayError("This username is taken.");

                }

            })
            .catch(error => {
                console.error(error);
            })

    }
})


function displayError (message) {

    messageEl.innerHTML = message;
    messageEl.style.color = "var(--red)";
    if (errorSymbol.classList.contains("hidden")) errorSymbol.classList.remove("hidden");
    if (!successSymbol.classList.contains("hidden")) successSymbol.classList.add("hidden");

}

function displaySuccess (message) {

    messageEl.innerHTML = message;
    messageEl.style.color = "var(--green)";
    if (!errorSymbol.classList.contains("hidden")) errorSymbol.classList.add("hidden");
    if (successSymbol.classList.contains("hidden")) successSymbol.classList.remove("hidden");

}