// Carrossel do hero: slide, bolinha e título mudam juntos.
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

// Título com efeito de digitação.
const DIGITAR_MS = 35
const APAGAR_MS = 15
const ATRASO_INICIAL_MS = 700
const semMovimento = matchMedia('(prefers-reduced-motion: reduce)').matches

const tituloLeitor = document.createElement('span')
tituloLeitor.className = 'hero__titulo-leitor'
const tituloDigitado = document.createElement('span')
tituloDigitado.setAttribute('aria-hidden', 'true')

let letras = []
let letrasVisiveis = 0
let digitacaoAtual = 0

if (headline && headlineText[0]) {
    headline.replaceChildren(tituloLeitor, tituloDigitado)
    montarLetras(headlineText[0])
    updateHeadline(0, ATRASO_INICIAL_MS)
}

const active = "hero__dot--active"

var slide = 0
var currentDot = 0

var lastDot = 0

// Swipe no mobile (mínimo de 50px).
let startX = 0;

track.addEventListener("touchstart", (e) => {
    startX = e.touches[0].clientX;
});

track.addEventListener("touchend", (e) => {
    const endX = e.changedTouches[0].clientX;
    const distance = startX - endX;
    if (distance > 50) {
        currentDot++
        toggleSlide(currentDot)
        reiniciarAutomatico()
    } else if (distance < -50) {
        currentDot--
        toggleSlide(currentDot)
        reiniciarAutomatico()
    }
});

// Vai para o slide id (dá a volta nas pontas) e atualiza bolinha e título.
function toggleSlide(id) {
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

// Apaga o título atual e digita o do slide id.
async function updateHeadline(id, atraso = 0) {
    if (!headline || !headlineText[id]) return

    const minha = ++digitacaoAtual
    tituloLeitor.innerHTML = headlineText[id]

    if (semMovimento) {
        montarLetras(headlineText[id])
        mostrarLetras(letras.length)
        return
    }

    headline.classList.add('hero__titulo--digitando')
    await esperar(atraso)

    while (letrasVisiveis > 0) {
        if (minha !== digitacaoAtual) return
        mostrarLetras(letrasVisiveis - 1)
        await esperar(APAGAR_MS)
    }

    if (minha !== digitacaoAtual) return
    montarLetras(headlineText[id])

    while (letrasVisiveis < letras.length) {
        await esperar(DIGITAR_MS)
        if (minha !== digitacaoAtual) return
        mostrarLetras(letrasVisiveis + 1)
    }

    headline.classList.remove('hero__titulo--digitando')
}

// Coloca cada letra da frase num <span>, mantendo os destaques.
function montarLetras(html) {
    const modelo = document.createElement('template')
    modelo.innerHTML = html
    letras = []

    const separar = (no) => {
        for (const filho of [...no.childNodes]) {
            if (filho.nodeType !== Node.TEXT_NODE) {
                separar(filho)
                continue
            }

            const spans = [...filho.textContent].map((caractere) => {
                const letra = document.createElement('span')
                letra.className = 'hero__letra'
                letra.textContent = caractere
                return letra
            })
            letras.push(...spans)
            filho.replaceWith(...spans)
        }
    }

    separar(modelo.content)
    tituloDigitado.replaceChildren(modelo.content)
    mostrarLetras(0)
}

// Mostra as n primeiras letras e posiciona o cursor.
function mostrarLetras(n) {
    letrasVisiveis = n
    letras.forEach((letra, i) => {
        letra.classList.toggle('hero__letra--visivel', i < n)
        letra.classList.toggle('hero__letra--cursor', i === Math.max(n - 1, 0))
        letra.classList.toggle('hero__letra--inicio', n === 0 && i === 0)
    })
}

// Espera ms milissegundos.
function esperar(ms) {
    return new Promise((resolve) => setTimeout(resolve, ms))
}

// Clique na bolinha vai direto para o slide.
dots.forEach(dot => {
    dot.addEventListener('click', () => {
        currentDot = dot.dataset.id
        toggleSlide(currentDot)
        reiniciarAutomatico()
    })
});

// Avança para o próximo slide.
function automaticToggle() {
    currentDot++
    toggleSlide(currentDot)
}

// Troca automática a cada 5s.
let intervaloSlides = setInterval(automaticToggle, 5000)

// Recomeça a contagem quando o usuário navega.
function reiniciarAutomatico() {
    clearInterval(intervaloSlides)
    intervaloSlides = setInterval(automaticToggle, 5000)
}
