const topicData = {
    0: {
        title: "Dashboard",
        description: "Tenha uma visão completa da operação em tempo real, acompanhando entregas, retiradas, indicadores de consumo e informações importantes para uma gestão mais eficiente dos EPIs.",
    },
    1: {
        title: "GHE",
        description: "Organize os Grupos Homogêneos de Exposição e defina quais EPIs cada colaborador pode acessar de acordo com sua função, garantindo controle e conformidade no fornecimento.",
    },
    2: {
        title: "Entrega Online",
        description: "Automatize a entrega de EPIs com registros digitais, controle de retiradas e acompanhamento do histórico de cada colaborador, reduzindo processos manuais e aumentando a eficiência.",
    },
    3: {
        title: "Projetos",
        description: "Gerencie diferentes operações e projetos com configurações personalizadas, mantendo o controle dos equipamentos, equipes e necessidades específicas de cada ambiente.",
    }
}

const topics = document.querySelectorAll('.software__singleTopic')
const active = "software__singleTopic--active"

let lastTopic = 0
let automaticId = 1

let intervalo

topics.forEach(topic => {
    topic.addEventListener('click', (e) => {
        const id = topic.dataset.id
        toggleTopic(id)
        resetSlide()
    })

})

function toggleTopic(id) {

    const topicTitle = document.querySelector('.software__topic__title')
    const topicDescripition = document.querySelector('.software__topic__description')

    automaticId = id
    topics[id].classList.toggle(active)
    topics[lastTopic].classList.toggle(active)
    lastTopic = id

    const data = topicData[id]
    
    topicTitle.textContent = data.title
    topicDescripition.textContent = data.description



}

function automaticTopic() {
    if (automaticId >= topics.length - 1) {
        toggleTopic(automaticId)
        automaticId = 0
    } else {
        toggleTopic(automaticId)
        automaticId++
    }
}

function initSlide() {
    intervalo = setInterval(() => {
        automaticTopic()
    }, 5000)
}

function resetSlide() {
    clearInterval(intervalo)
    initSlide()
}

// initSlide()



