const topicData = {
    0: {
        title: "Inicio",
        description: "Tenha um resumo completo da operação assim que acessa o sistema: retiradas, requisições e alertas importantes, como EPIs vencendo ou equipamentos desconectados, com acesso rápido aos principais módulos.",
        img: '/images/inicio.webp'
    },
    1: {
        title: "GHE",
        description: "Configure os Grupos Homogêneos de Exposição e defina quais EPIs cada categoria pode utilizar, com regras de quantidade, período de uso e alertas de vencimento personalizados por grupo.",
        img: '/images/ghe.webp'
    },
    2: {
        title: "Relatorios",
        description: "Acesse um catálogo completo de relatórios: retiradas, saldos, vencimentos e pendências por colaborador, além de entregas por responsável e abastecimento das máquinas.",
        img: '/images/relatorios.webp'
    },
    3: {
        title: "Dashboard",
        description: "Acompanhe indicadores em tempo real com gráficos de consumo, comparativos entre períodos e alertas críticos, como CAs vencidos e colaboradores com EPI vencido, filtrando por empresa e período.",
        img: '/images/dashboard.webp'
    },
    4: {
        title: "Registro",
        description: "Registre e acompanhe cada retirada e requisição de EPI em tempo real, com histórico detalhado por colaborador, produto e data, além de estatísticas como variação mensal e pendências.",
        img: '/images/registro.webp'
    }
}

const topics = document.querySelectorAll('.software__singleTopic')
const active = "software__singleTopic--active"

const img = document.querySelector('.software__img')

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
    img.src = data.img



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

initSlide()



