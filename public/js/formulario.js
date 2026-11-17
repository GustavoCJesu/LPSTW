import { buscarCnpj } from './cnpjApi.js'

const form = document.querySelector('#leadForm')
const formWrapper = document.querySelector('.form__wrapper')
const formSuccess = document.querySelector('#formSuccess')
const formSuccessReset = document.querySelector('#formSuccessReset')
const errorCard = document.querySelector('.feedback__card.error')
const errorMessage = errorCard.querySelector('.feedback__card__message')
const errorMessageDefault = errorMessage.textContent.trim()

const cnpj = document.querySelector('#cnpj')
const cnpjMask = IMask(cnpj, {
    mask: '##.###.###/####-00',
    definitions: {
        '#': /[0-9A-Za-z]/,
    },
    prepareChar: (str) => str.toUpperCase(),
})

const telefone = document.querySelector('#telefone')
const telefoneMask = IMask(telefone, {
    mask: '(00) 00000-0000'
})

const PESOS_DV1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]
const PESOS_DV2 = [6, ...PESOS_DV1]

function digitoVerificador(codigo, pesos) {
    const soma = pesos.reduce((total, peso, i) => total + (codigo.charCodeAt(i) - 48) * peso, 0)
    const resto = soma % 11
    return resto < 2 ? 0 : 11 - resto
}

function cnpjValido(codigo) {
    if (!/^[0-9A-Z]{12}\d{2}$/.test(codigo) || /^(.)\1+$/.test(codigo)) return false

    const dv1 = digitoVerificador(codigo, PESOS_DV1)
    const dv2 = digitoVerificador(codigo, PESOS_DV2)
    return codigo.endsWith(`${dv1}${dv2}`)
}

const regras = {
    nome(valor) {
        if (!valor) return 'Informe seu nome completo.'
        if (valor.length < 3) return 'O nome deve ter pelo menos 3 letras.'
        return ''
    },
    cnpj(valor) {
        const codigo = valor.toUpperCase().replace(/[^0-9A-Z]/g, '')
        if (!codigo) return 'Informe o CNPJ da empresa.'
        if (codigo.length < 14) return 'O CNPJ deve ter 14 caracteres.'
        if (!cnpjValido(codigo)) return 'CNPJ inválido. Confira o que foi digitado.'
        return ''
    },
    email(valor) {
        if (!valor) return 'Informe seu email corporativo.'
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(valor)) return 'Digite um email válido. Ex: nome@empresa.com.br'
        return ''
    },
}

const campos = Object.entries(regras).map(([id, validar]) => ({
    input: document.getElementById(id),
    erro: document.getElementById(`${id}Error`),
    validar,
}))

function mostrarErro({ input, erro }, mensagem) {
    const invalido = Boolean(mensagem)

    input.classList.toggle('input--invalid', invalido)
    input.setAttribute('aria-invalid', String(invalido))

    if (invalido) {
        erro.textContent = mensagem
        erro.classList.remove('errorMsg--info')
    }
    erro.classList.toggle('hidden', !invalido)
}

function mostrarInfo({ input, erro }, mensagem) {
    input.classList.remove('input--invalid')
    input.setAttribute('aria-invalid', 'false')
    erro.textContent = mensagem
    erro.classList.remove('hidden')
    erro.classList.add('errorMsg--info')
}

function validarCampo(campo) {
    const mensagem = campo.validar(campo.input.value.trim())
    mostrarErro(campo, mensagem)
    return !mensagem
}

function limparErros() {
    campos.forEach((campo) => mostrarErro(campo, ''))
}

campos.forEach((campo) => {
    const { input } = campo

    input.addEventListener('blur', () => {
        if (input.value.trim() || input.classList.contains('input--invalid')) {
            validarCampo(campo)
        }
    })

    input.addEventListener('input', () => {
        if (input.classList.contains('input--invalid')) {
            validarCampo(campo)
        }
    })
})

const campoCnpj = campos.find((campo) => campo.input === cnpj)

async function consultarCnpj() {
    const codigo = cnpjMask.unmaskedValue

    mostrarInfo(campoCnpj, 'Consultando CNPJ...')
    const { status, empresa } = await buscarCnpj(codigo)

    if (cnpjMask.unmaskedValue !== codigo) return

    const nome = empresa?.nome_fantasia || empresa?.razao_social
    if (nome) {
        mostrarInfo(campoCnpj, `Empresa: ${nome}`)
    } else if (status === 'nao_encontrado') {
        mostrarInfo(campoCnpj, 'Não encontramos os dados desta empresa, mas você pode enviar normalmente.')
    } else {
        mostrarInfo(campoCnpj, 'Não foi possível consultar o CNPJ agora, mas você pode enviar normalmente.')
    }
}

cnpj.addEventListener('blur', () => {
    if (!regras.cnpj(cnpj.value.trim())) {
        consultarCnpj()
    }
})

cnpj.addEventListener('input', () => {
    if (!cnpj.classList.contains('input--invalid')) {
        mostrarErro(campoCnpj, '')
    }
})

const FEEDBACK_DURATION = 5000

function hideFeedback(card) {
    if (!card) return

    clearTimeout(card._hideTimeout)
    card.classList.remove('feedback__card--actvie', 'feedback__card--timer')
}

function showFeedback(card) {
    if (!card) return

    hideFeedback(card)

    card.classList.add('feedback__card--actvie')

    card.classList.remove('feedback__card--timer')
    void card.offsetWidth
    requestAnimationFrame(() => {
        card.classList.add('feedback__card--timer')
    })

    card._hideTimeout = setTimeout(() => hideFeedback(card), FEEDBACK_DURATION)
}

document.addEventListener('click', (event) => {
    const closeIcon = event.target.closest('.feedback__card h2 svg')
    if (closeIcon) {
        hideFeedback(closeIcon.closest('.feedback__card'))
    }
})

function mostrarSucesso() {
    hideFeedback(errorCard)

    formWrapper.hidden = true
    formSuccess.hidden = false

    formSuccess.focus({ preventScroll: true })
    formSuccess.scrollIntoView({ behavior: 'smooth', block: 'center' })
}

function mostrarFormulario() {
    formSuccess.hidden = true
    formWrapper.hidden = false

    document.getElementById('nome').focus()
}

formSuccessReset.addEventListener('click', mostrarFormulario)

// Mostra os erros devolvidos pelo servidor embaixo de cada campo.
// Retorna false se algum erro não tiver campo correspondente na tela.
function mostrarErrosDoServidor(erros) {
    const comCampo = campos.filter((campo) => erros[campo.input.id])

    comCampo.forEach((campo) => mostrarErro(campo, erros[campo.input.id]))
    comCampo[0]?.input.focus()

    return comCampo.length === Object.keys(erros).length
}

function limparFormulario() {
    form.reset()
    cnpjMask.updateValue()
    telefoneMask.updateValue()
    limparErros()
}

form.addEventListener('submit', async (event) => {

    event.preventDefault()

    const invalidos = campos.filter((campo) => !validarCampo(campo))
    if (invalidos.length) {
        invalidos[0].input.focus()
        return
    }

    const formData = new FormData(form)

    const response = await fetch('/sendForm', {
        method: 'POST',
        body: formData
    })

    const result = await response.json()

    if (result.success) {
        limparFormulario()
        mostrarSucesso()
    } else if (!(result.errors && mostrarErrosDoServidor(result.errors))) {
        errorMessage.textContent = result.message || errorMessageDefault
        showFeedback(errorCard)
    }

    if (window.grecaptcha) {
        grecaptcha.reset()
    }
})
