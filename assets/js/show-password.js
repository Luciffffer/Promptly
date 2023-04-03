const button = document.querySelector("#show-password");
const input = document.querySelector("#password-input > input");

let show = false;

button.addEventListener("click", e => {
    e.preventDefault();
    
    if (show === false) {
        input.type = "text";
        button.style.backgroundImage = "url(./assets/images/site/show-icon.svg)";
        show = true;
    } else {
        input.type = "password";
        button.style.backgroundImage = "url(./assets/images/site/hidden-icon.svg)";
        show = false;
    }
})