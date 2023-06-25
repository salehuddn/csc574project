const navbarToggler = document.getElementById("navbarToggler");
const navbarItems = document.getElementById("navbarItems");

navbarToggler.addEventListener("click", function () {
  navbarItems.classList.toggle("show");
});