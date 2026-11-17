// Carrossel do hero: slide, bolinha e título mudam juntos.
const image = document.querySelector('.hero__img')
const track = document.querySelector(".hero__track")
const dots = document.querySelectorAll(".hero__dot")
const slides = document.querySelectorAll('.hero__slide')
const headline = document.querySelector('.hero__headLine > h1')

// Título de cada slide (mesma ordem dos slides).
const headlineText = [
    'Mantenha sua operação em <span class="destaque">conformidade</span> o tempo todo!',
    'Controle <span class="destaque">inteligente</span> para uma operação mais <span class="destaque">segura</span>!',
    'Acompanhe cada retirada em <span class="destaque">tempo real</span>!'
]

if (headline && headlineText[0]) headline.innerHTML = headlineText[0]

console.log(image, track, dots, slides)

const active = "hero__dot--active"

var slide = 0
var currentDot = 0

var lastDot = 0

// Swipe no mobile (mínimo de 50px).
let startX = 0;

track.addEventListener("touchstart", (e) => {
    startX = e.touches[0].clientX;
});

console.log('JS Hero funcionando')

track.addEventListener("touchend", (e) => {
    const endX = e.changedTouches[0].clientX;
    const distance = startX - endX;
    if (distance > 50) {
        currentDot++
        toggleSlide(currentDot)
    } else if (distance < -50) {
        currentDot--
        toggleSlide(currentDot)
    }
});

// Vai para o slide id (dá a volta nas pontas) e atualiza bolinha e título.
function toggleSlide(id) {

    console.log('Função chamada')

    if (id > slides.length - 1) {
        currentDot = 0
    }else if(id < 0){
        currentDot = slides.length - 1
    }

    dots[currentDot].classList.toggle(active)
    track.style.transform = `translateX(-${currentDot * 100}%)`
    dots[lastDot].classList.toggle(active)
    lastDot = currentDot

    updateHeadline(currentDot)
}

// Troca o título com fade de 300ms.
function updateHeadline(id) {
    if (!headline || !headlineText[id]) return

    headline.classList.add('hero__headLine--fading')
    setTimeout(() => {
        headline.innerHTML = headlineText[id]
        headline.classList.remove('hero__headLine--fading')
    }, 300)
}

// Clique na bolinha vai direto para o slide.
dots.forEach(dot => {
    dot.addEventListener('click', () => {
        currentDot = dot.dataset.id
        toggleSlide(currentDot)
    })
});

// Avança para o próximo slide.
function automaticToggle() {
    currentDot++
    toggleSlide(currentDot)
}


// Troca automática a cada 5s.
setInterval(automaticToggle, 5000)
