if (document.querySelector('[data-get-btn]')) {
    document.querySelector('[data-get-btn]').addEventListener('click', e => {
        e.preventDefault();

        const promptId = new URLSearchParams(window.location.search).get('id');
        formData = new FormData();
        formData.append('promptId', promptId);

        fetch('ajax/get-prompt.ajax.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(json => {
                if (json.status === 'error') {
                    throw json.message;
                }

                window.location.reload();
            })
            .catch(error => displayError(error));
    })
}