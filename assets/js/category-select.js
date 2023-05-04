const label = document.querySelector("#categories-label");
const select = document.querySelector("#categories-select");
const categoriesSpan = document.querySelector("#categories-span");

let categories = [];

label.addEventListener("click", e => {
    e.preventDefault();

    if (e.target.classList.contains("selected-category-delete")) {
        const id = e.target.parentNode.dataset.id;
        document.querySelector(`#categories-select > option[value="${id}"]`).classList.remove("category-checked");
        removeCategory(id);
        addCategories();
    } else {
        select.classList.toggle("hidden-size");
    }
})

select.addEventListener("click", e => {
    e.preventDefault();

    if (e.target !== e.currentTarget) {
        if (!e.target.classList.contains("category-checked")) {
            e.target.classList.add("category-checked");
            createCategory(e.target.innerHTML, e.target.value); 
        } else {
            e.target.classList.remove("category-checked");
            removeCategory(e.target.value);
        }
        addCategories();
    }
})

function createCategory(name, id) {
    const span = document.createElement("span");
    span.classList.add("selected-category-span");
    span.dataset.id = id;
    span.innerHTML = name;
    const innerSpan = document.createElement("span");
    innerSpan.classList.add("selected-category-delete");
    span.append(innerSpan);
    categories.push(span);
}

function removeCategory(id) {
    const index = categories.findIndex(el => el.dataset.id === id);
    categories.splice(index, 1);
}

function addCategories() {

    categoriesSpan.innerHTML = "";
    document.querySelector("#categories-label > input").value = categoriesSpan.toString();

    if (categories.length !== 0) {
        categories.forEach(category => {
            categoriesSpan.append(category);
        })
    } else {
        const span = document.createElement("span");
        span.style.color = "#757575";
        span.innerHTML="Please select..."
        categoriesSpan.append(span);
    }

}

addCategories();