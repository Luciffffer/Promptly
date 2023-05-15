let currentPage = 1;
const promptList = document.querySelector("#all-prompts-list");

window.addEventListener("scroll", scrolledToEnd);

function scrolledToEnd () {
    if ((window.innerHeight + Math.round(window.scrollY)) >= document.body.offsetHeight || document.body.scrollHeight < document.body.clientHeight) {
        
         // create filler content while loading
        let tempPrompts = [];

        for (let i = 0; i < 16; ++i) {
            const promptCard = createPromptCard({isLoading: true});
            promptList.appendChild(promptCard);
            tempPrompts.push(promptCard);
        }

        // construct ajax url
        const params = new URLSearchParams(window.location.search);
        params.set("page", ++currentPage);
        const url = "ajax/get-prompts.ajax.php?" + params.toString();
        
        // ajax
        fetch(url)
            .then(response => response.json())
            .then(json => {
                
                if (json.status === "success") {
                    tempPrompts.forEach(promptCard => {
                        promptCard.remove();
                    })

                    json.prompts.forEach(prompt => {

                        const promptCard = createPromptCard({
                            title: prompt.title,
                            tags: JSON.parse(prompt.tags),
                            headerImage: prompt.header_image,
                            id: prompt.id
                        })

                        promptList.appendChild(promptCard);

                    })

                    if (json.prompts.length < 14) {
                        this.removeEventListener("scroll", scrolledToEnd);

                        const endOfPrompts = document.createElement("div");
                        endOfPrompts.id = "prompt-list-end";
                        
                        const endOfPromptsText = document.createElement("h2");
                        endOfPromptsText.textContent = "You've reached the end!";

                        endOfPrompts.appendChild(endOfPromptsText);
                        document.querySelector('#main-content').appendChild(endOfPrompts);

                        return;
                    }

                } else {
                    throw json.message;
                }

            })
            .catch(err => {
                console.error(err);
            })

    }   
}

scrolledToEnd();

function createPromptCard ({title = '', tags = '', headerImage = '', id = '', isLoading = false}) {
    const promptCard = document.createElement("div");
    if (isLoading) promptCard.classList.add("prompt-card-loading");

    const promptCardHeader = isLoading ? document.createElement("div") : document.createElement("a");
    if (!isLoading) promptCardHeader.href = `prompt.php?id=${id}`;
    promptCardHeader.classList.add("prompt-card-header");
    promptCardHeader.style.backgroundImage = `url(${headerImage})`;

    const promptCardBody = document.createElement("div");
    promptCardBody.classList.add("prompt-card-body");

    const promptCardBodyLeft = document.createElement("div");
    promptCardBodyLeft.classList.add("prompt-card-body-left");

    if (!isLoading) {
        const promptCardBodyLeftTitle = document.createElement("a");
        promptCardBodyLeftTitle.classList.add("white-a");
        promptCardBodyLeftTitle.href = `prompt.php?id=${id}`;
        promptCardBodyLeftTitle.textContent = title;
        promptCardBodyLeft.append(promptCardBodyLeftTitle);
    } else {
        const promptCardBodyLeftTitle = document.createElement("p");
        promptCardBodyLeft.append(promptCardBodyLeftTitle);
    }

    const promptCardBodyLeftTags = document.createElement("small");
    promptCardBodyLeftTags.classList.add("prompt-card-tags");

    if (tags !== '') {
        tags.forEach(tag => {
            const tagEl = document.createElement("span");
            tagEl.textContent = tag;
            promptCardBodyLeftTags.append(tagEl);
        })
    }

    promptCardBodyLeft.append(promptCardBodyLeftTags);

    promptCardBody.append(promptCardBodyLeft);

    if (!isLoading) {
        const promptCardGetBtn = document.createElement("a");
        promptCardGetBtn.href = `prompt.php?id=${id}`;
        promptCardGetBtn.classList.add("prompt-card-get-btn");

        const promptCardGetBtnImg = document.createElement("img");
        promptCardGetBtnImg.src = 'assets/images/site/plus-circle-icon.svg';
        promptCardGetBtnImg.alt = "Get this prompt";
        promptCardGetBtn.append(promptCardGetBtnImg);

        promptCardBody.append(promptCardGetBtn);
    } else {
        const promptCardGetBtn = document.createElement("div");
        promptCardGetBtn.classList.add("prompt-card-get-btn");
        promptCardBody.append(promptCardGetBtn);
    }

    promptCard.append(promptCardHeader);
    promptCard.append(promptCardBody);

    return promptCard;
}