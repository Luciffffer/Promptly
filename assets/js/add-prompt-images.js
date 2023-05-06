const imageInputs = document.querySelectorAll('input[data-type="image"]');
const reader = new FileReader();
let imageCount = 1;

imageInputs.forEach(imageInput => {

    imageInput.onchange = handleImageChange;

})

document.querySelector("#add-example-image").addEventListener("click", e => {
    e.preventDefault();

    if (imageCount < 4) {
        //create new image input
        const input = document.createElement("input");
        input.setAttribute("type", "file");
        input.setAttribute("accept", ".jpg, .jpeg, .png, .webp");
        input.setAttribute("name", "prompt-example-image" + (imageCount+1));
        input.setAttribute("id", "prompt-example-image" + (imageCount+1));
        input.dataset.type = "image";
        input.classList.add("hidden");
        input.onchange = handleImageChange;

        //create new image label
        const label = document.createElement("label");
        label.setAttribute("for", "prompt-example-image" + (imageCount+1));
        label.classList.add("add-prompt-example-image");

        //append
        const container = document.querySelector("#example-image-container");
        container.append(input);
        container.append(label);

        if (imageCount === 3) {
            document.querySelector("#add-example-image").remove();
        }

        imageCount++;
    }
})

function handleImageChange (e) {
    if (e.target.files && e.target.files[0]) {

        reader.readAsDataURL(e.target.files[0]);

        reader.onload = () => {

            if (e.target === document.querySelector("#prompt-header-image")) {
                document.querySelector("#prompt-header > div").classList.remove("hidden");
            }

            document.querySelector(`label[for="${e.target.id}"]`).style.backgroundImage = `url(${reader.result})`;

        }

    } else {
        document.querySelector(`label[for="${e.target.id}"]`).style.backgroundImage = '';
    }
}