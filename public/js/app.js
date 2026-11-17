// Carrega os scripts de cada seção da página.
import './header.js'
import './hero.js'
import './produtos.js'
import './sobreSTW.js'
import './software.js'
import './formulario.js'
import './lightbox.js'

// Depoimentos só quando a seção estiver na página.
if (document.querySelector('#evidence')) import('./depoimento.js')

// Animações à parte: se falharem, o resto continua funcionando.
import('./animacoes.js').catch((erro) => {
    document.documentElement.classList.remove('anim-pendente')
    console.warn('Animações desativadas:', erro)
})
