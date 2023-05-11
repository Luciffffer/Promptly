// hamburger menu left
document.querySelector("#hamburger-menu").addEventListener("click", e => {
    e.preventDefault();
    document.querySelector("#nav-ul").classList.toggle("hamburg-transform");
})

// account nav right
document.addEventListener("click", e => { 
    let target = e.target;
    
    do {
        if (target == document.querySelector("#account-nav-hitbox-login")) {
            return;
        }

        target = target.parentNode;
    } while (target);

    document.querySelector("#account-nav-hitbox-login").classList.add("hidden");
});

document.querySelector("#account-nav-btn").addEventListener("click", e => {
    e.preventDefault();
    e.stopPropagation();
    document.querySelector("#account-nav-hitbox-login").classList.toggle("hidden");
});
