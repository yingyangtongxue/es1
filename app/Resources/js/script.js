var modal = document.getElementById("myModal");

var btn = document.querySelectorAll(".modalbutton");

var span = document.getElementsByClassName("close")[0];

function clickModal() {
    modal.style.display = "block";
}

btn.forEach(button => {
    button.addEventListener('click', clickModal)
})
span.onclick = function () {
    modal.style.display = "none";
}

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}