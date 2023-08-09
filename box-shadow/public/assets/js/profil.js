const allformas = document.querySelector("#allformas");
const show = document.querySelector(".show");

allformas.addEventListener("mouseover", function() {
    show.style.display = show.style.display === 'none' ? 'block' : 'none';
});