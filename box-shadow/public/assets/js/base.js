const connect = document.querySelector("#connect");
const popup = document.querySelector(".popup");




connect.addEventListener("mouseover", function() {
    popup.style.display = popup.style.display === 'none' ? 'block' : 'none';
});
