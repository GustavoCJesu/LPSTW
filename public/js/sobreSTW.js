const modalDate = {
    0: {
        title: "Gestão Inteligente",
        description: "Acompanhe todos os dados e indicadores da operação em um único painel. Visualize informações atualizadas em tempo real, identifique tendências rapidamente e tenha mais controle sobre retiradas, devoluções e estoque de EPIs.",
        image: "/icons/ilustracoes/sobreSTW/ilu1_SobreSTW.svg"
    },
    1: {
        title: "Controle Total",
        description: "Tenha uma visão completa de toda a operação. Acompanhe colaboradores, equipamentos disponíveis, retiradas realizadas e prazos de reposição em um único ambiente.",
        image: "/icons/ilustracoes/sobreSTW/ilu2_SobreSTW.svg"
    },
    2: {
        title: "Conformidade Garantida",
        description: "Mantenha sua empresa alinhada às normas de segurança com registros automatizados e rastreabilidade completa das movimentações de EPIs, facilitando auditorias e garantindo maior segurança.",
        image: "/icons/ilustracoes/sobreSTW/ilu3_SobreSTW.svg"
    },
    3: {
        title: "Mais Eficiência",
        description: "Reduza processos manuais, elimine desperdícios e otimize a rotina da sua equipe. A STW automatiza a entrega de EPIs para que sua operação ganhe produtividade e economia.",
        image: "/icons/ilustracoes/sobreSTW/ilu4_SobreSTW.svg"
    },
}


const aboutUsTopicBtns = document.querySelectorAll('.aboutUs__topic')

const modalOverlay = document.querySelector(".modal__overlay")
const modal = document.querySelector('.modal')

aboutUsTopicBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.dataset.id
        openModal(id)
    })
})

modal.addEventListener('click',()=>{
    closeModal()
})


function openModal(id) {

    const date = modalDate[id]

    modalOverlay.classList.toggle('modal__overlay--closed')
    modal.classList.toggle('modal--closed')

    const modalIMG = document.querySelector(".modal__img")
    const modalTitle = document.querySelector(".modal__h1__title")
    const modalDescription = document.querySelector(".modal__p__description")

    modalIMG.src = date.image
    modalTitle.textContent = date.title
    modalDescription.textContent = date.description

}

function closeModal() {
    const modalOverlay = document.querySelector(".modal__overlay")
    const modal = document.querySelector('.modal')

    modalOverlay.classList.toggle('modal__overlay--closed')
    modal.classList.toggle('modal--closed')
}