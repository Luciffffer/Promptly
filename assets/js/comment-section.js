const textarea = document.querySelector('#comment-textarea');

// display buttons
textarea.addEventListener('click', e => {
    document.querySelector('#comment-buttons').classList.remove('hidden');

    textarea.addEventListener('keyup', resizeTextarea);

})

function resizeTextarea (e) { // better approach to get the result i want would be to create a custom element but yeah we don't have much time
    textarea.style.height = textarea.scrollHeight + 'px';
};


// cancel comment & remove buttons
document.querySelector('#comment-cancel').addEventListener('click', e => {
    e.preventDefault();
    exitComment();
});

function exitComment() {
    document.querySelector('#comment-buttons').classList.add('hidden');
    textarea.value = '';
    textarea.style.height = 'auto';
    textarea.removeEventListener('keyup', resizeTextarea);
}


// submit comment
document.querySelector('#comment-submit-btn').addEventListener('click', e => {
    e.preventDefault();

    const formdata = new FormData();
    formdata.append('comment', textarea.value);

    const params = new URLSearchParams(window.location.search);
    formdata.append('promptId', params.get('id'));

    fetch('ajax/add-comment.ajax.php', {
        method: 'POST',
        body: formdata
    })
        .then(response => response.json())
        .then(json => {

            if (json.status === 'error') {
                throw json.message;
            }

            exitComment();

            fillCommentSection(json.comments);

        })
        .catch(error => {
            console.error(error);
        })
})


// display comments
function createCommentCard(username, profile_picture, comment, date, commentId, userId) {
    const commentCard = document.createElement('div');
    commentCard.classList.add('comment');

    // profile picture
    const profilePicture = document.createElement('a');
    profilePicture.href = `profile.php?id=${userId}`;
    const profilePictureFigure = document.createElement('figure');
    profilePictureFigure.style.backgroundImage = `url(${profile_picture})`;
    profilePicture.appendChild(profilePictureFigure);


    // comment content
    const commentContent = document.createElement('div');

    // comment top
    const commentTop = document.createElement('div');
    commentTop.classList.add('comment-top');
    const commentUsername = document.createElement('a');
    commentUsername.href = `profile.php?id=${userId}`;
    commentUsername.textContent = username;
    commentUsername.classList.add('white-a');
    const commentDate = document.createElement('small');
    commentDate.textContent = date;
    commentTop.appendChild(commentUsername);
    commentTop.appendChild(commentDate);
    commentContent.appendChild(commentTop);

    // comment body
    const commentBody = document.createElement('p');
    comment = comment.replace(/(?:\r\n|\r|\n)/g, '<br>');
    commentBody.innerHTML = comment; // save from xss because htmlspecialschars used before sending data
    commentContent.appendChild(commentBody);


    commentCard.appendChild(profilePicture);
    commentCard.appendChild(commentContent);


    // comment delete button
    const currentUserId = document.querySelector('#primary-nav').dataset.userId;
    const isMod = document.querySelector('#primary-nav').dataset.mod;

    if (currentUserId == userId || isMod) {
        const deleteCommentButton = document.createElement('a');
        deleteCommentButton.classList.add('delete-comment-btn');
        deleteCommentButton.dataset.commentId = commentId;
        deleteCommentButton.ariaLabel = "delete comment";
        commentCard.appendChild(deleteCommentButton);
    }

    return commentCard;
}

function fillCommentSection(comments) {

    document.querySelector('#comment-list').innerHTML = '';

    comments.forEach(comment => {

        const commentCard = createCommentCard(
            comment.username,
            comment.profile_pic,
            comment.comment,
            comment.date_created,
            comment.id,
            comment.user_id
        );

        document.querySelector('#comment-list').appendChild(commentCard);

    })
}


// delete comment
document.querySelector('#comment-list').addEventListener('click', e => {
    if (e.target.classList.contains("delete-comment-btn")) {
        e.preventDefault();
        
        const commentId = e.target.dataset.commentId;
        
        const formdata = new FormData();
        formdata.append('commentId', commentId);

        e.target.parentNode.remove();

        fetch('ajax/remove-comment.ajax.php', {
            method: 'POST',
            body: formdata
        })
            .then(response => response.json())
            .then(json => {
                if (json.status === 'error') {
                    throw json.message;
                }

                fillCommentSection(json.comments);
            })
            .catch(error => {
                console.error(error);
            })

    }
})
