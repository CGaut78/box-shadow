const allformas = document.querySelector("#allformas");
const showFormations = document.querySelector(".showFormations");
const allmodules = document.querySelector("#allmodules");
const showModules = document.querySelector(".showModules");
const allcours = document.querySelector("#allcours");
const showCours= document.querySelector(".showCours");

allformas.addEventListener("mouseover", function() {
    showFormations.style.display = showFormations.style.display === 'none' ? 'block' : 'none';
});

allmodules.addEventListener("mouseover", function() {
    showModules.style.display = showModules.style.display === 'none' ? 'block' : 'none';
});

allcours.addEventListener("mouseover", function() {
    showCours.style.display = showCours.style.display === 'none' ? 'block' : 'none';
});