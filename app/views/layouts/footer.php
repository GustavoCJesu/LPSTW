<?php
// Rodapé: marca, navegação, produtos e contato; faixa final com copyright, privacidade e logos.
$produtosRodape = ['Locker Inteligente', 'Balcão de Atendimento', 'Dispenser 36 Slots', 'Dispenser 60 Slots'];
?>
<footer class="footer">
    <div class="footer__conteudo">
        <div class="footer__marca">
            <img class="footer__logo" src="/images/logo/logo.png" alt="STW - Safe to Work" width="512" height="245" loading="lazy">
            <p class="footer__slogan">Software e máquinas de liberação inteligente de EPIs para sua operação.</p>
            <p class="footer__origem">Uma solução da ASW Presvida, na segurança do trabalho desde 1999.</p>
        </div>

        <nav class="footer__coluna" aria-label="Navegação do rodapé">
            <h3 class="footer__titulo">Navegação</h3>
            <ul class="footer__lista">
                <li><a href="<?= $prefixoAncora ?>#quemSomos">Quem somos</a></li>
                <li><a href="<?= $prefixoAncora ?>#aboutUs">O que é a STW?</a></li>
                <li><a href="<?= $prefixoAncora ?>#software">Software Web</a></li>
                <li><a href="<?= $prefixoAncora ?>#products">Nossos produtos</a></li>
            </ul>
        </nav>

        <div class="footer__coluna">
            <h3 class="footer__titulo">Produtos</h3>
            <ul class="footer__lista">
                <?php foreach ($produtosRodape as $produto): ?>
                    <li><a href="<?= $prefixoAncora ?>#products"><?= $produto ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="footer__coluna footer__contato">
            <h3 class="footer__titulo">Contato</h3>
            <a class="footer__email" href="mailto:contato@stw.com.br">
                <span class="footer__icone"><i data-lucide="mail"></i></span>
                contato@stw.com.br
            </a>
            <p class="footer__prazo">
                <span class="footer__icone"><i data-lucide="clock"></i></span>
                Retorno em até 1 dia útil
            </p>
            <a class="footer__cta" href="<?= $prefixoAncora ?>#form">
                Solicitar orçamento <i data-lucide="arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="footer__base">
        <div class="footer__base__conteudo">
            <p class="footer__copyright">© <?= date('Y') ?> STW — Safe to Work. Todos os direitos reservados.</p>
            <a class="footer__base__link" href="/politica-de-privacidade">Política de Privacidade</a>
            <div class="footer__parceiros">
                <img src="/images/logo/logoSempher.png" alt="Sempher Solutions" width="1254" height="385" loading="lazy">
                <img src="/images/logo/logoASW.png" alt="ASW Presvida" width="1491" height="516" loading="lazy">
            </div>
            <a class="footer__base__link footer__topo" href="#">
                Voltar ao topo <i data-lucide="arrow-up"></i>
            </a>
        </div>
    </div>
</footer>

<?php if ($pagina === 'home'): ?>
    <script src="https://unpkg.com/imask"></script>
    <script type="module" src="/js/app.js"></script>
<?php else: ?>
    <script type="module" src="/js/header.js"></script>
<?php endif; ?>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        if (window.lucide) lucide.createIcons();
        else console.error("Lucide não carregou: /js/vendor/lucide.min.js");
    });
</script>
</body>

</html>
