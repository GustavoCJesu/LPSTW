const track = document.querySelector('.evidence__track')
track.innerHTML += track.innerHTML

let position = 0
const speed = 1



let pause = false

track.addEventListener('pointerdown', () => {
    pause = true
})

track.addEventListener('pointerup', () => {
    pause = false
})

track.addEventListener('pointercancel', () => {
    pause = false
})

function animate() {

    if (!pause) {
        position -= speed

        const half = track.scrollWidth / 2

        if (Math.abs(position) >= half) {
            position = 0
        }

        track.style.transform = `translateX(${position}px)`

        requestAnimationFrame(animate)
    }else{
        requestAnimationFrame(animate)
    }
}

animate()