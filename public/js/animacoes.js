import { animate, stagger } from './vendor/anime.esm.min.js'

// Animações de entrada: data-anim, data-anim-grupo (filhos em sequência) e data-contar.

const EFEITOS = {
    sobe: { y: { from: 24, to: 0 } },
    zoom: { scale: { from: 0.94, to: 1 } },
    surge: {},
}

const DURACAO = 800
const INTERVALO = 90
const DURACAO_CONTADOR = 1600

const html = document.documentElement

// Sem a classe do head, não anima.
if (html.classList.contains('anim-pendente')) {
    iniciar()
}

// Prepara os alvos e revela cada um ao entrar na tela.
function iniciar() {
    const efeitoDe = new Map()

    document.querySelectorAll('[data-anim]').forEach((el) => {
        if (estaNaTela(el)) efeitoDe.set(el, el.dataset.anim)
    })

    document.querySelectorAll('[data-anim-grupo]').forEach((grupo) => {
        for (const filho of grupo.children) {
            if (estaNaTela(filho)) efeitoDe.set(filho, grupo.dataset.animGrupo)
        }
    })

    const alvos = [...efeitoDe.keys()]
    const contadores = [...document.querySelectorAll('[data-contar]')].filter(estaNaTela)

    html.classList.remove('anim-pendente')
    const opacidade = preparar(alvos)
    contadores.forEach(zerarContador)

    const pendentes = new Set([...alvos, ...contadores])

    const observador = new IntersectionObserver((entradas) => {
        const porEfeito = {}

        entradas.forEach(({ isIntersecting, target }) => {
            if (!isIntersecting) return

            for (const el of [target, ...irmaosForaDaTela(target)]) {
                if (!pendentes.delete(el)) continue
                observador.unobserve(el)

                if (el.hasAttribute('data-contar')) contar(el)
                if (efeitoDe.has(el)) (porEfeito[efeitoDe.get(el)] ??= []).push(el)
            }
        })

        Object.entries(porEfeito).forEach(([efeito, els]) => revelar(els, efeito, opacidade))
    }, { rootMargin: '0px 0px -10% 0px' })

    pendentes.forEach((el) => observador.observe(el))
}

// Ignora elementos com display: none.
function estaNaTela(el) {
    return el.getClientRects().length > 0
}

// Irmãos fora da tela na horizontal (carrossel) aparecem junto.
function irmaosForaDaTela(el) {
    const grupo = el.parentElement
    if (!grupo?.hasAttribute('data-anim-grupo')) return []

    return [...grupo.children].filter((irmao) => {
        const { left, right } = irmao.getBoundingClientRect()
        return right <= 0 || left >= window.innerWidth
    })
}

// Esconde os alvos e desliga a transition; retorna a opacidade original.
function preparar(alvos) {
    const opacidade = new Map(alvos.map((el) => [el, Number(getComputedStyle(el).opacity)]))

    alvos.forEach((el) => {
        el.style.transition = 'none'
        el.style.opacity = '0'
    })

    return opacidade
}

// Anima em sequência e devolve o controle ao CSS no fim.
function revelar(els, efeito, opacidade) {
    animate(els, {
        ...(EFEITOS[efeito] ?? EFEITOS.sobe),
        opacity: { from: 0, to: (el) => opacidade.get(el) ?? 1 },
        duration: DURACAO,
        delay: stagger(INTERVALO),
        ease: 'outCubic',
        onComplete: () => els.forEach(limpar),
    })
}

// Remove os estilos inline da animação.
function limpar(el) {
    el.style.removeProperty('opacity')
    el.style.removeProperty('transform')
    el.style.removeProperty('transition')
}

// Separa "366K+" em prefixo, número e sufixo.
function partesDoNumero(el) {
    const [, antes, numero, depois] = el.dataset.contarTexto.match(/^(\D*)(\d+)(.*)$/s) ?? []
    return numero ? { antes, numero: Number(numero), depois } : null
}

// Guarda o texto original e mostra 0.
function zerarContador(el) {
    el.dataset.contarTexto = el.textContent.trim()
    const partes = partesDoNumero(el)
    if (partes) el.textContent = `${partes.antes}0${partes.depois}`
}

// Conta de 0 até o valor original.
function contar(el) {
    const partes = partesDoNumero(el)
    if (!partes) return

    const valor = { atual: 0 }

    animate(valor, {
        atual: partes.numero,
        duration: DURACAO_CONTADOR,
        ease: 'outExpo',
        onUpdate: () => {
            el.textContent = `${partes.antes}${Math.round(valor.atual)}${partes.depois}`
        },
        onComplete: () => {
            el.textContent = el.dataset.contarTexto
        },
    })
}
