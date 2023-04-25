// hamburger menu left
document.querySelector("#hamburger-menu").addEventListener("click", e => {
    e.preventDefault();
    document.querySelector("#nav-ul").classList.toggle("hamburg-transform");
})