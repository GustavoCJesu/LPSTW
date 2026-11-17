// Seção "Software Web": a lista de módulos troca a tela exibida na janela.
// O avanço automático é guiado pela barra de progresso (animação CSS): quando ela termina, vai
// para o próximo módulo. Pausa fora da tela e no hover; para de vez quando o usuário clica.

const secao = document.querySelector('#software')
const modulos = [...secao.querySelectorAll('.software__modulo')]
const telas = [...secao.querySelectorAll('.software__tela')]
const nomeNaJanela = secao.querySelector('.software__janela__modulo')

let atual = 0

// Ativa o módulo: expande o texto, mostra a tela e atualiza o nome na barra da janela.
function ativar(indice) {
    atual = indice

    modulos.forEach((modulo, i) => {
        const ativo = i === indice
        modulo.classList.toggle('software__modulo--ativo', ativo)
        modulo.querySelector('.software__modulo__botao').setAttribute('aria-expanded', String(ativo))
    })
    telas.forEach((tela, i) => tela.classList.toggle('software__tela--ativa', i === indice))

    nomeNaJanela.textContent = modulos[indice].querySelector('.software__modulo__titulo').textContent
}

// Clique: mostra o módulo e desliga o avanço automático (o usuário assumiu o controle).
modulos.forEach((modulo, i) => {
    modulo.querySelector('.software__modulo__botao').addEventListener('click', () => {
        secao.classList.remove('software--automatico')
        ativar(i)
    })
})

// Fim da barra de progresso do módulo ativo: avança para o próximo.
modulos.forEach((modulo) => {
    modulo.querySelector('.software__progresso > span').addEventListener('animationend', () => {
        ativar((atual + 1) % modulos.length)
    })
})

// Avanço automático só para quem não pediu menos movimento, e só com a seção na tela.
if (!matchMedia('(prefers-reduced-motion: reduce)').matches) {
    secao.classList.add('software--automatico')

    // "Na tela" = a seção cruza a faixa do meio da viewport (funciona mesmo se ela for mais alta que a tela).
    new IntersectionObserver(([entrada]) => {
        secao.classList.toggle('software--visivel', entrada.isIntersecting)
    }, { rootMargin: '-35% 0px -35% 0px' }).observe(secao)
}
