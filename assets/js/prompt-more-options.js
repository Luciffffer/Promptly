// share button
document.querySelector('[data-share-prompt-btn]').addEventListener('click', e => {
    e.preventDefault();
    navigator.clipboard.writeText(window.location.href)
    .then(() => {
        displaySuccess('Link copied to clipboard');
    })
})

// delete prompt
document.querySelector('[data-delete-prompt-btn]').addEventListener('click', e => {
    e.preventDefault();
    document.querySelector('#delete-prompt-container').showModal();
    document.body.style.overflowY = 'hidden';
    document.body.style.height = '100vh';
})

document.querySelector('[data-close-delete]').addEventListener('click', e => {
    e.preventDefault();
    document.querySelector('#delete-prompt-container').close();
    document.body.style.overflowY = 'auto';
    document.body.style.height = 'auto';
})

const feedbackCont = document.querySelector('#feedback-container');
const feedbackContent = document.querySelector('#feedback-content');

function displaySuccess (message) {
    feedbackContent.innerHTML = '';
    feedbackCont.style.backgroundColor = 'rgb(29, 124, 29)';

    const img = document.createElement('img');
    img.src = 'assets/images/site/success-icon.svg';
    img.alt = 'Success';
    feedbackContent.appendChild(img);

    const p = document.createElement('p');
    p.textContent = message;
    feedbackContent.appendChild(p);

    displayFeedback();
}

function displayFeedback () {
    feedbackCont.classList.remove('hidden');
    setTimeout(() => {
        feedbackCont.classList.remove("feedback-container-hidden");
    }, 20);
}

function hideFeedback () {
    feedbackCont.classList.add("feedback-container-hidden");
    setTimeout(() => {
        feedbackCont.classList.add('hidden');
    }, 300);
}

document.querySelector('#feedback-close-btn').addEventListener('click', e => {
    e.preventDefault();
    hideFeedback();
})