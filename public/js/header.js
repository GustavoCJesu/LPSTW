const menu = document.querySelector(".header__menu")
const btn = document.querySelector('#header__btn__menu')

const menuAberto = () => menu.classList.contains("header__menu--active")

btn.addEventListener('click', () => {
    definirMenu(!menuAberto())
})

// Fecha ao tocar num link do menu (as âncoras não recarregam a página).
menu.addEventListener('click', (evento) => {
    if (evento.target.closest('a')) definirMenu(false)
})

// Fecha ao tocar fora do header.
document.addEventListener('click', (evento) => {
    if (menuAberto() && !evento.target.closest('.header')) definirMenu(false)
})

// Fecha com Esc e devolve o foco ao botão.
document.addEventListener('keydown', (evento) => {
    if (evento.key === 'Escape' && menuAberto()) {
        definirMenu(false)
        btn.focus()
    }
})

// Abre/fecha o menu mobile e alterna o ícone (menu/X).
// Os ícones são buscados na hora porque o Lucide troca os <i> por <svg> depois do carregamento.
function definirMenu(aberto) {
    const menuIcon = document.querySelector("#menu-icon--Menu")
    const XIcon = document.querySelector("#menu-icon--X")

    menu.classList.toggle("header__menu--active", aberto)

    menuIcon.classList.toggle("menu__icon--disabled", aberto)
    XIcon.classList.toggle("menu__icon--disabled", !aberto)

    btn.setAttribute('aria-expanded', String(aberto))
    btn.setAttribute('aria-label', aberto ? 'Fechar menu' : 'Abrir menu')
}
