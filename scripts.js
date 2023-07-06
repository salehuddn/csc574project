function setActiveNavItem() {
  let currentPagePath = window.location.pathname;
  let navLinks = document.querySelectorAll('.nav-item a');

  console.log("current page", currentPagePath);

  for (let i = 0; i < navLinks.length; i++) {
    let link = navLinks[i];

    if (link.getAttribute('href') === currentPagePath) {
      link.parentNode.classList.add('active');
    }
  }
}