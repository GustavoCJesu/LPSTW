// Carrega os scripts de cada seção da página.
import './header.js'
import './hero.js'
import './produtos.js'
import './sobreSTW.js'
import './software.js'
import './depoimento.js'
import './formulario.js'
import './lightbox.js'

// Animações à parte: se falharem, o resto da página continua funcionando.
import('./animacoes.js').catch((erro) => {
    document.documentElement.classList.remove('anim-pendente')
    console.warn('Animações desativadas:', erro)
})
