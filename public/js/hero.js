const image = document.querySelector('.hero__img')
const track = document.querySelector(".hero__track")
const dots = document.querySelectorAll(".hero__dot")

const active = "hero__dot--active"

let interval

var slide = 0
var currentDot = 0

var lastDot = 0

let startX = 0;

track.addEventListener("touchstart", (e) => {
    startX = e.touches[0].clientX;
});

track.addEventListener("touchend", (e) => {
    const endX = e.changedTouches[0].clientX;
    const distance = startX - endX;

    console.log(distance);

    if (distance > 50) {
        if (lastDot == dots.length - 1) {
            dots[lastDot].classList.toggle(active)
            lastDot = 0
            track.style.transform = `translateX(-${lastDot * 100}%)`
            dots[lastDot].classList.toggle(active)
        } else {
            dots[lastDot].classList.toggle(active)
            lastDot++
            track.style.transform = `translateX(-${lastDot * 100}%)`
            dots[lastDot].classList.toggle(active)
        }

    } else if (distance < -50) {
        if (lastDot == 0) {
            dots[lastDot].classList.toggle(active)
            lastDot = 2
            track.style.transform = `translateX(-${lastDot * 100}%)`
            dots[lastDot].classList.toggle(active)
        } else {
            dots[lastDot].classList.toggle(active)
            lastDot--
            track.style.transform = `translateX(-${lastDot * 100}%)`
            dots[lastDot].classList.toggle(active)
        }
    }
});


dots.forEach(dot => {
    dot.addEventListener('click', () => {
        const id = dot.dataset.id
        Carrossel(id)
    })
})

function Carrossel(id) {

    if (id != undefined) {
        dots[id].classList.toggle(active)
        dots[lastDot].classList.toggle(active)
        lastDot = id
        track.style.transform = `translateX(-${id * 100}%)`
    } else {
        if (lastDot == dots.length - 1) {
            dots[lastDot].classList.toggle(active)
            lastDot = 0
            track.style.transform = `translateX(-${lastDot * 100}%)`
            dots[lastDot].classList.toggle(active)
        } else {
            dots[lastDot].classList.toggle(active)
            lastDot++
            track.style.transform = `translateX(-${lastDot * 100}%)`
            dots[lastDot].classList.toggle(active)
        }
    }

}
setInterval(Carrossel, 5000)
