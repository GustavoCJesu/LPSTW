// Amplia as imagens com a classe .js-expandable.
const lightbox = document.querySelector('#lightbox')
const lightboxImg = lightbox.querySelector('.lightbox__img')
const closeBtn = lightbox.querySelector('.lightbox__close')

// Abre a imagem em tela cheia e trava a rolagem da página.
function openLightbox(img) {
    lightboxImg.src = img.currentSrc || img.src
    lightboxImg.alt = img.alt
    lightbox.classList.add('lightbox--active')
    document.body.style.overflow = 'hidden'
}

// Fecha e libera a rolagem.
function closeLightbox() {
    lightbox.classList.remove('lightbox--active')
    document.body.style.overflow = ''
}

document.querySelectorAll('.js-expandable').forEach(img => {
    img.addEventListener('click', () => openLightbox(img))
})

// Fecha pelo X, clicando fora da imagem ou com Esc.
closeBtn.addEventListener('click', closeLightbox)

lightbox.addEventListener('click', (event) => {
    if (event.target === lightbox) closeLightbox()
})

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') closeLightbox()
})
