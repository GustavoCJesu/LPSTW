const API_URL = 'https://brasilapi.com.br/api/cnpj/v1/'
const TIMEOUT_MS = 8000

const cache = new Map()

export function buscarCnpj(cnpj) {
    if (!cache.has(cnpj)) {
        const consulta = consultar(cnpj)
        cache.set(cnpj, consulta)

        consulta.then(({ status }) => {
            if (status === 'erro') cache.delete(cnpj)
        })
    }

    return cache.get(cnpj)
}

async function consultar(cnpj) {
    try {
        const response = await fetch(API_URL + cnpj, {
            signal: AbortSignal.timeout(TIMEOUT_MS),
        })

        if (response.status === 404) return { status: 'nao_encontrado' }
        if (!response.ok) return { status: 'erro' }

        return { status: 'encontrado', empresa: await response.json() }
    } catch (e) {
        console.warn('Falha ao consultar CNPJ na BrasilAPI:', e)
        return { status: 'erro' }
    }
}
