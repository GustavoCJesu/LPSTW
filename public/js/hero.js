const image = document.querySelector('.hero__img')
const track = document.querySelector(".hero__track")
const dots = document.querySelectorAll(".hero__dot")
const slides = document.querySelectorAll('.hero__slide')

console.log(image, track, dots, slides)

const active = "hero__dot--active"

var slide = 0
var currentDot = 0

var lastDot = 0

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

function toggleSlide(id) {

    console.log('Função chamada')
    // console.log('---------------------')
    // console.log('ID: ', id)
    // console.log('CurrentDot: ', currentDot)
    // console.log('LastDot: ', lastDot)
    // console.log('---------------------')

    if (id > slides.length - 1) {
        currentDot = 0
    }else if(id < 0){
        currentDot = slides.length - 1
    }

    dots[currentDot].classList.toggle(active)
    track.style.transform = `translateX(-${currentDot * 100}%)`
    dots[lastDot].classList.toggle(active)
    lastDot = currentDot
}

dots.forEach(dot => {
    dot.addEventListener('click', () => {
        currentDot = dot.dataset.id
        toggleSlide(currentDot)
    })
});

function automaticToggle() {
    currentDot++
    toggleSlide(currentDot)
}


setInterval(automaticToggle, 5000)
