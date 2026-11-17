// Fontes consultadas em ordem. A BrasilAPI não tem alguns CNPJs ativos,
// então, se ela não encontrar ou falhar, tentamos a Minha Receita (mesmo formato de resposta).
//
// A Minha Receita fica atrás de um cache da Cloudflare que guarda respostas por até 5 dias,
// inclusive "não encontrado". Por isso, quando ela diz que não encontrou, confirmamos uma vez
// direto na origem (o parâmetro extra na URL fura o cache).
const FONTES = [
    { url: 'https://brasilapi.com.br/api/cnpj/v1/', confirmarNaoEncontrado: false },
    { url: 'https://minhareceita.org/', confirmarNaoEncontrado: true },
]
const TIMEOUT_MS = 5000

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

// 'encontrado' se alguma fonte tiver o CNPJ; 'erro' se alguma falhou e nenhuma encontrou
// (vale tentar de novo depois); 'nao_encontrado' se todas responderam que não existe.
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
