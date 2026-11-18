<?php
// Slides da hero: fotos do Pexels (licença livre) em /images/hero; "foco" é o enquadramento no desktop.
$slidesHero = [
    [
        'titulo' => 'Equipe sempre protegida',
        'foto' => 'conformidade',
        'foco' => '60% 50%',
        'alt' => 'Galpão industrial com trabalhadores de capacete e uniforme operando máquinas',
    ],
    [
        'titulo' => 'Estoque sob controle',
        'foto' => 'gestao',
        'foco' => '55% 50%',
        'alt' => 'Almoxarifado organizado com funcionários de colete refletivo em suas estações de trabalho',
    ],
    [
        'titulo' => 'Cada retirada registrada',
        'foto' => 'controle',
        'foco' => '35% 50%',
        'alt' => 'Funcionário retirando uma caixa da prateleira do almoxarifado',
    ],
];
?>
<section class="hero">
    <div class="hero__headLine" data-anim-grupo="sobe">
        <h3 class="hero__topTitle">Safe to Work</h3>
        <h1 class="hero__titulo">
            Mantenha sua operação em <span class="destaque">conformidade</span> o tempo todo!
        </h1>
        <p>
            Automatize a gestão de EPIs, acompanhe cada entrega em tempo real e reduza desperdícios com uma plataforma completa.
        </p>
        <?php $text = 'Conheça nossas soluções!';
        $link = '#products';
        require __DIR__ . '/../components/ctaMobile.php' ?>
    </div>
    <div class="hero__viewrPoint" data-anim="zoom">
        <div class="hero__janela">
            <div class="hero__track">
                <?php foreach ($slidesHero as $i => $slide): ?>
                    <div class="hero__slide">
                        <figure class="hero__foto" style="--foco: <?= $slide['foco'] ?>">
                            <h2 class="hero__title"><?= $slide['titulo'] ?></h2>
                            <img class="hero__img"
                                src="/images/hero/<?= $slide['foto'] ?>-720.webp"
                                srcset="/images/hero/<?= $slide['foto'] ?>-720.webp 720w, /images/hero/<?= $slide['foto'] ?>-1200.webp 1200w, /images/hero/<?= $slide['foto'] ?>-1600.webp 1600w"
                                sizes="(min-width: 1024px) 60vw, 100vw"
                                width="1200" height="900"
                                fetchpriority="<?= $i === 0 ? 'high' : 'low' ?>"
                                alt="<?= $slide['alt'] ?>">
                        </figure>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="hero__dots">
            <?php foreach ($slidesHero as $i => $slide): ?>
                <button data-id="<?= $i ?>" class="hero__dot<?= $i === 0 ? ' hero__dot--active' : '' ?>" aria-label="Mostrar: <?= $slide['titulo'] ?>"></button>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="hero__cta" data-anim="sobe">
        <?php $text = "Conheça nossas soluções!";
        $link = "#software";
        require __DIR__ . "/../components/ctaMobile.php" ?>
    </div>
</section>