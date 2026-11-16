const form = document.querySelector('#leadForm')
const formWrapper = document.querySelector('.form__wrapper')
const formSuccess = document.querySelector('#formSuccess')
const formSuccessReset = document.querySelector('#formSuccessReset')
const errorCard = document.querySelector('.feedback__card.error')
const errorMessage = errorCard.querySelector('.feedback__card__message')
const errorMessageDefault = errorMessage.textContent.trim()

// Máscaras: precisam ser registradas antes da validação,
// para que o listener de "input" leia o valor já formatado
const cnpj = document.querySelector('#cnpj')
const cnpjMask = IMask(cnpj, {
    mask: '00.000.000/0000-00'
})

const telefone = document.querySelector('#telefone')
const telefoneMask = IMask(telefone, {
    mask: '(00) 00000-0000'
})

// ---------- Validação dos campos ----------

const PESOS_DV1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]
const PESOS_DV2 = [6, ...PESOS_DV1]

function digitoVerificador(numeros, pesos) {
    const soma = pesos.reduce((total, peso, i) => total + Number(numeros[i]) * peso, 0)
    const resto = soma % 11
    return resto < 2 ? 0 : 11 - resto
}

function cnpjValido(numeros) {
    if (numeros.length !== 14 || /^(\d)\1+$/.test(numeros)) return false

    const dv1 = digitoVerificador(numeros, PESOS_DV1)
    const dv2 = digitoVerificador(numeros, PESOS_DV2)
    return numeros.endsWith(`${dv1}${dv2}`)
}

// Cada regra recebe o valor do campo e retorna a mensagem de erro (ou '' se estiver ok)
const regras = {
    nome(valor) {
        if (!valor) return 'Informe seu nome completo.'
        if (valor.length < 3) return 'O nome deve ter pelo menos 3 letras.'
        return ''
    },
    cnpj(valor) {
        const numeros = valor.replace(/\D/g, '')
        if (!numeros) return 'Informe o CNPJ da empresa.'
        if (numeros.length < 14) return 'O CNPJ deve ter 14 dígitos.'
        if (!cnpjValido(numeros)) return 'CNPJ inválido. Confira os números digitados.'
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
    erro.textContent = mensagem
    erro.classList.toggle('hidden', !invalido)
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

    // Valida ao sair do campo (sem acusar erro em campo que só recebeu foco)
    input.addEventListener('blur', () => {
        if (input.value.trim() || input.classList.contains('input--invalid')) {
            validarCampo(campo)
        }
    })

    // Se já está com erro, revalida enquanto digita para o erro sumir assim que corrigir
    input.addEventListener('input', () => {
        if (input.classList.contains('input--invalid')) {
            validarCampo(campo)
        }
    })
})

// ---------- Feedback de envio ----------

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

// ---------- Troca formulário <-> mensagem de sucesso ----------

function mostrarSucesso() {
    hideFeedback(errorCard)

    formWrapper.hidden = true
    formSuccess.hidden = false

    // o formulário encolhe ao sumir, então centraliza a mensagem na tela
    formSuccess.focus({ preventScroll: true })
    formSuccess.scrollIntoView({ behavior: 'smooth', block: 'center' })
}

function mostrarFormulario() {
    formSuccess.hidden = true
    formWrapper.hidden = false

    document.getElementById('nome').focus()
}

formSuccessReset.addEventListener('click', mostrarFormulario)

function limparFormulario() {
    form.reset()
    // o reset altera os inputs "por fora" do IMask, então sincroniza as máscaras
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
    } else {
        errorMessage.textContent = result.message || errorMessageDefault
        showFeedback(errorCard)
    }

    if (window.grecaptcha) {
        grecaptcha.reset()
    }
})
