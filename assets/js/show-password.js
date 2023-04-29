// messy code a lot of if statements but it works

const passwordDivs = document.querySelectorAll(".password-input");

function changeTypeAttribute (node) {
    if (node.getAttribute("type") === "password") {
        node.setAttribute("type", "text");
    } else {
        node.setAttribute("type", "password");
    }
}

passwordDivs.forEach(passwordDiv => {
    passwordDiv.addEventListener("click", e => {
        e.preventDefault();

        if (e.target.dataset.button === "show-hide-password") {
            e.target.classList.toggle("hidden");

            if (e.target.nextElementSibling === null) {
                e.target.previousElementSibling.classList.toggle("hidden");
                changeTypeAttribute(e.target.previousElementSibling.previousElementSibling);
            } else {
                e.target.nextElementSibling.classList.toggle("hidden");
                changeTypeAttribute(e.target.previousElementSibling);
            }
        }
    })
});