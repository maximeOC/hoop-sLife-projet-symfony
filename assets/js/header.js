const menuBasket = document.querySelector(".menu-hamburger");
const nav = document.querySelector('.nav-links')

menuBasket.addEventListener('click', () =>{
    nav.classList.toggle('mobile')
})