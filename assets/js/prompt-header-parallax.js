// Parallax effect for prompt header
const promptHeader = document.querySelector("#prompt-header");

window.onscroll = e => {
    console.log(window.scrollY);
    promptHeader.style.backgroundPosition = `center calc(50% + ${window.scrollY/2}px)`; 
}