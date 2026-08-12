const track = document.querySelector('.product__list')
const btns = document.querySelectorAll('.product__single__brt')
const products = document.querySelectorAll('.products__card')

const btnOrcamento = document.querySelectorAll('.card__cta__btn')
const cards = document.querySelectorAll('.card')

const mensagens = ['Olá, gostaria de conhecer melhor o locker inteligente para armazenamento e controle de retirada de EPIs. Tenho interesse em entender suas funcionalidades e como essa solução pode otimizar a gestão dos equipamentos.',

'Olá, gostaria de obter mais informações sobre o balcão de atendimento para gerenciamento e distribuição de EPIs. Tenho interesse em conhecer melhor a solução e entender como ela pode atender às necessidades da minha operação.',

'Olá, gostaria de receber mais informações sobre o dispenser de 36 slots. Tenho interesse em conhecer essa solução de distribuição automatizada de EPIs e avaliar sua aplicação na minha empresa.',

'Olá, gostaria de saber mais sobre o dispenser de 60 slots. Tenho interesse em conhecer essa solução de maior capacidade e entender como ela pode contribuir para uma operação mais eficiente e organizada.'
]


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
    }else if(id > products.length - 1){
        currentProduct = 0
    }

    track.style.transform = `translateX(-${currentProduct * 100}%)`

}

btnOrcamento.forEach(btn => {
    btn.addEventListener('click', ()=>{
        const id = btn.dataset.id
        automaticMSG(id)
    })
})

cards.forEach(card => {
    card.addEventListener('click', (event) => {
        if (event.target.closest('.js-expandable')) return
        if (event.target.closest('.card__cta__btn')) return

        card.querySelector('.card__cta__btn')?.click()
    })
})

const mensage = document.querySelector('#mensage')

function automaticMSG(id){

    if(mensage.value != ''){

        mensage.value =  ''
        mensage.value += mensagens[id]

    }else{
        mensage.value += mensagens[id]
    }

}

