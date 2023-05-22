// share button
document.querySelector('[data-share-prompt-btn]').addEventListener('click', e => {
    e.preventDefault();
    navigator.clipboard.writeText(window.location.href)
    .then(() => {
        displaySuccess('Link copied to clipboard');
    })
})

// report prompt
document.querySelector('[data-report-prompt-btn]').addEventListener('click', e => {
    e.preventDefault();
    document.querySelector('#report-prompt-container').showModal();
    document.body.style.overflowY = 'hidden';
    document.body.style.height = '100vh';
})

function closeReportModal () {
    document.querySelector('#report-prompt-container').close();
    document.body.style.overflowY = 'auto';
    document.body.style.height = 'auto';
}

document.querySelector('[data-close-report]').addEventListener('click', e => {
    e.preventDefault();
    closeReportModal();
})

document.querySelector('#submit-report-btn').addEventListener('click', e => {
    e.preventDefault();
    closeReportModal();

    const promptId = new URLSearchParams(window.location.search).get('id');

    const formData = new FormData();
    formData.append('promptId', promptId);
    formData.append('reason', document.querySelector('[data-report-reason]').value);
    formData.append('extraInformation', document.querySelector('[data-report-extra-information]').value);

    fetch('ajax/report-prompt.ajax.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(json => {
            if (json.status === 'error') {
                throw json.message;
            }

            displaySuccess(json.message);
        })
        .catch(error => {
            displayError(error);
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


// feedback
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

function displayError (message) {
    feedbackContent.innerHTML = '';
    feedbackCont.style.backgroundColor = 'rgb(117, 10, 10)';

    const img = document.createElement('img');
    img.src = 'assets/images/site/warning-icon.svg';
    img.alt = 'Error';
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