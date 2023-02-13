const $button  = document.querySelector('#sidebar-toggle');
const $wrapper = document.querySelector('#wrapper');

const sideImg = document.getElementById("sideImg");
const sidebarNav = document.querySelector(".sidebar-nav");

$button.addEventListener('click', (e) => {
  e.preventDefault();
  $wrapper.classList.toggle('toggled');

  if (document.querySelector('#wrapper').classList.contains("toggled")) {
    sideImg.style.display = "none";
    sidebarNav.style.top = "70px"
  }
  else if (!document.querySelector('#wrapper').classList.contains("toggled")) {
    sideImg.style.display = "inline";
    sidebarNav.style.top = "170px"
  }
});

