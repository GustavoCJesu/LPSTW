const menu = document.querySelector(".header__menu")
const btn = document.querySelector('#header__btn__menu')

btn.addEventListener('click', ()=>{
    toggleMenu()
})




function toggleMenu() {
    const menuIcon = document.querySelector("#menu-icon--Menu")
    const XIcon = document.querySelector("#menu-icon--X")

    menu.classList.toggle("header__menu--active")

    menuIcon.classList.toggle("menu__icon--disabled")
    XIcon.classList.toggle("menu__icon--disabled")
    console.log(menuIcon.isConnected)
}
