import { animate, stagger } from './vendor/anime.esm.min.js'

// Animações de entrada da página (anime.js v4).
//
// Uso no HTML:
//   data-anim="sobe"          o elemento sobe e aparece ao entrar na tela (padrão)
//   data-anim="zoom"          cresce um pouco e aparece
//   data-anim="surge"         só aparece (fade)
//   data-anim-grupo="sobe"    aplica o efeito em cada filho; os que entram juntos animam em sequência
//   data-contar               conta de 0 até o número do texto (ex.: "366K+")

const EFEITOS = {
    sobe: { y: { from: 24, to: 0 } },
    zoom: { scale: { from: 0.94, to: 1 } },
    surge: {},
}

const DURACAO = 800
const INTERVALO = 90
const DURACAO_CONTADOR = 1600

const html = document.documentElement

// Sem a classe, ou o usuário prefere menos movimento, ou o fallback do head já mostrou tudo.
if (html.classList.contains('anim-pendente')) {
    iniciar()
}

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

    // Tudo no mesmo frame: tira a classe do head e esconde via inline, sem piscar.
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

// Ignora o que está com display: none (ex.: blocos só de mobile no desktop).
function estaNaTela(el) {
    return el.getClientRects().length > 0
}

// Carrosséis: filhos do grupo fora da tela na horizontal nunca "entram" sozinhos, então aparecem junto.
function irmaosForaDaTela(el) {
    const grupo = el.parentElement
    if (!grupo?.hasAttribute('data-anim-grupo')) return []

    return [...grupo.children].filter((irmao) => {
        const { left, right } = irmao.getBoundingClientRect()
        return right <= 0 || left >= window.innerWidth
    })
}

// Esconde os alvos e desliga a transition do CSS (ela brigaria com o anime.js a cada frame).
// Retorna a opacidade original de cada um, para animar até ela.
function preparar(alvos) {
    const opacidade = new Map(alvos.map((el) => [el, Number(getComputedStyle(el).opacity)]))

    alvos.forEach((el) => {
        el.style.transition = 'none'
        el.style.opacity = '0'
    })

    return opacidade
}

// Anima os elementos em sequência e, no fim, devolve o controle ao CSS (:hover etc.).
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

function zerarContador(el) {
    el.dataset.contarTexto = el.textContent.trim()
    const partes = partesDoNumero(el)
    if (partes) el.textContent = `${partes.antes}0${partes.depois}`
}

// Conta de 0 até o valor original, mantendo prefixo e sufixo.
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
