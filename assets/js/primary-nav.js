// hamburger menu left
document.querySelector("#hamburger-menu").addEventListener("click", e => {
    e.preventDefault();
    document.querySelector("#nav-ul").classList.toggle("hamburg-transform");
})

// account nav right
let notificationsOpened = false;

document.addEventListener("click", e => { 
    const isDropdownBtn = e.target.matches("[data-dropdown-btn]");
    if (!isDropdownBtn && e.target.closest("[data-dropdown]") != null) return;

    let currentDropdown;
    if (isDropdownBtn) {
        if (!notificationsOpened && e.target.id === "notifications-btn") {
            notificationsOpened = true;
            getNotifications();
        }

        currentDropdown = e.target.closest("[data-dropdown]");
        currentDropdown.classList.toggle("active");
    }

    document.querySelectorAll("[data-dropdown].active").forEach(dropdown => {
        if (dropdown === currentDropdown) return;
        dropdown.classList.remove("active");
    })
})

// ajax
async function getNotifications() { // We use ajax for this because it would be useless and not good for loadspeeds to load images on every page
    const notificationsContainer = document.querySelector("#notifications-list");

    // add loading spinner
    let spinner = document.createElement("figure");
    spinner.id = "notifications-loading";
    notificationsContainer.appendChild(spinner);

    // get notifications
    try {
        const response = await fetch("ajax/get-notifications.ajax.php");
        const json = await response.json();

        if (json.status === 'error') {
            throw json.message;
        } else {
            
            // remove loading spinner
            spinner.remove();
    
            // add notifications
            json.body.forEach(notification => {
                const notificationEl = document.createElement("a");
                notificationEl.classList.add("notification");
                notificationEl.href = notification.link;
    
                const notificationImg = document.createElement("figure");
                notificationImg.style = `background-image: url(${notification.image})`;
                notificationImg.alt = notification.title;
                notificationEl.appendChild(notificationImg);
    
                const notificationText = document.createElement("div");
    
                const notificationTitle = document.createElement("p");
                notificationTitle.innerHTML = notification.message; // should be safe from XSS because not user input
                notificationText.appendChild(notificationTitle);
    
                // calculate time since notification
                const date = () => {
                    let [date, time] = notification.date_created.split(" ");
                    return new Date(`${date}T${time}`);
                }
    
                const timeAgo = timeSince(date());
    
                const notificationDate = document.createElement("small");
                notificationDate.innerHTML = timeAgo;
                notificationText.appendChild(notificationDate); 
    
                notificationEl.appendChild(notificationText);
    
                notificationsContainer.appendChild(notificationEl);
            })
    
            // add you're all caught up message
            const caughtUpDiv = document.createElement("div");
            caughtUpDiv.classList.add("notification-caught-up");
    
            const p = document.createElement("p");
            p.innerHTML = "You're all caught up!";
            caughtUpDiv.appendChild(p);
    
            notificationsContainer.appendChild(caughtUpDiv);

            // remove non viewed notification count
            if (document.querySelector("#notification-count")) {
                document.querySelector("#notification-count").remove();
            }
        }

    } catch (error) {
        console.error(error);
        return;
    }

}

function timeSince(date) { // honestly not really happy with it but i don't have the time to look deeper into how to do it better
    const seconds = Math.floor((new Date() - date) / 1000);
    
    let interval = seconds / 31536000;

    if (interval > 1) {
        return Math.floor(interval) + " years ago";
    }
    interval = seconds / 2592000;
    if (interval > 1) {
        return Math.floor(interval) + " months ago";
    }
    interval = seconds / 86400;
    if (interval > 1) {
        return Math.floor(interval) + " days ago";
    }
    interval = seconds / 3600;
    if (interval > 1) {
        return Math.floor(interval) + " hours ago";
    }
    interval = seconds / 60;
    if (interval > 1) {
        return Math.floor(interval) + " minutes ago";
    }
    return Math.floor(seconds) + " seconds ago";
}