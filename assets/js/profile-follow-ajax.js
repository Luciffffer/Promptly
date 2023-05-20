const followBtn = document.querySelector('[data-follow]');
const followerCount = document.querySelector('[data-follower-count]');

if (followBtn) {
    followBtn.addEventListener('click', e => {
        e.preventDefault();

        value = followBtn.dataset.follow === 'false' ? false : true;

        displayFollow(!value);

        // get id from url and put it in formdata
        const id = new URLSearchParams(window.location.search).get('id');
        const formData = new FormData();
        formData.append('followeeId', id);

        // ajax
        fetch("ajax/toggle-follow.ajax.php", {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(json => {
                if (json.status === 'error') {
                    throw json.message;
                }
            })
            .catch(error => {
                console.error(error);
                displayFollow(value);
            })

    })
}

function displayFollow (follow) {
    if (follow) {
        followBtn.dataset.follow = true;
        followBtn.textContent = 'Unfollow';
        followerCount.textContent = parseInt(followerCount.textContent) + 1 + ' Followers';
    }
    else if (!follow) {
        followBtn.dataset.follow = false;
        followBtn.textContent = 'Follow';
        followerCount.textContent = parseInt(followerCount.textContent) - 1 + ' Followers';
    }
}