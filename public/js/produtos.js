const track = document.querySelector('.product__list')
const btns = document.querySelectorAll('.product__single__brt')
const products = document.querySelectorAll('.products__card')

let currentProduct = 0
let startX = 0

btns.forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.dataset.id

        btn.classList.toggle('product__single__brt--active')
        btn.classList.toggle('product__single__brt--active')

        if (id == 0) {
            currentProduct--
            toggleProduct(currentProduct)
        } else if (id == 1) {
            currentProduct++
            toggleProduct(currentProduct)
        }
    })
});

track.addEventListener("touchstart", (e) => {
    startX = e.touches[0].clientX;
});

track.addEventListener("touchend", (e) => {
    const endX = e.changedTouches[0].clientX;
    const distance = startX - endX;

    console.log(distance);

    if (distance > 50) {
        currentProduct++
        toggleProduct(currentProduct)

    } else if (distance < -50) {
        currentProduct--
        toggleProduct(currentProduct)
    }
});

function toggleProduct(id) {

    if(id < 0) {
        currentProduct = products.length - 1
        // console.log(currentProduct)
    }else if(id > products.length - 1){
        currentProduct = 0
        // console.log(currentProduct)
    }

    track.style.transform = `translateX(-${currentProduct * 100}%)`

    console.log(currentProduct)

}

