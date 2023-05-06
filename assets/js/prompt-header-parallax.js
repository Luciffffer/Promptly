// Parallax effect for prompt header
const promptHeader = document.querySelector("#prompt-header");

window.onscroll = () => {
    promptHeader.style.backgroundPosition = `center calc(50% + ${window.scrollY/2}px)`; 
}