document.querySelector('div[data-div="settingsDiv"]').addEventListener("click", e => {
    e.preventDefault();

    const value = e.target.dataset.button;

    if (value !== undefined) {
        document.querySelector(`div[data-form="${value}"]`).classList.remove("hidden");
        document.body.style.overflow = "hidden";
    }
})

document.querySelector('form[data-div="form"]').addEventListener("click", e => {

    if (e.target.classList.contains("absolute-form-div")) {

        e.target.classList.add("hidden");
        document.body.style.overflow = "auto";

    } else if (e.target.dataset.button === "backButton") {

        e.target.parentNode.parentNode.parentNode.classList.add("hidden");
        document.body.style.overflow = "auto";

    }

})