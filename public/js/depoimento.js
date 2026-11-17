// Carrossel infinito dos depoimentos.
const track = document.querySelector('.evidence__track')
// Duplica os cards para o loop não ter emenda.
track.innerHTML += track.innerHTML

let position = 0
const speed = 1



// Pausa enquanto o usuário segura o carrossel.
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

// Move a faixa a cada frame; volta ao início ao chegar na metade.
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