const form = document.querySelector('#leadForm')
const successCard = document.querySelector('.feedback__card:not(.error)')
const errorCard = document.querySelector('.feedback__card.error')
const errorMessage = errorCard.querySelector('.feedback__card__message')
const errorMessageDefault = errorMessage.textContent.trim()

const FEEDBACK_DURATION = 5000

function hideFeedback(card) {
    if (!card) return

    clearTimeout(card._hideTimeout)
    card.classList.remove('feedback__card--actvie', 'feedback__card--timer')
}

function showFeedback(card) {
    if (!card) return

    hideFeedback(successCard)
    hideFeedback(errorCard)

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

form.addEventListener('submit', async (event) => {

    event.preventDefault()

    const formData = new FormData(form)

    const response = await fetch('/sendForm', {
        method: 'POST',
        body: formData
    })

    const result = await response.json()

    if (result.success) {
        form.reset()
        showFeedback(successCard)
    } else {
        errorMessage.textContent = result.message || errorMessageDefault
        showFeedback(errorCard)
    }

    if (window.grecaptcha) {
        grecaptcha.reset()
    }
})


const cnpj = document.querySelector('#cnpj')
IMask(cnpj, {
    mask: '00.000.000/0000-00'
})

const telefone = document.querySelector('#telefone')
IMask(telefone, {
    mask: '(00) 00000-0000'
})