// Seção do software: lista de módulos com avanço automático.

const secao = document.querySelector('#software')
const modulos = [...secao.querySelectorAll('.software__modulo')]
const telas = [...secao.querySelectorAll('.software__tela')]
const nomeNaJanela = secao.querySelector('.software__janela__modulo')

let atual = 0

// Ativa o módulo: texto, tela e nome na janela.
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

// Clique mostra o módulo e desliga o avanço automático.
modulos.forEach((modulo, i) => {
    modulo.querySelector('.software__modulo__botao').addEventListener('click', () => {
        secao.classList.remove('software--automatico')
        ativar(i)
    })
})

// Fim da barra de progresso: vai para o próximo módulo.
modulos.forEach((modulo) => {
    modulo.querySelector('.software__progresso > span').addEventListener('animationend', () => {
        ativar((atual + 1) % modulos.length)
    })
})

// Avanço automático só com a seção na tela e sem "reduzir movimento".
if (!matchMedia('(prefers-reduced-motion: reduce)').matches) {
    secao.classList.add('software--automatico')

    new IntersectionObserver(([entrada]) => {
        secao.classList.toggle('software--visivel', entrada.isIntersecting)
    }, { rootMargin: '-35% 0px -35% 0px' }).observe(secao)
}
