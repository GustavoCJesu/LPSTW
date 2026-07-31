<section class="aboutUs">
    <div>
        <h1 class="aboutUs__title">
            O QUE É A STW?
        </h1>
        <p class="aboutUs__description">
            Conheça a STW e entenda nosso propósito.
        </p>
    </div>
    <div class="aboutUs__cardsGrid">
        <button onclick="openModal(0)">
            <div class="aboutUs__card">
                <h2>Gestão<br />Inteligente</h2>
                <img src="/icons/ilustracoes/sobreSTW/ilu1_SobreSTW.svg" />
                <i class="aboutUs__icon__cta" data-lucide="ArrowRight"></i>
            </div>
        </button>
        <button onclick="openModal(1)">
            <div class="aboutUs__card">
                <h2>Controle<br />Total</h2>
                <img src="/icons/ilustracoes/sobreSTW/ilu2_SobreSTW.svg" />
                <i class="aboutUs__icon__cta" data-lucide="ArrowRight"></i>
            </div>
        </button>
        <button onclick="openModal(2)">
            <div class="aboutUs__card">
                <h2>Conformidade Garantida</h2>
                <img src="/icons/ilustracoes/sobreSTW/ilu3_SobreSTW.svg" />
                <i class="aboutUs__icon__cta" data-lucide="ArrowRight"></i>
            </div>
        </button>
        <button onclick="openModal(3)">
            <div class="aboutUs__card">
                <h2>Mais<br />Eficiência</h2>
                <img src="/icons/ilustracoes/sobreSTW/ilu4_SobreSTW.svg" />
                <i class="aboutUs__icon__cta" data-lucide="ArrowRight"></i>
            </div>
        </button>
    </div>
    <?php $text = "Entre em contato"; $link = "https://www.youtube.com/"; require __DIR__ . "/../components/ctaMobile.php"?>
</section>