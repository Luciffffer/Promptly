let width;

function setHorScrollSize() { // sshhhh don't tell anyone. This is an awful approach, but css is just not working for me here.
    const bodyWidth = document.body.getBoundingClientRect().width;
    const asideWidth = document.querySelector('aside').getBoundingClientRect().width;

    if (bodyWidth > 600) {
        width = bodyWidth - asideWidth;
    } else {
        width = bodyWidth;
    }
    const horScrolls = document.querySelectorAll(".discover-prompts-list");

    horScrolls.forEach(horScroll => {
        horScroll.style.width = width + 'px';
    })
}

window.addEventListener('resize', setHorScrollSize);

setHorScrollSize();

document.querySelectorAll('.hor-scroll-container').forEach(el => {
    el.addEventListener('click', e => {

        if (e.target.dataset.scroll === 'right' || e.target.parentNode.dataset.scroll === 'right') {

            const scrollEl = el.querySelector(".discover-prompts-list");

            scrollEl.scrollBy({
                left: width,
                behavior: 'smooth'
            })

        } else if (e.target.dataset.scroll === 'left' || e.target.parentNode.dataset.scroll === 'left') {
            el.querySelector(".discover-prompts-list").scrollBy({
                left: -width,
                behavior: 'smooth'
            })
        }

    })
})

function scrolledToStartOrEnd(el) {
    return el.scrollLeft + el.clientWidth >= el.scrollWidth;
}