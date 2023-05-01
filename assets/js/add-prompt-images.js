const promptHeaderInput = document.querySelector("#prompt-header-image")

promptHeaderInput.onchange = e => {
    // get form data
    const formData = new FormData();
    formData.append("image", promptHeaderInput.files[0]);

    // send form data to ajax page
    fetch("../ajax/upload-image.ajax.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(json => {
            document.querySelector("#prompt-header").style.backgroundImage = `url(../${json['body']})`;
            document.querySelector("#prompt-header > div").classList.remove("hidden");
        })
        .catch($err => {
            console.warn($err);
        })
}
