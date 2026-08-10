const lightbox = document.querySelector('#lightbox')
const lightboxImg = lightbox.querySelector('.lightbox__img')
const closeBtn = lightbox.querySelector('.lightbox__close')

function openLightbox(img) {
    lightboxImg.src = img.currentSrc || img.src
    lightboxImg.alt = img.alt
    lightbox.classList.add('lightbox--active')
    document.body.style.overflow = 'hidden'
}

function closeLightbox() {
    lightbox.classList.remove('lightbox--active')
    document.body.style.overflow = ''
}

document.querySelectorAll('.js-expandable').forEach(img => {
    img.addEventListener('click', () => openLightbox(img))
})

closeBtn.addEventListener('click', closeLightbox)

lightbox.addEventListener('click', (event) => {
    if (event.target === lightbox) closeLightbox()
})

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') closeLightbox()
})
