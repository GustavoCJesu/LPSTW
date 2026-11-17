// APIs em ordem; confirmarNaoEncontrado refaz o 404 furando o cache.
const FONTES = [
    { url: 'https://brasilapi.com.br/api/cnpj/v1/', confirmarNaoEncontrado: false },
    { url: 'https://minhareceita.org/', confirmarNaoEncontrado: true },
]
const TIMEOUT_MS = 5000

// Cache das consultas por CNPJ.
const cache = new Map()

// Consulta com cache (erros não ficam no cache).
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

// Tenta cada API: 'encontrado', 'nao_encontrado' ou 'erro'.
async function consultar(cnpj) {
    let status = 'nao_encontrado'

    for (const fonte of FONTES) {
        let resultado = await consultarUrl(fonte.url + cnpj)

        if (resultado.status === 'nao_encontrado' && fonte.confirmarNaoEncontrado) {
            resultado = await consultarUrl(`${fonte.url}${cnpj}?atualizar=${Date.now()}`)
        }

        if (resultado.status === 'encontrado') return resultado
        if (resultado.status === 'erro') status = 'erro'
    }

    return { status }
}

// Consulta uma URL e traduz a resposta em status.
async function consultarUrl(url) {
    try {
        const response = await fetch(url, {
            signal: AbortSignal.timeout(TIMEOUT_MS),
        })

        if (response.status === 404) return { status: 'nao_encontrado' }
        if (!response.ok) return { status: 'erro' }

        return { status: 'encontrado', empresa: await response.json() }
    } catch (e) {
        console.warn(`Falha ao consultar CNPJ em ${url}:`, e)
        return { status: 'erro' }
    }
}
