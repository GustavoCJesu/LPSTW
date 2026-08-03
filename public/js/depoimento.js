const track = document.querySelector('.evidence__track')


let position = 0
const speed = 1



let pause = false

track.addEventListener('pointerdown', () => {
    pause = true
    console.log(pause)
})

track.addEventListener('pointerup', () => {
    pause = false
    console.log(pause)
})

track.addEventListener('pointercancel', () => {
    pause = false
    console.log(pause)
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