// hamburger menu left
document.querySelector("#hamburger-menu").addEventListener("click", e => {
    e.preventDefault();
    document.querySelector("#nav-ul").classList.toggle("hamburg-transform");
})

// account nav right
document.addEventListener("click", e => { 
    const isDropdownBtn = e.target.matches("[data-dropdown-btn]");
    if (!isDropdownBtn && e.target.closest("[data-dropdown]") != null) return;

    let currentDropdown;
    if (isDropdownBtn) {
        currentDropdown = e.target.closest("[data-dropdown]");
        currentDropdown.classList.toggle("active");
    }

    document.querySelectorAll("[data-dropdown].active").forEach(dropdown => {
        if (dropdown === currentDropdown) return;
        dropdown.classList.remove("active");
    })
})